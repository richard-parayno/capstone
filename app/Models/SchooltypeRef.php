<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 21 Nov 2017 09:25:44 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class SchooltypeRef
 * 
 * @property int $schoolTypeID
 * @property string $schoolTypeName
 * 
 * @property \Illuminate\Database\Eloquent\Collection $institutions
 *
 * @package App\Models
 */
class SchooltypeRef extends Eloquent
{
	protected $table = 'schooltype_ref';
	protected $primaryKey = 'schoolTypeID';
	public $timestamps = false;

	protected $fillable = [
		'schoolTypeName'
	];

	public function institutions()
	{
		return $this->hasMany(\App\Models\Institution::class, 'schoolTypeID');
	}
}
