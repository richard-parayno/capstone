<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 27 Nov 2017 16:20:51 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class User
 * 
 * @property int $userID
 * @property string $username
 * @property int $userTypeID
 * @property string $accountName
 * @property string $email
 * @property string $password
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $created_at
 * @property string $remember_token
 * @property string $status
 * 
 * @property \App\Models\UsertypesRef $usertypes_ref
 *
 * @package App\Models
 */
class User extends Eloquent
{
	protected $casts = [
		'userTypeID' => 'int'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'userTypeID',
		'accountName',
		'email',
		'password',
		'remember_token',
		'status'
	];

	public function usertypes_ref()
	{
		return $this->belongsTo(\App\Models\UsertypesRef::class, 'userTypeID');
	}
}
