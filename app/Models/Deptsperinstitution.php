<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 22 Nov 2017 05:43:21 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Deptsperinstitution
 * 
 * @property int $deptID
 * @property int $institutionID
 * @property string $deptName
 * @property int $motherDeptID
 * 
 * @property \App\Models\Deptsperinstitution $deptsperinstitution
 * @property \App\Models\Institution $institution
 * @property \Illuminate\Database\Eloquent\Collection $deptsperinstitutions
 * @property \Illuminate\Database\Eloquent\Collection $trips
 *
 * @package App\Models
 */
class Deptsperinstitution extends Eloquent
{
	protected $table = 'deptsperinstitution';
	protected $primaryKey = 'deptID';
	public $timestamps = false;

	protected $casts = [
		'institutionID' => 'int',
		'motherDeptID' => 'int'
	];

	protected $fillable = [
		'institutionID',
		'deptName',
		'motherDeptID'
	];

	public function deptsperinstitution()
	{
		return $this->belongsTo(\App\Models\Deptsperinstitution::class, 'motherDeptID');
	}

	public function institution()
	{
		return $this->belongsTo(\App\Models\Institution::class, 'institutionID');
	}

	public function deptsperinstitutions()
	{
		return $this->hasMany(\App\Models\Deptsperinstitution::class, 'motherDeptID');
	}

	public function trips()
	{
		return $this->hasMany(\App\Models\Trip::class, 'deptID');
	}
}
