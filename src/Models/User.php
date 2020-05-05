<?php

namespace Saritasa\Database\Eloquent\Models;

use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as IAuthenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as IAuthorizable;
use Illuminate\Contracts\Auth\CanResetPassword as ICanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail as IMustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Saritasa\Database\Eloquent\Entity;
use Tymon\JWTAuth\Contracts\JWTSubject;

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
 * @property int $role_id
 * @property-read string $full_name
 */
class User extends Entity implements IAuthenticatable, ICanResetPassword, IAuthorizable, IMustVerifyEmail, JWTSubject
{
    use Authenticatable, CanResetPassword, SoftDeletes, Notifiable, Authorizable, MustVerifyEmail;

    const EMAIL = 'email';
    const FIRST_NAME = 'first_name';
    const LAST_NAME = 'last_name';
    const FULL_NAME = 'full_name';
    const ROLE_ID = 'role_id';
    const PWD_FIELD = 'password';
    const AVATAR = 'avatar';
    const EMAIL_VERIFIED_AT = 'email_verified_at';

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
        self::CREATED_AT
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
        self::AVATAR,
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
        self::ROLE_ID
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return integer
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Check, if password matches saved password hash
     *
     * @param string $password Plain text password (unencrypted)
     *
     * @return boolean
     */
    public function passwordCheck($password)
    {
        return password_verify($password, $this->password);
    }

    /**
     * Encodes the user's password (remember hash)
     *
     * @param string $password Plain text password (unencrypted)
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
     * @param string $password Plain text password (unencrypted)
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = static::encodePassword($password);
    }

    /**
     * Gets "last_name first_name"
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "$this->last_name $this->first_name";
    }

    /**
     * Return array of rules for model validation
     *
     * @deprecated Declare rules in Form Request: https://laravel.com/docs/5.5/validation#form-request-validation
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
     * Determine if the user has verified their email address.
     *
     * @return boolean
     */
    public function hasVerifiedEmail()
    {
        return ! is_null($this->getAttributeValue(static::EMAIL_VERIFIED_AT));
    }

    /**
     * Mark the given user's email as verified.
     *
     * @return boolean
     */
    public function markEmailAsVerified()
    {
        return $this->forceFill([
            static::EMAIL_VERIFIED_AT => $this->freshTimestamp(),
        ])->save();
    }
}
