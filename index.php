<!DOCTYPE html>
<html>
<head>

</head>
<body>
<h3>ÜRÜNLER</h3>
<ul>
<?php 
$json = file_get_contents('./products.json');
$obj = json_decode($json, true);
foreach($obj as $product){
    $id = $product['id'];
    $name = $product['name'];
    $price = $product['price'];
    echo '<li><a href="shop.php?pi='.$id.'">'.$name.' -> '.$price.' TL</a></li>';

}

?>
</ul>
</body>
</html>