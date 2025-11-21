<?php

namespace Gaban\Php\Exercices\classes\currency;

use Gaban\Php\Exercices\classes\builder\CoinBuilder;
use Gaban\Php\Exercices\classes\builder\CurrencyBuilder;

class coin extends currency
{
	protected ?int $radius;

	public function __construct(CoinBuilder $coinBuilder)
	{
		$currencyBuilder = (new CurrencyBuilder())->id($coinBuilder->getId())->value($coinBuilder->getValue())->imgUrl($coinBuilder->getImgUrl());
		parent::__construct($currencyBuilder);
		$this->radius = $coinBuilder->getRadius();
	}

	public function build(): currency
	{
		return $this;
	}
}
