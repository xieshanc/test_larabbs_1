<?php

namespace App\Models;

use Auth;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;

class User extends Authenticatable implements MustVerifyEmailContract, JWTSubject
{
    use Notifiable, MustVerifyEmailTrait;
    use HasRoles;
    use Traits\ActiveUserHelper;
    use Traits\LastActivedAtHelper;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone', 'email', 'password', 'introduction', 'avatar',
        'weixin_openid', 'weixin_unionid', 'registration_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'weixin_openid', 'weixin_unionid'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'bound_phone',
        'bound_email',
        'bound_wechat',
    ];

    public function isAuthorOf($model)
    {
        return $this->id === $model->user_id;
    }

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function topicRepliesNotify($instance)
    {
        if ($this->id == Auth::id()) return;

        if (method_exists($instance, 'toDatabase')) {
            $this->increment('notification_count');
        }

        $this->notify($instance);
    }

    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }

    public function getBoundPhoneAttribute()
    {
        return $this->phone ? true : false;
    }

    public function getBoundEmailAttribute()
    {
        return $this->email ? true : false;
    }

    public function getBoundWechatAttribute()
    {
        return ($this->weixin_unionid || $this->weixin_openid) ? true : false;
    }

    public function setPasswordAttribute($value)
    {
        if (strlen($value) < 60) {
            $value = bcrypt($value);
        }
        $this->attributes['password'] = $value;
    }

    public function setAvatarAttribute($path)
    {
        if (!\Str::startsWith($path, 'http')) {
            $path = config('app.url') . "/uploads/images/avatars/{$path}";
        }
        $this->attributes['avatar'] = $path;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
