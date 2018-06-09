<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 01 Feb 2018 10:54:10 +0000.
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
 * @package App\Models
 */
class Institution extends Eloquent
{
	protected $primaryKey = 'institutionID';
	public $timestamps = false;

	protected $casts = [
		'schoolTypeID' => 'int'
	];

	protected $fillable = [
		'institutionName',
		'schoolTypeID',
		'location'
	];
}
