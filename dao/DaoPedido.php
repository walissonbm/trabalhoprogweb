<?php 

require_once(__DIR__ . '/../model/Marca.php');
require_once(__DIR__ . '/../model/Pedido.php');
require_once(__DIR__ . '/../db/Db.php');

// Classe para persistencia de Pedidos
// DAO - Data Access Object
class DaoPedido {
    
  private $connection;

  public function __construct(Db $connection) {
      $this->connection = $connection;
  }
  
  public function porId(int $id): ?Pedido {
    $sql = "SELECT pedido.nome, pedido.valor_max, pedido.email, pedido.telefone, pedido.marca_id, marcas.nome, pedido.produto 
            FROM pedido 
            LEFT JOIN marcas ON marcas.id = pedido.marca_id
            WHERE pedido.id = ?";
    $stmt = $this->connection->prepare($sql);
    $ped = null;
    if ($stmt) {
      $stmt->bind_param('i',$id);
      if ($stmt->execute()) {
        $stmt->bind_param('i',$id);
        $stmt->bind_result($nome,$valorMax,$email,$telefone,$marca_id,$marca_nome,$produto);
        $stmt->store_result(); //variavel ja recebeu os valores
        if ($stmt->num_rows == 1 && $stmt->fetch()) {
          $ped = new Pedido($nome, $email, $telefone, $produto, $valorMax,new Marca($marca_nome, $marca_id),$id);
        }
      }
      $stmt->close();
    }
    return $ped;
  }

  public function inserir(Pedido $pedido): bool {
    $sql = "INSERT INTO pedido (nome,email,telefone,valor_max,marca_id,produto) VALUES(?,?,?,?,?,?)";
    $stmt = $this->connection->prepare($sql);
    $res = false;
    if ($stmt) {
      $nome = $pedido->getNome();
      $valorMax = $pedido->getValorMax();
      $email = $pedido->getEmail();
      $telefone = $pedido->getTelefone();
      $marca_id = $pedido->getMarca()->getId();
      $produto = $pedido->getProduto();
      $stmt->bind_param('sssdis', $nome, $email, $telefone, $valorMax, $marca_id,$produto);
      if ($stmt->execute()) {
          $id = $this->connection->getLastId();
          $pedido->setId($id);
          $res = true;
      }
      $stmt->close();
    }
    return $res;
  }

  public function remover(Pedido $pedido): bool {
    $sql = "DELETE FROM pedido where id=?";
    $id = $pedido->getId(); 
    $stmt = $this->connection->prepare($sql);
    $ret = false;
    if ($stmt) {
      $stmt->bind_param('i',$id);
      $ret = $stmt->execute();
      $stmt->close();
    }
    return $ret;
  }

  public function atualizar(Pedido $pedido): bool {
    $sql = "UPDATE pedido SET produto=?, valor_max=?, marca_id=? WHERE id = ?";
    $stmt = $this->connection->prepare($sql);
    $ret = false;      
    if ($stmt) {
        $produto = $pedido->getProduto();
        $valorMax = $pedido->getValorMax();
        $marca_id = $pedido->getMarca()->getId();
        $id = $pedido->getId();
        $stmt->bind_param('sdii', $produto, $valorMax, $marca_id, $id);
      $ret = $stmt->execute();
      $stmt->close();
    }
    return $ret;
  }

  
  public function todos(): array {
    $sql = "SELECT pedido.id,pedido.nome, pedido.valor_max, pedido.email, pedido.telefone, 
                   pedido.marca_id, marcas.nome, pedido.produto 
            FROM pedido 
            LEFT JOIN marcas ON marcas.id = pedido.marca_id";
    $stmt = $this->connection->prepare($sql);
    $pedidos = [];
    if ($stmt) {
      if ($stmt->execute()) {
        $id = 0; $nome = '';
        $stmt->bind_result($id, $nome,$valorMax, $email, $telefone, $marca_id, $marca_nome, $produto);
        $stmt->store_result();
        while($stmt->fetch()) {
          // TODO: Criar uma unica instancia para cada marca
          //       de modo a otimizar a memoria.
          // Adotei a abordagem abaixo por ser mais rapido, 
          // mas nao eh eficiente          
          $marca = new Marca($marca_nome, $marca_id);
          $pedidos[] = new Pedido($nome, $email, $telefone, $produto, $valorMax, $marca, $id);
        }
      }
      $stmt->close();
    }
    return $pedidos;
  }

};

