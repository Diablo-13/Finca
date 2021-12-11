<?php

require 'lib/vendor/autoload.php';
require_once 'credenciales-mp.php';

MercadoPago\SDK::setAccessToken($access_token);

if (isset($_SESSION['carrito'])) {
foreach ($_SESSION['carrito'] as $indice => $producto) {

    // Crea un objeto de preferencia
    $preference = new MercadoPago\Preference();

    // Crea un ítem en la preferencia
    $item = new MercadoPago\Item();

    $item->title = $producto['nombre_producto'];
    $item->quantity = $producto['cantidad'];
    $item->unit_price = $producto['precio'];

    $item2 = new MercadoPago\Item();

    $item2->title = $producto['nombre_producto'];
    $item2->quantity = $producto['cantidad'];
    $item2->unit_price = $producto['precio'];

    $item3 = new MercadoPago\Item();

    $item3->title = $producto['nombre_producto'];
    $item3->quantity = $producto['cantidad'];
    $item3->unit_price = $producto['precio'];


    //$productos[] = $items;

    $preference->back_urls = array(
        "success" => "http://localhost/finca-aletheia/logout.php",
        "failure" => "http://localhost/finca-aletheia/logout.php",
        "pending" => "http://localhost/finca-aletheia/logout.php"
    );

    $preference->items = array($item,$item2,$item3);
    $preference->save();
}
}
