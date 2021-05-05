<?php
declare(strict_types=1);

use Firebase\JWT\JWT;

require_once('./vendor/autoload.php');
require('config.php');
function checkout($fiyat)
{
    $productid = $_GET['pi'];
    $secretKey   = SECRET;
    $vendorToken = TOKEN;
    $serverName = "php-demo.pay.redoya.net";
    $issuedAt   = new DateTimeImmutable();
    $expire     = $issuedAt->modify('+999 minutes')->getTimestamp(); // Siparişin geçerlilik süresi
    $data = [
        'iat'  => $issuedAt->getTimestamp(),         // Tokenin oluşturulma tarihi
        'iss'  => $serverName,                       // Tokeni oluşturan yer
        'nbf'  => $issuedAt->getTimestamp(),         // Not before: Token oluşturma tarihi ile aynı
        'exp'  => $expire,                           // Son kullanım tarihi
        'price' => $fiyat,                     // Fiyat: 15TL (Float türündeki virgüllü veriler kuruş için kullanılabilir.)
        'successfulURL' => 'http://'.$serverName.'/checkout/success?q={order_id}&pi='.$productid,
         // Sipariş tamamlandığında, kullanıcı bu adrese yönlendirilecek.
        'failURL' => 'http://'.$serverName.'/checkout/fail?q={order_id}&pi='.$productid,
         // Sipariş hatalı olduğunda bu linke yönlendirme yapılır.
         // {order_id} sipariş IDsini pay.redoya'dan almak için kullanılabilir.
        'isInTestMode' => 1,
    ];
    
    $orderToken = JWT::encode( // Şimdi verileri şifreleyerek bir string elde etmiş olduk. Bunu sipariş tokeni olarak kullanabiliyoruz.
            $data,
            $secretKey,
            'HS256' // Algoritma türü HS256 olmak zorundadır.
        );
        header('location: https://pay.redoya.net/checkout#' . $orderToken . '#' . $vendorToken);
}
$productid = $_GET['pi'];
$json = file_get_contents('./products.json');
$obj = json_decode($json, true);
if(isset($obj[$productid]))
{
    checkout($obj[$productid]['price']);
}else{
    header('location: /');
}
