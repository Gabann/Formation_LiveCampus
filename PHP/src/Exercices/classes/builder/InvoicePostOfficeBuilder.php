<?php

namespace Gaban\Php\Exercices\classes\builder;

class InvoicePostOfficeBuilder
{
	private ?int $amount = null;
	private ?int $zipCode = null;
	private ?string $city = null;
	private ?string $country = null;
	private ?string $address = null;

	public function getAmount(): ?int
	{
		return $this->amount;
	}

	public function getZipCode(): ?int
	{
		return $this->zipCode;
	}

	public function getCity(): ?string
	{
		return $this->city;
	}

	public function getCountry(): ?string
	{
		return $this->country;
	}

	public function getAddress(): ?string
	{
		return $this->address;
	}

	public function amount(?int $amount): self
	{
		$this->amount = $amount;
		return $this;
	}

	public function zipCode(?int $zipCode): self
	{
		$this->zipCode = $zipCode;
		return $this;
	}

	public function city(?string $city): self
	{
		$this->city = $city;
		return $this;
	}

	public function country(?string $country): self
	{
		$this->country = $country;
		return $this;
	}

	public function address(?string $address): self
	{
		$this->address = $address;
		return $this;
	}
}