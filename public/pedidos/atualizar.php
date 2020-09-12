<?php

require_once(__DIR__ . '/../../templates/template-html.php');

require_once(__DIR__ . '/../../db/Db.php');
require_once(__DIR__ . '/../../dao/DaoMarca.php');
require_once(__DIR__ . '/../../dao/DaoPedido.php');
require_once(__DIR__ . '/../../model/Pedido.php');
require_once(__DIR__ . '/../../config/config.php');

$conn = Db::getInstance();

if (! $conn->connect()) {
    die();
}
$daoMarca = new DaoMarca($conn);
$marca = $daoMarca->porId( $_POST['marca'] );

$daoPedido = new DaoPedido($conn);
$pedido = $daoPedido->porId( $_POST['id'] );
    
if ( $pedido )
{  
  $pedido->setProduto( $_POST['produto'] );
  $pedido->setValorMax( $_POST['valor'] );
  $pedido->setMarca($marca);
  $daoPedido->atualizar( $pedido );

}

header('Location: ./index.php');