<?php

const price_to_pay = 3348;
const customer_payment = 5000;

$cash_register_money = array(
		array('value' => 50000, 'amount' => 1, 'image' => "https://argus2euros.fr/wp-content/uploads/2025/04/Billet-de-500-euros-v1-avant.jpg"),
		array('value' => 20000, 'amount' => 2, 'image' => "https://argus2euros.fr/wp-content/uploads/2025/04/Billet-de-200-euros-v1-avant.jpg"),
		array('value' => 10000, 'amount' => 2, 'image' => "https://argus2euros.fr/wp-content/uploads/2025/04/Billet-de-100-euros-v1-avant.jpg"),
		array('value' => 5000, 'amount' => 4, 'image' => "https://argus2euros.fr/wp-content/uploads/2025/04/Billet-de-50-euros-v1-avant.jpg"),
		array('value' => 2000, 'amount' => 1, 'image' => "https://argus2euros.fr/wp-content/uploads/2025/04/Billet-de-20-euros-v1-avant.jpg"),
		array('value' => 1000, 'amount' => 23, 'image' => "https://argus2euros.fr/wp-content/uploads/2025/04/Billet-de-10-euros-v1-avant.jpg"),
		array('value' => 500, 'amount' => 0, 'image' => "https://argus2euros.fr/wp-content/uploads/2025/04/Billet-de-5-euros-v1-avant.jpg"),
		array('value' => 200, 'amount' => 3, 'image' => "https://www.ecb.europa.eu/euro/coins/common/shared/img/common_2euro_800.jpg"),
		array('value' => 100, 'amount' => 23, 'image' => "https://www.ecb.europa.eu/euro/coins/common/shared/img/common_1euro_800.jpg"),
		array('value' => 50, 'amount' => 23, 'image' => "https://www.ecb.europa.eu/euro/coins/common/shared/img/common_50cent_800.jpg"),
		array('value' => 20, 'amount' => 80, 'image' => "https://www.ecb.europa.eu/euro/coins/common/shared/img/common_20cent_800.jpg"),
		array('value' => 10, 'amount' => 13, 'image' => "https://www.ecb.europa.eu/euro/coins/common/shared/img/common_10cent.gif"),
		array('value' => 5, 'amount' => 8, 'image' => "https://www.ecb.europa.eu/euro/coins/common/shared/img/common_5cent_800.jpg"),
		array('value' => 2, 'amount' => 45, 'image' => "https://www.ecb.europa.eu/euro/coins/common/shared/img/common_2cent_800.jpg"),
		array('value' => 1, 'amount' => 12, 'image' => "https://www.ecb.europa.eu/euro/coins/common/shared/img/common_1cent_800.jpg"),
);

if ($_POST["1"] !== null) {
	foreach ($cash_register_money as $currency) {
		$new_value = $_POST[$currency["value"]];

		$currency["amount"] = $new_value;
	}
}


function part_1($cash_register_money, $changeAmount = customer_payment - price_to_pay)
{
	for ($i = 0; $i < count($cash_register_money); $i++) {
		give_change($cash_register_money, $i, $changeAmount);
	}

	if ($changeAmount > 0) {
		echo "Not enough money to pay the change";
	}
}


function part_2($cash_register_money, $preferred_value)
{
	$changeAmount = customer_payment - price_to_pay;
	$preferred_currency_index = array_search($preferred_value, array_column($cash_register_money, 'value'));

	give_change($cash_register_money, $preferred_currency_index, $changeAmount);

	if ($changeAmount > 0) {
		part_1($cash_register_money, $changeAmount);
	}
}

function part_3($cash_register_money)
{
	$change_amount = customer_payment - price_to_pay;
	$initial_cash_register_state = $cash_register_money;

	for ($i = count($cash_register_money); $i >= 0; $i--) {
		give_change($cash_register_money, $i, $change_amount);
	}

	if ($change_amount > 0) {

	}
}

function give_change(&$cash_register_money, $currencyIndex, &$changeAmount)
{
	$currentMoneyValue = $cash_register_money[$currencyIndex]["value"];
	$currentMoneyAmount = $cash_register_money[$currencyIndex]["amount"];

	while ($currentMoneyAmount > 0 && $changeAmount >= $currentMoneyValue) {
		$changeAmount -= $currentMoneyValue;
		$currentMoneyAmount -= 1;
		$cash_register_money[$currencyIndex]["amount"] = $currentMoneyAmount;

		echo "Gave $currentMoneyValue\n";
		echo "$currentMoneyValue currency left: $currentMoneyAmount\n";
		echo "Change left: $changeAmount\n";
		echo "---------------------------\n";
	}
}


part_1($cash_register_money);
//part_2($cash_register_money, 10);
//part_3($cash_register_money);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>ex_01</title>
	<link rel="stylesheet" href="./css/style.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
	      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<main>
	<div class="container-fluid">
		<main>
			<div class="col-10 mx-auto">
				<form method="post">
					<table class="table">
						<thead>
							<tr>
								<th scope="col">Image</th>
								<th scope="col">Quantity</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($cash_register_money as $currency) {
								$currency_image = $currency["image"];
								$currency_amount = $currency["amount"];
								$currency_value = $currency["value"];

								echo("<tr>");
								echo("<th scope=\"row\"><img src='$currency_image' alt='monnie de $currency_amount' /></th>");
								echo("<td><input type=\"number\" value=\"$currency_amount\" name=\"$currency_value\" min='0' /></td>");
								echo("/<tr>");
							}
							?>
						</tbody>
					</table>
					<div class="d-flex align-items-center justify-content-center">
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</form>
			</div>
		</main>

	</div>
</main>
</body>
</html>
