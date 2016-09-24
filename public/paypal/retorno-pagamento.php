<?php
require_once '../../config/config.php';
require_once '../../core/helper/RedirectHelper.php';

$token = $_GET['token'];
$payerId = $_GET['PayerID'];
$ped_id = $_GET['ped_id'];
$url = BASE_URL . "paypal/retPag/token/{$token}/pid/{$payerId}/ped_id/{$ped_id}";

echo "<p>Retornando...</p>";

return Redirect::toUrl($url);