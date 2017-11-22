<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 22 Nov 2017 05:43:21 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CartypeRef
 * 
 * @property int $carTypeID
 * @property string $carTypeName
 * 
 * @property \Illuminate\Database\Eloquent\Collection $vehicles_mvs
 *
 * @package App\Models
 */
class CartypeRef extends Eloquent
{
	protected $table = 'cartype_ref';
	protected $primaryKey = 'carTypeID';
	public $timestamps = false;

	protected $fillable = [
		'carTypeName'
	];

	public function vehicles_mvs()
	{
		return $this->hasMany(\App\Models\VehiclesMv::class, 'carTypeID');
	}
}
