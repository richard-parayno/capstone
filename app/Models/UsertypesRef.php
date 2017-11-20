<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 20 Nov 2017 01:59:34 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class UsertypesRef
 * 
 * @property int $userTypeID
 * @property string $userTypeName
 * 
 * @property \Illuminate\Database\Eloquent\Collection $users
 *
 * @package App\Models
 */
class UsertypesRef extends Eloquent
{
	protected $table = 'usertypes_ref';
	protected $primaryKey = 'userTypeID';
	public $timestamps = false;

	protected $fillable = [
		'userTypeName'
	];

	public function users()
	{
		return $this->belongsTo('App\User', 'userID');
	}
}
