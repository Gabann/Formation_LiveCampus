<?php

namespace Gaban\Php\Exercices\classes;

use Gaban\Php\Exercices\classes\builder\BillBuilder;
use Gaban\Php\Exercices\classes\builder\CoinBuilder;
use Gaban\Php\Exercices\classes\currency\bill;
use Gaban\Php\Exercices\classes\currency\coin;
use Gaban\Php\Exercices\classes\currency\currency;
use Gaban\Php\Exercices\classes\DTO\currency_amount;
use Gaban\Php\Exercices\classes\invoice\Iinvoice;
use Gaban\Php\Exercices\classes\utils\DB_connection;

//TODO create a payment system for single responsability principle, cash register should only have to handle the cash stock
class cash_register
{
	/** @var currency_amount[] */
	private array $currencies_amount_dto = array();

	public function __construct()
	{
		$currencies = $this->fetchCurrencies();

		$this->currencies_amount_dto = $currencies;

		$this->sort_currency_by_value_desc();
	}

	private function fetchCurrencies(): array
	{
		$results = DB_connection::get_instance()::make_query("SELECT ca.amount, cu.image_url, cu.value, ct.name as currency_type, cu.id
FROM cash_register ca
JOIN currencies cu ON ca.currency_id = cu.id
JOIN currency_type ct on cu.currency_type = ct.id
");
		$currencies = array();

		if ($results) {
			//TODO: refactor this to take into account any currency type and remove redundancy
			foreach ($results as $row) {
				switch ($row['currency_type']) {
					case 'bill':
						$bill = new bill((new BillBuilder())
							->id((int)$row['id'])
							->value((int)$row['value'])
							->imgUrl($row['image_url']));
						$currency_amount = new currency_amount($bill, ($row['amount']));
						array_push($currencies, $currency_amount);
						break;
					case 'coin':
						$coin = new coin((new CoinBuilder())
							->id((int)$row['id'])
							->value((int)$row['value'])
							->imgUrl($row['image_url']));
						$currency_amount = new currency_amount($coin, ($row['amount']));
						array_push($currencies, $currency_amount);
						break;
				}
			}
		}
		return $currencies;
	}

	public function sort_currency_by_value_desc(): void
	{
		usort($this->currencies_amount_dto, function ($a, $b) {
			return $b->get_currency()->get_value() <=> $a->get_currency()->get_value();
		});
	}

	public function get_currencies_amount_dto(): array
	{
		return $this->currencies_amount_dto;
	}

	public function give_change_preferred_currency($changeAmount, $preferred_currency): void
	{
		$this->giveCurrency($preferred_currency, $changeAmount);

		if ($changeAmount > 0) {
			$this->give_change_least_amount($changeAmount);
		}
	}

	function giveCurrency(currency $currency, int &$changeAmount): void
	{
		$currency_value = $currency->get_value();
		$currency_amount = $this->get_currency_amount($currency);

		while ($changeAmount >= $currency_value && $currency_amount > 0) {
			$changeAmount -= $currency_value;
			$currency_amount--;

			$this->set_currency_amount($currency, $currency_amount);


			echo "Gave $currency_value\n";
			echo "$currency_value currency left: $currency_amount\n";
			echo "Change left: $changeAmount\n";
			echo "---------------------------\n";
		}

		$this->saveCashRegisterStatusToDB();
	}

	public function get_currency_amount(currency $currency): int
	{
		foreach ($this->currencies_amount_dto as $currency_dto) {
			if ($currency_dto->get_currency()->getId() === $currency->getId()) {
				return $currency_dto->get_amount();
			}
		}
		return 0;
	}

	public function set_currency_amount(currency $currency, $amount): void
	{
		//TODO: check for a better way to find the currency than iterating through all of them
		foreach ($this->currencies_amount_dto as $currency_dto) {
			if ($currency_dto->get_currency()->getId() === $currency->getId()) {
				$currency_dto->set_amount($amount);
			}
		}
	}

	public function saveCashRegisterStatusToDB(): void
	{
		$request_when = "";
		$request_in = "";

		foreach ($this->currencies_amount_dto as $currency_amount_dto) {
			$currency_amount = $currency_amount_dto->get_amount();
			$currency_id = $currency_amount_dto->get_currency()->getId();
			$request_in .= "$currency_id,";
			$request_when .= "WHEN $currency_id THEN $currency_amount \n";
		}

		$request_in = rtrim($request_in, ",");

		$full_request = "UPDATE cash_register SET amount = CASE currency_id
    					$request_when
    					END
						WHERE currency_id IN ($request_in);";

		DB_connection::get_instance()::make_query($full_request);
	}

	public function give_change_least_amount($changeAmount): void
	{
		$this->sort_currency_by_value_desc();

		foreach ($this->currencies_amount_dto as $currency_amount_dto) {
			$this->giveCurrency($currency_amount_dto->get_currency(), $changeAmount);
		}
	}

	public function send_invoice(Iinvoice $invoice): string
	{
		return $invoice->print();
	}

	public function set_currency_amount_by_id(int $currency_id, $amount): void
	{
		//TODO: check for a better way to find the currency than iterating through all of them
		foreach ($this->currencies_amount_dto as $currency_dto) {
			if ($currency_dto->get_currency()->getId() === $currency_id) {
				$currency_dto->set_amount($amount);
			}
		}
	}
}
