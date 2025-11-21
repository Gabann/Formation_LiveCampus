<?php

namespace Gaban\Php\Exercices\classes\currency;


use Gaban\Php\Exercices\classes\builder\CurrencyBuilder;

abstract class currency
{
	protected int $value;
	protected string $img_url;
	protected int $id;

	/**
	 * @param CurrencyBuilder $currencyBuilder
	 */
	public function __construct(CurrencyBuilder $currencyBuilder)
	{
		$this->value = $currencyBuilder->getValue();
		$this->img_url = $currencyBuilder->getImgUrl();
		$this->id = $currencyBuilder->getId();
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function get_value(): int
	{
		return $this->value;
	}

	public function set_value(int $value): void
	{
		$this->value = $value;
	}

	public function get_img_url(): string
	{
		return $this->img_url;
	}

	public function set_img_url(string $img_url): void
	{
		$this->img_url = $img_url;
	}

	public abstract function build(): currency;
}
