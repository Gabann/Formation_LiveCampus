<?php

namespace Gaban\Php\Exercices\DTO;

use Gaban\Php\Exercices\classes\currency;

class currency_amount
{
	private currency $currency;
	private int $amount;

	public function __construct(currency $currency, int $amount)
	{
		$this->currency = $currency;
		$this->amount = $amount;
	}

	public function get_currency(): currency
	{
		return $this->currency;
	}

	public function get_amount(): int
	{
		return $this->amount;
	}

	public function set_amount(int $amount): void
	{
		$this->amount = $amount;
	}


}
