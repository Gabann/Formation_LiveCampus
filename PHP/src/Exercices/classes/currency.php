<?php

namespace Gaban\Php\Exercices\classes;


abstract class currency
{
	protected int $value;
	protected string $img_url;
	protected int $id;

	/**
	 * @param int $value
	 * @param string $img_url
	 * @param int $id
	 */
	public function __construct(int $value, string $img_url, int $id)
	{
		$this->value = $value;
		$this->img_url = $img_url;
		$this->id = $id;
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
}
