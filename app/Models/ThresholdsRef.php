<?php

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

class ThresholdsRef extends Eloquent
{
	protected $table = 'thresholds_ref';
	protected $primaryKey = 'name';
	public $timestamps = false;
    protected $keyType = 'string';

	protected $fillable = [
		'value'
	];

}
