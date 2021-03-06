<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 27 Nov 2017 16:20:51 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Monthlyemission
 * 
 * @property \Carbon\Carbon $MONTHYEAR
 * @property int $emission
 *
 * @package App\Models
 */
class Monthlyemission extends Eloquent
{
	protected $primaryKey = 'MONTHYEAR';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'emission' => 'int'
	];

	protected $dates = [
		'MONTHYEAR'
	];

	protected $fillable = [
		'emission'
	];
}
