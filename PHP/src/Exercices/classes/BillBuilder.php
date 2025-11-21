<?php

namespace Gaban\Php\Exercices\classes;

class BillBuilder extends CurrencyBuilder
{
	private ?int $dimension_width = null;
	private ?int $dimension_height = null;

	public function dimension_width(int $value): BillBuilder
	{
		$this->dimension_width = $value;
		return $this;
	}

	public function dimension_height(int $value): BillBuilder
	{
		$this->dimension_height = $value;
		return $this;
	}

	public function getDimensionHeight(): ?int
	{
		return $this->dimension_height;
	}

	public function getDimensionWidth(): ?int
	{
		return $this->dimension_width;
	}

	public function build(): bill
	{
		return new bill($this);
	}
}