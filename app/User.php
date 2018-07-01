<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $email
 * @property string|null $verification_token
 * @property string $password
 * @property int $admin
 * @property string|null $verified
 * @property string|null $last_active
 * @property string|null $banned
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereBanned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereVerificationToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereVerified($value)
 * @mixin \Eloquent
 * @property-read string $gravatar
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Activity[] $activity
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'email',
        'verification_token',
        'password',
        'admin',
        'last_active',
        'banned',
        'verified',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['gravatar',];


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['last_active'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'verification_token',
    ];

    /**
     * Returns user gravatar
     *
     * @return string
     */
    public function getGravatarAttribute(): string
    {
        return 'https://www.gravatar.com/avatar/'.md5($this->email).'?d=mm&s=256';
    }

    /**
     * @return HasMany
     */
    public function activity(): HasMany
    {
        return $this->hasMany(Activity::class);
    }
}
