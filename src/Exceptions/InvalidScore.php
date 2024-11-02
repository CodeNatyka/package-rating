<?php

namespace Natyka\Exceptions;

use Exception;
use Throwable;

// Clase 19: Excepciones personalizadas
// php artisan make:exception InvalidScore

class InvalidScore extends Exception
{
	private $from;
	private $to;

	public function __construct($from, $to)
	{
		$this->from = $from;
		$this->from = $to;
	}

	public function render($request, Throwable $exception)
	{
		// Clase 19: Excepciones personalizadas
		// php artisan make:exception InvalidScore

		return response()->json([
			// 'score' => 'El valor debe estar entre 1 y 5'
			// tambien se puede complementar con archivo de lenguage
			// se encuntra definido en \resources\lang\en\rating
			trans('rating.invalidScore', [
				'from' => $this->from,
				'to' => $this->to,
			])
		]);
	}
}
