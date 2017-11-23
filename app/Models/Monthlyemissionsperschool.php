<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 22 Nov 2017 05:43:21 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Monthlyemissionsperschool
 * 
 * @property \Carbon\Carbon $monthYear
 * @property int $institutionID
 * @property int $emission
 * 
 * @property \App\Models\Institution $institution
 *
 * @package App\Models
 */
class Monthlyemissionsperschool extends Eloquent
{
	protected $table = 'monthlyemissionsperschool';
	protected $primaryKey = 'monthYear';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'institutionID' => 'int',
		'emission' => 'int'
	];

	protected $dates = [
		'monthYear'
	];

	protected $fillable = [
		'institutionID',
		'emission'
	];

	public function institution()
	{
		return $this->belongsTo(\App\Models\Institution::class, 'institutionID');
	}
}