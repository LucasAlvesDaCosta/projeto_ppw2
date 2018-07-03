<?php
$servidor = 'localhost:3307';
$banco = 'tutocrudphp';
$usuario = 'root';
$senha = 'Gravidade';
$obj_mysqli = new mysqli($servidor,$usuario,$senha,$banco);
 
if ($obj_mysqli->connect_errno)
{
	echo "Ocorreu um erro na conexão com o banco de dados.";
	exit;
}
 
mysqli_set_charset($obj_mysqli, 'utf8');
$id = -1;
$cliente_id   = "";
$livro_id  = "";

 
if(isset($_POST["cliente_id"]) && isset($_POST["livro_id"]))
{
	if(empty($_POST["cliente_id"]))
		$erro = "Campo nome obrigatório";
	else
	if(empty($_POST["livro_id"]))
		$erro = "Campo e-mail obrigatório";
	else		 
	{
		$id     = $_POST["id"];		
		$cliente_id   = $_POST["cliente_id"];
		$livro_id  = $_POST["livro_id"];
		
			
		if($id == -1)
		{
			$stmt = $obj_mysqli->prepare("INSERT INTO `emprestimo` (`cliente_id`,`livro_id`) VALUES (?,?)");
			$stmt->bind_param('ii', $cliente_id, $livro_id);	
		
			if(!$stmt->execute())
			{
				$erro = $stmt->error;
			}
			else
			{
				header("Location:emprestimo.php");
				exit;
			}
		}
		else
		if(is_numeric($id) && $id >= 1)
		{
			$stmt = $obj_mysqli->prepare("UPDATE `emprestimo` SET `cliente_id`=?, `livro_id`=? WHERE id = ? ");
			$stmt->bind_param('iii',$cliente_id, $livro_id,$id);
		
			if(!$stmt->execute())
			{
				$erro = $stmt->error;
			}
			else
			{
				header("Location:emprestimo.php");
				exit;
			}
		}
		else
		{
			$erro = "Número inválido";
		}
	}
}
else
if(isset($_GET["id"]) && is_numeric($_GET["id"]))
{
	$id = (int)$_GET["id"];
	
	if(isset($_GET["del"]))
	{
		$stmt = $obj_mysqli->prepare("DELETE FROM `emprestimo` WHERE id = ?");
		$stmt->bind_param('i', $id);
		$stmt->execute();
		
		header("Location:emprestimo.php");
		exit;
	}
	else
	{
		$stmt = $obj_mysqli->prepare("SELECT * FROM `emprestimo` WHERE id = ?");
		$stmt->bind_param('i', $id);
		$stmt->execute();
		
		$result = $stmt->get_result();
		$aux_query = $result->fetch_assoc();
		
		$cliente_id = $aux_query["cliente_id"];
		$livro_id = $aux_query["livro_id"];

		
		$stmt->close();		
	}
}
 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
	<title>Servidores</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="shortcut icon" href="img/logo.png">
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>
  <nav id="nav-bar" class="navbar navbar-expand-md navbar-light fixed-top">
      <div class="container">

        <a class="navbar-brand" href="index.html">
          <img class="logo" src="img/logo.png">
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!--<ul class="navbar-nav">
            <li class="nav-item active">
              <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Clubes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Regulamento</a>
            </li>
          </ul>-->
          <form class="form-inline">
            <input class="form-control" type="text" placeholder="Buscar">
            <button class="btn btn-success my-2 my-sm-0" type="submit">Pesquisar</button>
          </form>

          <div class="ml-auto">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="login.html">Login</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="cadastro.html">Cadastrar</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="atendimento.html">Atendimento</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Perfil
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#">Meus Pedidos</a>
                  <a class="dropdown-item" href="#">Carrinho de Compras</a>
                  <a class="dropdown-item" href="#">Sair</a>
                </div>
              </li>
            </ul>
          </div><!-- /ml-auto -->

        </div><!-- /collapse -->

      </div><!-- /container -->
    </nav>
    <?php
	if(isset($erro))
		echo '<div style="color:#F00">'.$erro.'</div><br/><br/>';
	else
	if(isset($sucesso))
		echo '<div style="color:#00f">'.$sucesso.'</div><br/><br/>';
	?>
	<form action="<?=$_SERVER["PHP_SELF"]?>" method="POST">
				<div class="form-group row col-sm-6 d-flex" >
					<label for="example-text-input" class="col-xs-2 col-form-label">cliente_id</label>
					<input class="form-control" name="cliente_id" type="text" placeholder="Qual seu nome?" value="<?=$cliente_id?>" >
					
          <label for="example-text-input" class="col-xs-2 col-form-label">livro_id</label>
					<input class="form-control" name="livro_id" type="text" placeholder="email@example.com" value="<?=$livro_id?>" >
          <br>
					<br>
					<input type="hidden" value="<?=$id?>" name="id">
				<!--Alteramos aqui também, para poder mostrar o texto Cadastrar, ou Salvar, de acordo com o momento. :)-->
					<button class="btn btn-success my-2 my-sm-0" type="submit"><?=($id==-1)?"Cadastrar":"Salvar"?></button>
					
				</div>
			</form>
	<br>
    <br>
	<!--Esta parte pode está contida em um arquivo separado -->
	<div class="page-header">
    <h1>&nbsp;Tabela de emprestimos.<br><br> <small>Lista referente a todos os emprestimos realizados.</small> </h1>
</div>

	<table class="table table-striped table-bordered table-condensed table-hover" width="450px" border="3" cellspacing="1">
	  <tr>
	    <td><strong>id</strong></td>
	    <td><strong>cliente_id</strong></td>
	    <td><strong>livro_id</strong></td>
	    <td><strong>Data de emprestimo</strong></td>
	    <td><strong>Prazo de devolucao</strong></td>
	    <td><strong>Editar</strong></td>
	    <td><strong>Excluir</strong></td>
      </tr>
      	<?php
	$result = $obj_mysqli->query("SELECT * FROM `emprestimo`");
	while ($aux_query = $result->fetch_assoc())
    {
	  echo '<tr>';
	  echo '  <td>'.$aux_query["Id"].'</td>';
	  echo '  <td>'.$aux_query["cliente_id"].'</td>';
	  echo '  <td>'.$aux_query["livro_id"].'</td>';
		echo '  <td>'.$aux_query["emprestimo"].'</td>';
		echo '  <td>'.$aux_query["devolucao"].'</td>';
      echo '  <td><a href="'.$_SERVER["PHP_SELF"].'?id='.$aux_query["Id"].'">Editar</a></td>';
      echo '  <td><a href="'.$_SERVER["PHP_SELF"].'?id='.$aux_query["Id"].'&del=true">Excluir</a></td>';
	  echo '</tr>';
	}
	
    ?>
	</table>
  </body>
</html>