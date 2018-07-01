<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Activity
 *
 * @property-read \App\User $user
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id
 * @property string $op
 * @property string|null $old
 * @property string|null $new
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereNew($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereOld($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereOp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereUserId($value)
 */
class Activity extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'op', 'old', 'new'];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
