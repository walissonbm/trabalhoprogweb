<?php

require_once(__DIR__ . '/../../db/Db.php');
require_once(__DIR__ . '/../../config/config.php');
require_once(__DIR__ . '/../../model/Marca.php');
require_once(__DIR__ . '/../../model/Pedido.php');
require_once(__DIR__ . '/../../dao/DaoMarca.php');
require_once(__DIR__ . '/../../dao/DaoPedido.php');

$conn = Db::getInstance();

if (! $conn->connect()) {
    die();
}

$daoMarca = new DaoMarca($conn);

$daoPedido = new DaoPedido($conn);

$marca = $daoMarca->porId( $_POST['marca'] );

$daoPedido->inserir(new Pedido($_POST['nome'], $_POST['email'], $_POST['telefone'], $_POST['produto'], $_POST['valor'], $marca));
    
header('Location: ./index.php');

?>


