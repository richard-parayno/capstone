<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 27 Nov 2017 16:20:51 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CartypeRef
 * 
 * @property int $carTypeID
 * @property string $carTypeName
 * @property float $mpg
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

	protected $casts = [
		'mpg' => 'float'
	];

	protected $fillable = [
		'carTypeName',
		'mpg'
	];

	public function vehicles_mvs()
	{
		return $this->hasMany(\App\Models\VehiclesMv::class, 'carTypeID');
	}
}
