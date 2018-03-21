<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 27 Nov 2017 16:20:51 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Trip
 * 
 * @property int $tripID
 * @property int $deptID
 * @property string $plateNumber
 * @property int $kilometerReading
 * @property string $remarks
 * @property float $emissions
 * 
 * @property \App\Models\Deptsperinstitution $deptsperinstitution
 * @property \App\Models\VehiclesMv $vehicles_mv
 *
 * @package App\Models
 */
class Trip extends Eloquent
{
	protected $primaryKey = 'tripID';
	public $timestamps = false;

	protected $casts = [
		'deptID' => 'int',
		'kilometerReading' => 'decimal',
		'emissions' => 'float',
	];

	protected $fillable = [
		'deptID',
		'plateNumber',
		'kilometerReading',
		'remarks',
		'emissions',
		'tripDate',
		'tripTime'
	];

	public function deptsperinstitution()
	{
		return $this->belongsTo(\App\Models\Deptsperinstitution::class, 'deptID');
	}

	public function vehicles_mv()
	{
		return $this->belongsTo(\App\Models\VehiclesMv::class, 'plateNumber');
	}

	private function getTime() {
		return date("H:i", strtotime($this->attributes['tripTime']));          
	}
}
