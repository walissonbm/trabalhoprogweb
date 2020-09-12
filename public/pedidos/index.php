<?php

require_once(__DIR__ . '/../../templates/template-html.php');
require_once(__DIR__ . '/../../db/Db.php');
require_once(__DIR__ . '/../../model/Pedido.php');
require_once(__DIR__ . '/../../dao/DaoPedido.php');
require_once(__DIR__ . '/../../config/config.php');

$conn = Db::getInstance();

if (! $conn->connect()) {
    die();
}

$daoPedido = new DaoPedido($conn);
$pedidos = $daoPedido->todos();

ob_start();

?>
    <div class="container">
        <div class="py-5 text-center">
            <h2>Cadastro de Pedidos</h2>
        </div>
        <div class="row mb-2">
            <div class="col-md-12" >
                <a href="novo.php" class="btn btn-primary active" role="button" aria-pressed="true">Novo Pedido</a>
            </div>
        </div>

<?php
    if (count($pedidos) >0) 
    {
?>
        <div class="row">
            <div class="col-md-12" >

                <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Produto</th>
                        <th scope="col">Valor Maximo</th>
                        <th scope="col">Marca</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
<?php 
        foreach($pedidos as $pe) {
?>                    
                    <tr>
                        <th scope="row"><?php echo  $pe->getId(); ?></th>
                        <td><?php echo $pe->getNome(); ?></td>
                        <td><?php echo $pe->getProduto(); ?></td>
                        <td><?php echo $pe->getValorMax(); ?></td>
                        <td><?php echo $pe->getMarca()->getNome(); ?></td>
                        <td>
                            <a class="btn btn-danger btn-sm active" 
                                href="apagar.php?id=<?php echo $pe->getId();?>">
                                Apagar
                            </a>
                            <a class="btn btn-secondary btn-sm active" 
                                href="editar.php?id=<?php echo $pe->getId();?>">
                                Editar
                            </a>                        
                        </td>
                    </tr>
<?php
        } // foreach
?>                    
                </tbody>
                </table>

            </div>
        </div>
<?php 
    
    }  // if

?>        
    </div>
<?php

$content = ob_get_clean();
echo html( $content );
    
?>


