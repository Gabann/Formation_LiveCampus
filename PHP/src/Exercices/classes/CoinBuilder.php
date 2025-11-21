<?php

namespace Gaban\Php\Exercices\classes;

class CoinBuilder extends CurrencyBuilder
{
	private ?int $radius = null;

	public function radius($value): CoinBuilder
	{
		$this->radius = $value;
		return $this;
	}

	public function getRadius(): ?int
	{
		return $this->radius;
	}

	public function build(): coin
	{
		return new coin($this);
	}
}
