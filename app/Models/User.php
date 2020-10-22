<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;


// implements MustVerifyEmailを削除した
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'company',
        'post_code',
        'address1',
        'address2',
        'address3',
        'address_remark',
        'url',
        'attr',
        'condition',
        'first_name',
        'last_name',
        'first_name_kana',
        'last_name_kana',
        'mobile',
        'tel',
        'fax',
        'pay_method',
        'pay_limit',
        'pay_post_code',
        'pay_address1',
        'pay_address2',
        'pay_address3',
        'pay_remark',
        'attention',
        'remark',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function searchs(
        $freeword,
        $id,
        $status,
        $company,
        $attr,
        $person_name,
        $mobile,
        $tel,
        $email,
        $attention
    ) {
        if (isset($freeword)) {
            return self::where('id', 'LIKE', "%$freeword%")
                ->orWhere('status', 'LIKE', "%$freeword%")
                ->orWhere('company', 'LIKE', "%$freeword%")
                ->orWhere('attr', 'LIKE', "%$freeword%")
                ->orWhere('first_name', 'LIKE', "%$freeword%")
                ->orWhere('last_name', 'LIKE', "%$freeword%")
                ->orWhere('mobile', 'LIKE', "%$freeword%")
                ->orWhere('tel', 'LIKE', "%$freeword%")
                ->orWhere('email', 'LIKE', "%$freeword%")
                ->orWhere('attention', 'LIKE', "%$freeword%")->paginate(10);
        } else if (isset($id)) {
            return self::where('id', 'LIKE', "%$id%")->paginate(10);
        } else if (isset($status)) {
            return self::where('status', 'LIKE', "%$status%")->paginate(10);
        } else if (isset($company)) {
            return self::where('company', 'LIKE', "%$company%")->paginate(10);
        } else if (isset($attr)) {
            return self::where('attr', 'LIKE', "%$attr%")->paginate(10);
        } else if (isset($person_name)) {
            return self::where('first_name', 'LIKE', "%$person_name%")
                ->orWhere('last_name', 'LIKE', "%$person_name%")->paginate(10);
        } else if (isset($mobile)) {
            return self::where('mobile', 'LIKE', "%$mobile%")->paginate(10);
        } else if (isset($company)) {
            return self::where('company', 'LIKE', "%$company%")->paginate(10);
        } else if (isset($tel)) {
            return self::where('tel', 'LIKE', "%$tel%")->paginate(10);
        } else if (isset($email)) {
            return self::where('email', 'LIKE', "%$email%")->paginate(10);
        } else if (isset($attention)) {
            return self::where('attention', 'LIKE', "%$attention%")->paginate(10);
        } else {
            return self::query()->paginate(10);
        }
    }
}
