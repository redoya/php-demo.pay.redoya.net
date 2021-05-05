<?php
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$orderID = $_GET['q'];
$productid = $_GET['pi'];
$json = file_get_contents('../../products.json');
$obj = json_decode($json, true);
if(!isset($orderID) || $orderID == "" || !isset($productid) || $productid == "")
{
    header("Location: /");
}
echo 'Ödeme barşarısız.';