<?php

namespace Natyka\Traits;

use Natyka\Models\Rating;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

// Clase 9
// Relaciones Polimórficas en Eloquent


trait CanBeRated
{
	public function qualifications(): HasMany
	{
		$hasMany = $this->hasMany(Rating::class, 'rateable_id');

		return $hasMany
			->where('rateable_type', $this->getMorphClass());
	}


	public function qualifiers($model = null): MorphToMany
	{
		$modelClass = $model ? (new $model)->getMorphClass() : $this->getMorphClass();

		return $this->morphToMany($modelClass, 'rateable', 'ratings', 'rateable_id', 'qualifier_id')
			->withPivot('qualifier_type', 'score')
			->wherePivot('qualifier_type', $modelClass)
			->wherePivot('rateable_type', $this->getMorphClass());
	}


	public function averageRating(string $model = null)
	{
		return $this->qualifiers($model)->avg("score") ?: 0.0;
	}
}
