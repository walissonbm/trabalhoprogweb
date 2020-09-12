<?php

require_once(__DIR__ . '/../../templates/template-html.php');

require_once(__DIR__ . '/../../db/Db.php');
require_once(__DIR__ . '/../../model/Pedido.php');
require_once(__DIR__ . '/../../model/Marca.php');
require_once(__DIR__ . '/../../dao/DaoMarca.php');
require_once(__DIR__ . '/../../dao/DaoPedido.php');
require_once(__DIR__ . '/../../config/config.php');

$conn = Db::getInstance();

if (! $conn->connect()) {
    die();
}

$pedido_id = $_GET['id'];

$daoMarca = new DaoMarca($conn);
$marcas = $daoMarca->todos();
$daoPedido = new DaoPedido($conn);


$pedido = $daoPedido->porId( $pedido_id );
 
if (! $pedido )
    header('Location: ./index.php');

else {  

    ob_start();

    ?>
    <div class="container">
        <div class="py-5 text-center">
            <h2>Atualizar Pedido</h2>
        </div>
        <div class="row">
            <div class="col-md-12" >

                <form action="atualizar.php" method="POST">

                    <input type="hidden" name="id" 
                          value="<?php echo $pedido->getId(); ?>"> 

                    <div class="form-group">
                        <label for="nome">Nome do produto</label>
                        <input type="text" class="form-control" id="produto"
                            value="<?php echo $pedido->getProduto(); ?>"
                            name="produto" placeholder="Produto" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="valor">Valor Maximo</label>
                            <input type="number" class="form-control" min="0.00" max="10000.00" 
                                step="0.01"  id="valor" 
                                value="<?php echo $pedido->getValorMax(); ?>"
                                name="valor" placeholder="Preço em R$" required>
                        </div>                            
                        
                    
                    <div class="form-group col-md-6">
                        <label for="marca">Marca</label>
                        <select class="form-control" id="marca" name="marca" required>
<?php foreach($marcas as $marca) { ?>
                            <option value="<?php echo $marca->getId() ?>"
                                <?php 
                                    if ($marca->getId() == $pedido->getMarca()->getId()) 
                                        echo 'selected'; 
                                ?>
                            >
                                <?php echo $marca->getNome() ?>
                            </option>
<?php } ?>
                        </select>
                        </div>                        
                    </div>                    

                    <button type="submit" class="btn btn-primary">Atualizar</button>
                    <a href="index.php" class="btn btn-secondary ml-1" role="button" aria-pressed="true">Cancelar</a>

                </form> 


            </div>
        </div>
    </div>
<?php


    $content = ob_get_clean();
    echo html( $content );
} // else-if

?>
