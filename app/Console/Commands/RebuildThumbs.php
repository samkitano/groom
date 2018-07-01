<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as ImageManager;

class RebuildThumbs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'thumbs:rebuild';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerate site thumbnails';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->removeThumbs()
             ->recreate();
    }

    protected function removeThumbs()
    {
        $thumbs = Storage::disk('media')->files('thumbs/site');

        Storage::disk('media')->delete($thumbs);

        $this->info('Old Thumbs deleted;');

        return $this;
    }

    /**
     * Recreate all thumbs
     */
    protected function recreate()
    {
        $images = Storage::disk('media')->files('site');

        foreach ($images as $image) {
            $this->makeThumb($image);
        }

        $this->info('New Thumbs Created!');
    }

    /**
     * Create a thumbnail
     *
     * @param $file
     */
    protected function makeThumb($file)
    {
        $image = ImageManager::make(public_path('media').'/'.$file);
        $mime = $image->mime();
        $exp = explode('/', $mime);

        if ($exp[0] !== 'image') {
            $image->destroy();
            return;
        }

        $dest = public_path('media/thumbs/'.$file);

        $image->resize(null, 48, function ($constraint) {
            $constraint->aspectRatio();
        })->save($dest);

        $image->destroy();
    }
}
