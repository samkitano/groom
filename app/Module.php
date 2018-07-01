<?php

namespace App;

use App\kitano\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Module
 *
 * @property int $id
 * @property string $name
 * @property array $title
 * @property array $body
 * @property array $properties
 * @property int $order
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereProperties($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $page
 * @property string|null $more
 * @property string|null $bg
 * @property array $css
 * @property-read mixed $style
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ModuleSection[] $sections
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereBg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereCss($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereMore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module wherePage($value)
 * @property int $page_id
 * @property string|null $image
 * @property string|null $class
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module wherePageId($value)
 * @property int $image_outside
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereImageOutside($value)
 * @property string|null $css_class
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereCssClass($value)
 */
class Module extends Model
{
    use Translatable;

    /**
     * Columns with translations
     *
     * @var array
     */
    public $translatable = ['title', 'body',];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'css' => 'array',
        'page_id' => 'int',
        'order' => 'int',
        'image_outside' => 'bool',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['style',];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'page_id',
        'more',
        'title',
        'body',
        'image',
        'image_outside',
        'class',
        'css',
        'order',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    /**
     * @return string
     */
    public function getStyleAttribute(): string
    {
        $style = '';

        if (isset($this->image) && ! $this->image_outside) {
            $style .= 'background: url('.url('img').'/'.$this->image.');background-repeat:no-repeat;background-position:center;background-size:cover;';
        }

        if (count($this->css)) {
            $style .= $this->getStyles($this->css);
        }

        return $style;
    }

    /**
     * @param $css
     * @return string
     */
    protected function getStyles($css): string
    {
        $res = [];
        $styles = array_keys($css);

        foreach ($styles as $style) {
            if (! empty($css[$style])) {
                $res[] = $style.':'.$css[$style];
            }
        }

        if (count($res)) {
            return implode(';', $res).';';
        }

        return '';
    }
}
