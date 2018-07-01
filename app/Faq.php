<?php

namespace App;

use App\kitano\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Faq
 *
 * @property int $id
 * @property string $name
 * @property string $title
 * @property string $slug
 * @property string $body
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Faq whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Faq whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Faq whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Faq whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Faq whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Faq whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Faq whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $order
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Faq whereOrder($value)
 */
class Faq extends Model
{
    use Translatable;

    public $translatable = ['title', 'slug', 'body'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'title',
        'body',
        'order'
    ];
}
