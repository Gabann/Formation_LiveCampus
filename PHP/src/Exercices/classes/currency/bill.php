<?php

namespace Gaban\Php\Exercices\classes\currency;


use Gaban\Php\Exercices\classes\builder\BillBuilder;
use Gaban\Php\Exercices\classes\builder\CurrencyBuilder;

class bill extends currency
{
	protected ?int $dimension_width;
	protected ?int $dimension_height;

	public function __construct(BillBuilder $billBuilder)
	{
		$currencyBuilder = (new CurrencyBuilder())->id($billBuilder->getId())->value($billBuilder->getValue())->imgUrl($billBuilder->getImgUrl());
		parent::__construct($currencyBuilder);
		$this->dimension_width = $billBuilder->getDimensionWidth();
		$this->dimension_height = $billBuilder->getDimensionHeight();

	}

	public function build(): currency
	{
		return $this;
	}
}