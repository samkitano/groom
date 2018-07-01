<?php

namespace App\Kitano\Traits;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use App\Kitano\Exceptions\MediaNotFound;
use Intervention\Image\ImageManagerStatic as ImageManager;

trait Media
{
    use Cacheable;

    /**
     * All Cached media
     *
     * @return mixed
     */
    public function all()
    {
        return $this->remember('ALL_MEDIA', $this->getMedia());
    }

    /**
     * Find a medium
     *
     * @param int $id
     * @return array
     * @throws MediaNotFound
     */
    public function find($id): array
    {
        $media = collect($this->all());
        $medium = $media->where('id', $id)->first();

        if (! count($medium)) {
            throw new MediaNotFound('Media Not Found in Cache');
        }

        return (array) $medium;
    }

    /**
     * Merge aditional file info
     *
     * @param array $file
     * @return array
     */
    public function getImgInfo(array $file): array
    {
        if ($file['type'] !== 'image') {
            return $file;
        }

        $image = ImageManager::make($file['path']);

        $file['width'] = $image->width();
        $file['height'] = $image->height();
        $file['exif'] = $image->exif();

        $image->destroy();

        return $file;
    }

    /**
     * Get media by type
     *
     * @param $type
     * @return Collection
     */
    public function getByType($type): Collection
    {
        $all = collect($this->all());

        return $all->where('type', $type);
    }

    /**
     * Save an uploaded file
     *
     * @param $file
     * @return JsonResponse
     */
    public function save($file): JsonResponse
    {
        $this->checkDirectories();

        $path = Storage::disk('media')
            ->putFile('site', $file);

        if ($path) {
            $this->makeThumb($path)
                ->forget('ALL_MEDIA');

            return response()->json($path);
        }

        return response()->json('ERROR', 422);
    }

    /**
     * Unlink media file
     * @todo: Throw error instead of a 404 response
     * @param string $file
     * @return JsonResponse
     */
    public function delete(string $file): JsonResponse
    {
        if (file_exists($file)) {
            unlink($file);

            $this->unlinkThumb(basename($file))
                ->forget('ALL_MEDIA');

            return response()->json('OK');
        }

        return response()->json('File not found', 404);
    }

    /**
     * Check and create if necessary for the required folders
     *
     * @return $this
     */
    protected function checkDirectories()
    {
        if (! is_dir(public_path('media'))) {
            mkdir(public_path('media'));
        }

        if (! is_dir(public_path('media/site'))) {
            Storage::makeDirectory('site');
        }

        if (! is_dir(public_path('media/thumbs/site'))) {
            Storage::makeDirectory('thumbs/site');
        }

        return $this;
    }

    /**
     * Extract the file type from mime
     *
     * @param string $mime
     * @return string
     */
    protected function getFileType(string $mime): string
    {
        return strtok($mime, '/');
    }

    /**
     * Retrieves stored media files
     *
     * @return array
     */
    protected function getMedia(): array
    {
        $res = [];
        $media = Storage::files('site');
        $counter = 1;

        foreach ($media as $medium) {
            $res[] = $this->mediaDetails($medium, $counter);
            $counter++;
        }

        return $res;
    }

    /**
     * Create thumbnails
     *
     * @param $path
     * @return $this
     */
    protected function makeThumb($path): self
    {
        $type = $this->getFileType(Storage::disk('media')->mimeType($path));

        if ($type !== 'image') {
            return $this;
        }

        $image = ImageManager::make(public_path('media').'/'.$path);
        $dest = public_path('media/thumbs/'.$path);

        $image->resize(null, 48, function ($constraint) {
            $constraint->aspectRatio();
        })->save($dest);

        $image->destroy();

        return $this;
    }

    /**
     * Retrieve media details
     *
     * @param $file
     * @param $counter
     * @return array
     */
    protected function mediaDetails($file, $counter): array
    {
        $mime = Storage::disk('media')->mimeType($file);
        $modified = Storage::disk('media')->lastModified($file);
        $dt = Carbon::createFromTimestamp($modified);
        $hasThumb = file_exists(public_path("media/thumbs/{$file}"));

        return [
            'id' => $counter,
            'name' => basename($file),
            'path' => public_path("media/{$file}"),
            'url' => url("media/{$file}"),
            'type' => $this->getFileType($mime),
            'size' => human_file_size(Storage::disk('media')->size($file)),
            'uploaded' => $dt,
            // 'uploaded_human' => $dt->diffForHumans(), // NOPE. This shit is CACHED!
            'mime' => $mime,
            'thumb' => $hasThumb ? url("media/thumbs/{$file}") : false,
        ];
    }

    /**
     * Unlink thumbnail
     *
     * @param $file
     * @return $this
     */
    protected function unlinkThumb($file): self
    {
        if (file_exists(public_path('media/thumbs/site/'.$file))) {
            unlink(public_path('media/thumbs/site/'.$file));
        }

        return $this;
    }
}
