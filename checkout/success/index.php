<?php
$orderID = $_GET['q'];
$productid = $_GET['pi'];
$json = file_get_contents('../../products.json');
$obj = json_decode($json, true);
if(!isset($orderID) || $orderID == "" || !isset($productid) || $productid == "")
{
    header("Location: /");
}
require('../../config.php');
$ch = curl_init('https://pay.redoya.net/api/v1/order/verify/'.$orderID);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,
        'identifier='.TOKEN
    );
    $r = curl_exec($ch);
    $i = curl_getinfo($ch);
    curl_close($ch);

    if ($i['http_code'] == 200) {
        set_time_limit(20);
        $data = json_decode($r,true);
        $status = $data['status'];
        $gorderid = $data['orderId'];
        $amount = $data['payment_amount'];
        $uses = $data['uses'];
        $testmode = $data['testMode'];
        $total = $data['total_amount'];
        
 
        if (json_last_error() == JSON_ERROR_NONE) {
            if(!isset($obj[$productid])){
                echo 'Hatalı ürün. Yönlendiriliyorsunuz...';
                header('refresh: 5; url= /');
    
            }
            elseif($uses > 4){
                echo 'Birden fazla istek. Yönlendiriliyorsunuz...';
                header('refresh: 5; url= /');
            }elseif($obj[$productid]['price'] !== $amount / 100)
            {
                echo 'Ürün fiyatı ile ödenen tutar uyuşmuyor. Yetkili ile iletişime geçin.';
                header('refresh: 5; url= /');
    
            }
            elseif($status == 'success')
            {
                echo 'Siparişiniz başarıyla alındı.';
                echo '<br>';
                echo '=========';
                echo '<br>';
                echo 'Ürün: '.$obj[$productid]['name'];
                echo '<br>';
                echo 'Fiyat: '.$obj[$productid]['price'];
                echo '<br>';
                echo 'Ödenen tutar: '.$total / 100;
            }else{
                echo 'Beklenmedik bir hata meydana geldi. Yetkili ile iletişime geçin.';
            }

        
        }else {
            echo "HATA -> ".$r;
        }
    }elseif($i['http_code'] == 404){
        echo 'Sipariş kimliği hatalı. Yönlendiriliyorsunuz...';
        header('refresh: 5; url= /');
    }
    else {
        echo 'Bir hata meydana geldi - error:';
        print_r($i['http_code']);

    }