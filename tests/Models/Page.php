<?php

namespace Natyka\Test\Models;

use Illuminate\Database\Eloquent\Model;
use Natyka\Contracts\Rating;
use Natyka\Traits\CanBeRated;
use Natyka\Traits\CanRate;

class Page extends Model implements Rating
{
	use CanRate, CanBeRated;

	protected $fillable = [
		'name',
	];

	public function name(): string
	{
		return $this->name;
	}
}
