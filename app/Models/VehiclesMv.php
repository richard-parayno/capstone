<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 22 Nov 2017 05:43:21 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class VehiclesMv
 * 
 * @property string $plateNumber
 * @property int $institutionID
 * @property int $carTypeID
 * @property int $carBrandID
 * @property int $fuelTypeID
 * @property string $modelName
 * @property int $active
 * 
 * @property \App\Models\CarbrandRef $carbrand_ref
 * @property \App\Models\CartypeRef $cartype_ref
 * @property \App\Models\FueltypeRef $fueltype_ref
 * @property \App\Models\Institution $institution
 * @property \Illuminate\Database\Eloquent\Collection $trips
 *
 * @package App\Models
 */
class VehiclesMv extends Eloquent
{
	protected $table = 'vehicles_mv';
	protected $primaryKey = 'plateNumber';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'institutionID' => 'int',
		'carTypeID' => 'int',
		'carBrandID' => 'int',
		'fuelTypeID' => 'int',
		'active' => 'int'
	];

	protected $fillable = [
		'institutionID',
		'plateNumber',
		'carTypeID',
		'carBrandID',
		'fuelTypeID',
		'modelName',
		'active'
	];

	public function carbrand_ref()
	{
		return $this->belongsTo(\App\Models\CarbrandRef::class, 'carBrandID');
	}

	public function cartype_ref()
	{
		return $this->belongsTo(\App\Models\CartypeRef::class, 'carTypeID');
	}

	public function fueltype_ref()
	{
		return $this->belongsTo(\App\Models\FueltypeRef::class, 'fuelTypeID');
	}

	public function institution()
	{
		return $this->belongsTo(\App\Models\Institution::class, 'institutionID');
	}

	public function trips()
	{
		return $this->hasMany(\App\Models\Trip::class, 'plateNumber');
	}
}
