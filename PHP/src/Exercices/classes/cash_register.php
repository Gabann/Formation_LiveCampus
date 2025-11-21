<?php

namespace Gaban\Php\Exercices\classes;

use Gaban\Php\Exercices\DTO\currency_amount;

class cash_register
{
	/** @var currency_amount[] */
	private array $currencies_amount_dto = array();

	public function __construct(array $currencies)
	{
		$this->currencies_amount_dto = $currencies;
	}

	public function get_currencies_amount_dto(): array
	{
		return $this->currencies_amount_dto;
	}

	public function set_currencies_amount_dto(array $currencies_amount_dto): void
	{
		$this->currencies_amount_dto = $currencies_amount_dto;
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

		$this->saveCashRegisterStatus();
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

	public function saveCashRegisterStatus(): void
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

	public function sort_currency_by_value_desc(): void
	{
		usort($this->currencies_amount_dto, function ($a, $b) {
			return $b->get_currency()->get_value() <=> $a->get_currency()->get_value();
		});
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
