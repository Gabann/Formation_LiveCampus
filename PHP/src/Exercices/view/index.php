<?php

use Gaban\Php\Exercices\classes\bill;
use Gaban\Php\Exercices\classes\cash_register;
use Gaban\Php\Exercices\classes\coin;
use Gaban\Php\Exercices\classes\DB_connection;
use Gaban\Php\Exercices\DTO\currency_amount;

require_once '../../../vendor/autoload.php';

$cash_register = null;

function fetch_currencies(): void
{
	$results = DB_connection::get_instance()::make_query("SELECT ca.amount, cu.image_url, cu.value, ct.name as currency_type, cu.id
FROM cash_register ca
JOIN currencies cu ON ca.currency_id = cu.id
JOIN currency_type ct on cu.currency_type = ct.id
");

	if ($results) {
		global $cash_register;
		$currencies = array();

		//TODO: refactor this to take into account any currency type and remove redundancy
		foreach ($results as $row) {
			switch ($row['currency_type']) {
				case 'bill':
					$bill = new bill($row['value'], $row['image_url'], $row['id']);
					$currency_amount = new currency_amount($bill, ($row['amount']));
					array_push($currencies, $currency_amount);
					break;
				case 'coin':
					$coin = new coin($row['value'], $row['image_url'], $row['id']);
					$currency_amount = new currency_amount($coin, ($row['amount']));
					array_push($currencies, $currency_amount);
					break;
			}
		}
		$cash_register = new cash_register($currencies);
	}
}

fetch_currencies();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['calculate_payment'])) {
	$price = $_POST['price_to_pay'];
	$payment = $_POST['customer_payment'];
	$cash_register->give_change_least_amount($payment - $price);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cashier_amount'])) {
	$currencies = $_POST['currencies'];

	foreach ($currencies as $currency) {

		$cash_register->set_currency_amount_by_id($currency["id"], $currency["amount"]);
	}

	$cash_register->saveCashRegisterStatus();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>ex_01</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
	      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<main>
	<div class="container-fluid">
		<main>
			<div class="col-10 mx-auto">

				<form method="post" class="form-inline">
					<div class="form-row w-100">
						<div class="form-group col-6 justify-content-center">
							<label for="price_to_pay">Price to pay</label>
							<input type="number" class="form-control" id="price_to_pay" name="price_to_pay" placeholder="Price to pay"
							       value="3348">
						</div>

						<div class="form-group col-6 justify-content-center">
							<label for="customer_payment">Customer payment</label>
							<input type="text" class="form-control" id="customer_payment" name="customer_payment"
							       placeholder="Customer payment" value="5000">
						</div>

						<!-- Center the button: full-width column with flex centering -->
						<div class="form-group col-12 d-flex justify-content-center">
							<button type="submit" class="btn btn-primary" name="calculate_payment">Calculate payment</button>
						</div>
					</div>
				</form>

				<form method="post">
					<table class="table">
						<thead>
							<tr>
								<th scope="col">Image</th>
								<th scope="col">Value</th>
								<th scope="col">Quantity</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($cash_register->get_currencies_amount_dto() as $currency_amount_dto) {
								$currency_amount_dto->get_currency()->get_value();
								$currency_image = $currency_amount_dto->get_currency()->get_img_url();
								$currency_amount = $currency_amount_dto->get_amount();
								$currency_value = $currency_amount_dto->get_currency()->get_value();
								$currency_value_in_euros = $currency_value / 100;


								echo("<tr>");
								echo("<th scope=\"row\"><img src='$currency_image' alt='monnie de $currency_amount' /></th>");
								echo("<th scope=\"row\"><span>$currency_value_in_euros</span></th>");
								echo("<td>
  <input type=\"hidden\" name=\"currencies[{$currency_amount_dto->get_currency()->getId()}][id]\" value=\"{$currency_amount_dto->get_currency()->getId()}\" />
  <input type=\"number\" value=\"$currency_amount\" name=\"currencies[{$currency_amount_dto->get_currency()->getId()}][amount]\" min='0' />
</td>");
								echo("/<tr>");
							}
							?>
						</tbody>
					</table>
					<div class="d-flex align-items-center justify-content-center">
						<button type="submit" class="btn btn-primary" name="update_cashier_amount">Update currency amount</button>
					</div>
				</form>
			</div>
		</main>

	</div>
</main>
</body>
</html>
