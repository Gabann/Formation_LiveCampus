<?php

namespace Gaban\Php\Exercices\classes\invoice;

class InvoicePhone implements Iinvoice
{
	private int $amount;
	private string $phoneNumber;

	/**
	 * @param int $amount
	 * @param string $phoneNumber
	 */
	public function __construct(int $amount, string $phoneNumber)
	{
		$this->amount = $amount;
		$this->phoneNumber = $phoneNumber;
	}

	public function print(): string
	{
		return "Sending invoice to $this->phoneNumber phone with a total of $this->amount";
	}
}