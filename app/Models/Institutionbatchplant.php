<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 27 Nov 2017 16:20:51 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Institutionbatchplant
 * 
 * @property int $batchPlantID
 * @property int $institutionID
 * @property int $numOfPlantedTrees
 * @property \Carbon\Carbon $datePlanted
 * 
 * @property \App\Models\Institution $institution
 *
 * @package App\Models
 */
class Institutionbatchplant extends Eloquent
{
	protected $table = 'institutionbatchplant';
	protected $primaryKey = 'batchPlantID';
	public $timestamps = false;

	protected $casts = [
		'institutionID' => 'int',
		'numOfPlantedTrees' => 'int'
	];

	protected $dates = [
		'datePlanted'
	];

	protected $fillable = [
		'institutionID',
		'numOfPlantedTrees',
		'datePlanted'
	];

	public function institution()
	{
		return $this->belongsTo(\App\Models\Institution::class, 'institutionID');
	}
}
