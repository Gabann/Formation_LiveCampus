<?php

namespace Gaban\Php\Exercices\classes\invoice;

class InvoiceMail implements Iinvoice
{
	private int $amount;
	private string $mail;

	/**
	 * @param int $amount
	 * @param string $mail
	 */
	public function __construct(int $amount, string $mail)
	{
		$this->amount = $amount;
		$this->mail = $mail;
	}

	public function print(): string
	{
		return "Sending invoice to $this->mail with a total of $this->amount";
	}
}