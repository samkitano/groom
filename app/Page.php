<?php

namespace App;

use App\kitano\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Page
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Module[] $modules
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @mixin \Eloquent
 * @property string $name
 * @property string $route_name
 * @property array $slug
 * @property array $title
 * @property array $heading
 * @property array $body
 * @property array $seo
 * @property mixed $attributes
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereHeading($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereRouteName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereSeo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereUpdatedAt($value)
 * @property-read mixed $last_update
 * @property string|null $meta_tags
 * @property string $robots
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereMetaTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereRobots($value)
 */
class Page extends Model
{
    use Translatable;

    /**
     * Columns with translations
     *
     * @var array
     */
    public $translatable = ['slug', 'title', 'heading', 'body', 'seo',];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'route_name',
        'slug',
        'title',
        'heading',
        'body',
        'seo',
        'meta_tags',
        'robots'
    ];

    /**
     * @return HasMany
     */
    public function modules(): HasMany
    {
        return $this->hasMany(Module::class);
    }
}
