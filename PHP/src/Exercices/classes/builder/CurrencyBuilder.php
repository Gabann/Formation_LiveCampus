<?php

namespace Gaban\Php\Exercices\classes\builder;

class CurrencyBuilder
{
	private int $value;
	private string $img_url;
	private int $id;

	public function value(int $value): CurrencyBuilder
	{
		$this->value = $value;
		return $this;
	}

	public function getValue(): int
	{
		return $this->value;
	}

	public function getImgUrl(): string
	{
		return $this->img_url;
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function imgUrl(string $img_url): CurrencyBuilder
	{
		$this->img_url = $img_url;
		return $this;
	}

	public function id(int $id): CurrencyBuilder
	{
		$this->id = $id;
		return $this;
	}

//	public function build(): currency
//	{
//		return $this;
//	}
}
