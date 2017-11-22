<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 22 Nov 2017 05:43:21 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Institution
 * 
 * @property int $institutionID
 * @property string $institutionName
 * @property int $schoolTypeID
 * @property string $location
 * 
 * @property \App\Models\SchooltypeRef $schooltype_ref
 * @property \Illuminate\Database\Eloquent\Collection $deptsperinstitutions
 * @property \Illuminate\Database\Eloquent\Collection $institutionbatchplants
 * @property \Illuminate\Database\Eloquent\Collection $monthlyemissionsperschools
 * @property \Illuminate\Database\Eloquent\Collection $vehicles_mvs
 *
 * @package App\Models
 */
class Institution extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'schoolTypeID' => 'int'
	];

	protected $fillable = [
		'schoolTypeID',
		'institutionName',
		'location'
	];

	public function schooltype_ref()
	{
		return $this->belongsTo(\App\Models\SchooltypeRef::class, 'schoolTypeID');
	}

	public function deptsperinstitutions()
	{
		return $this->hasMany(\App\Models\Deptsperinstitution::class, 'institutionID');
	}

	public function institutionbatchplants()
	{
		return $this->hasMany(\App\Models\Institutionbatchplant::class, 'institutionID');
	}

	public function monthlyemissionsperschools()
	{
		return $this->hasMany(\App\Models\Monthlyemissionsperschool::class, 'institutionID');
	}

	public function vehicles_mvs()
	{
		return $this->hasMany(\App\Models\VehiclesMv::class, 'institutionID');
	}
}
