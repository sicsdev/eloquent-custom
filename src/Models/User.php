<?php

namespace Saritasa\Database\Eloquent\Models;

use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Saritasa\Database\Eloquent\Entity;

/**
 * Class User
 *
 * @package App\Model
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property string $role
 * @property-read string $full_name
 */
class User extends Entity implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, SoftDeletes, Notifiable;

    const EMAIL = 'email';
    const FIRST_NAME = 'first_name';
    const LAST_NAME = 'last_name';
    const FULL_NAME = 'full_name';
    const ROLE = 'role';
    const PWD_FIELD = 'password';

    const REMEMBER_TOKEN = 'remember_token';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        self::CREATED_AT,
        self::UPDATED_AT,
        self::DELETED_AT,
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        self::ID,
        self::EMAIL,
        self::FIRST_NAME,
        self::LAST_NAME,
        self::ROLE,
        self::CREATED_AT
    ];

    /**
     * The attributes that should be visible in arrays for self profile.
     *
     * @var array
     */
    protected $profileVisible = [
        self::ID,
        self::EMAIL,
        self::FIRST_NAME,
        self::LAST_NAME,
        self::CREATED_AT,
        self::UPDATED_AT
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::EMAIL,
        self::FIRST_NAME,
        self::LAST_NAME,
        self::PWD_FIELD,
        self::ROLE,
    ];

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        self::ID,
        self::REMEMBER_TOKEN,
        self::CREATED_AT,
        self::UPDATED_AT,
    ];

    /**
     * The attributes that should not be visible in arrays.
     *
     * @var array
     */
    protected $hidden = [
        self::PWD_FIELD,
        self::REMEMBER_TOKEN,
        self::UPDATED_AT,
        self::DELETED_AT,
    ];

    /**
     * Set visible attributes for self profile
     *
     * @return User
     */
    public function setProfileVisible()
    {
        $this->setVisible($this->profileVisible);
        return $this;
    }

    /**
     * Validate password
     *
     * @param string $password
     *
     * @return boolean
     */
    public function passwordCheck($password)
    {
        return password_verify($password, $this->password);
    }

    /**
     * Encodes the user's password.
     *
     * @param string $password
     * @return string
     * @access public
     * @static
     */
    protected static function encodePassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Sets the user's password.
     *
     * @param string $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = static::encodePassword($password);
    }

    /**
     * Gets "last_name first_name"
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "$this->last_name $this->first_name";
    }

    /**
     * Return array of rules for model validation
     *
     * @return array
     */
    public function getRules()
    {
        $rules = [
            static::FIRST_NAME => "required|max:100",
            static::LAST_NAME => "required|max:100",
            static::EMAIL => "required|max:100|email|unique:users,email,{$this->id},id",
        ];
        if (!$this->id) {
            $rules[static::PWD_FIELD] = 'required|min:' . config('app.model.user.password.min', 6)
                . '|max:' . config('app.model.user.password.max', 20);
        }
        return $rules;
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
}
