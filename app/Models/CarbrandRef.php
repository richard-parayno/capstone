<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 21 Nov 2017 09:25:44 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CarbrandRef
 * 
 * @property int $carBrandID
 * @property string $carBrandName
 * 
 * @property \Illuminate\Database\Eloquent\Collection $vehicles_mvs
 *
 * @package App\Models
 */
class CarbrandRef extends Eloquent
{
	protected $table = 'carbrand_ref';
	protected $primaryKey = 'carBrandID';
	public $timestamps = false;

	protected $fillable = [
		'carBrandName'
	];

	public function vehicles_mvs()
	{
		return $this->hasMany(\App\Models\VehiclesMv::class, 'carBrandID');
	}
}
