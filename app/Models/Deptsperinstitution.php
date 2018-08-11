<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 27 Nov 2017 16:20:51 +0000.
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
	];

	protected $fillable = [
		'institutionID',
		'deptName',
		'motherDeptID'
	];

	public function institution()
	{
		return $this->belongsTo(\App\Models\Institution::class, 'institutionID');
	}

	public function trips()
	{
		return $this->hasMany(\App\Models\Trip::class, 'deptID');
	}
}
