<?php

namespace Natyka\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Natyka\Events\ModelRated;
use Natyka\Contracts\Rateable;
use Natyka\Exceptions\InvalidScore;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

// Clase 9
// Relaciones Polimórficas en Eloquent

trait CanRate
{
	public function ratings($model = null): MorphToMany
	{

		$modelClass = $model ? $model : $this->getMorphClass();

		$morphToMany = $this->morphToMany(
			$modelClass,	// clase con que quiero relacionaerme
			'qualifier',	// nombre de la relacion
			'ratings',		// nombre de la tabla
			'qualifier_id',	// columna con la cual hago realcion
			'rateable_id'	// columna con que quiero relacionarme
		);

		$morphToMany
			->as('rating')
			->withTimestamps()
			->withPivot('score', 'rateable_type') // cada vez que llame la relacion devuelve estos campos
			->wherePivot('rateable_type', $modelClass)
			->wherePivot('qualifier_type', $this->getMorphClass());

		return $morphToMany;
	}


	public function rate(Rateable $model, float $score)
	{
		// Esta validacion permite que solamente se pueda calificar una vez
		if ($this->hasRated($model)) {
			return false;
		}


		// Clase 19: Excepciones personalizadas
		// php artisan make:exception InvalidScore
		$from = config('rating.from');
		$to = config('rating.to');
		if ($score < $from || $score > $to) {
			throw new InvalidScore($from, $to);
		}

		$this->ratings($model)->attach($model->getKey(), [
			'score' => $score,
			'rateable_type' => get_class($model),
		]);

		// Clase 13: Eventos y Listeners en Laravel
		// php artisan make:event ModelRated
		event(new ModelRated($this, $model, $score));
		// Este evento es escuchado por el listener SendEmailModelRatedNotification

		return true;
	}


	public function unrate(Rateable $model): bool
	{
		if (!$this->hasRated($model)) {
			return false;
		}

		$this->ratings($model->getMorphClass())->detach($model->getKey());

		// event(new ModelUnrated($this, $model));

		return true;
	}


	public function hasRated(Rateable $model)
	{
		return !is_null($this->ratings($model->getMorphClass())->find($model->getKey()));
	}
}
