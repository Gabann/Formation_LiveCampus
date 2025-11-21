<?php

namespace Gaban\Php\Exercices\classes\invoice;

class invoicePostOffice implements Iinvoice
{
	private int $amount;
	private int $zipCode;
	private string $city;
	private string $country;
	private string $address;

	public function getAmount(): int
	{
		return $this->amount;
	}

	public function getZipCode(): int
	{
		return $this->zipCode;
	}

	public function getCity(): string
	{
		return $this->city;
	}

	public function getCountry(): string
	{
		return $this->country;
	}

	public function getAddress(): string
	{
		return $this->address;
	}

	public function print(): string
	{
		return "Sending invoice to $this->address in $this->zipCode at $this->city in $this->country with a total of $this->amount";
	}
}