<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 21 Nov 2017 09:25:44 +0000.
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
		'kilometerReading' => 'int'
	];

	protected $fillable = [
		'deptID',
		'plateNumber',
		'kilometerReading',
		'remarks'
	];

	public function deptsperinstitution()
	{
		return $this->belongsTo(\App\Models\Deptsperinstitution::class, 'deptID');
	}

	public function vehicles_mv()
	{
		return $this->belongsTo(\App\Models\VehiclesMv::class, 'plateNumber');
	}
}
