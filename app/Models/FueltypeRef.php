<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 21 Nov 2017 09:25:44 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class FueltypeRef
 * 
 * @property int $fuelTypeID
 * @property string $fuelTypeName
 * 
 * @property \Illuminate\Database\Eloquent\Collection $vehicles_mvs
 *
 * @package App\Models
 */
class FueltypeRef extends Eloquent
{
	protected $table = 'fueltype_ref';
	protected $primaryKey = 'fuelTypeID';
	public $timestamps = false;

	protected $fillable = [
		'fuelTypeName'
	];

	public function vehicles_mvs()
	{
		return $this->hasMany(\App\Models\VehiclesMv::class, 'fuelTypeID');
	}
}
