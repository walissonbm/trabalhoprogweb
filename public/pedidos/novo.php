<?php

require_once(__DIR__ . '/../../templates/template-html.php');
require_once(__DIR__ . '/../../db/Db.php');
require_once(__DIR__ . '/../../model/Marca.php');
require_once(__DIR__ . '/../../dao/DaoMarca.php');
require_once(__DIR__ . '/../../config/config.php');

$conn = Db::getInstance();

if (! $conn->connect()) {
    die();
}

$daoMarca = new DaoMarca($conn);
$marcas = $daoMarca->todos();

ob_start();

?>
    <div class="container">
        <div class="py-5 text-center">
            <h2>Cadastro de Pedido</h2>
        </div>
        <div class="row">
            <div class="col-md-12" >

                <form action="salvar.php" method="POST">

                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control" id="nome"
                            name="nome" placeholder="Nome Completo" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="telefone">Telefone</label>
                            <input type="text" class="form-control" id="telefone"
                                name="telefone" placeholder="Telefone" required>
                        </div>                            
                        <div class="form-group col-md-6">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email"
                                name="email" placeholder="Email" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="produto">Produto</label>
                            <input type="text" class="form-control" id="produto"
                                name="produto" placeholder="Produto" required>
                        </div>                            
                        <div class="form-group col-md-6">
                        <label for="valor">Valor Maximo</label>
                            <input type="number" class="form-control" min="0.00" max="10000.00" 
                                step="0.01"  id="valor" 
                                name="valor" placeholder="Preço em R$" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="marca">Marca</label>
                        <select class="form-control" id="marca" name="marca" required>
<?php foreach($marcas as $marca) { ?>
                            <option value="<?php echo $marca->getId() ?>">
                                <?php echo $marca->getNome() ?>
                            </option>
<?php } ?>
                        </select>                        
                    </div>                    
                    
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="index.php" class="btn btn-secondary ml-1" role="button" aria-pressed="true">Cancelar</a>

                </form> 


            </div>
        </div>
    </div>
<?php

$content = ob_get_clean();
echo html( $content );
    
?>


