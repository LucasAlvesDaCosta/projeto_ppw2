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
$nome   = "";
$email  = "";
$pass = "";
 
if(isset($_POST["nome"]) && isset($_POST["email"]) && isset($_POST["password"]))
{
	if(empty($_POST["nome"]))
		$erro = "Campo nome obrigatório";
	else
	if(empty($_POST["email"]))
		$erro = "Campo e-mail obrigatório";
    else
       if(empty($_POST["password"]))
			 $erro = "campo de senha obrigatório";
	else		 
	{
		$id     = $_POST["id"];		
		$nome   = $_POST["nome"];
		$email  = $_POST["email"];
		$pass = $_POST["password"];
			
		if($id == -1)
		{
			$stmt = $obj_mysqli->prepare("INSERT INTO `servidor` (`nome`,`email`,`password`) VALUES (?,?,?)");
			$stmt->bind_param('sss', $nome, $email, $pass);	
		
			if(!$stmt->execute())
			{
				$erro = $stmt->error;
			}
			else
			{
				header("Location:cadastroServidor.php");
				exit;
			}
		}
		else
		if(is_numeric($id) && $id >= 1)
		{
			$stmt = $obj_mysqli->prepare("UPDATE `servidor` SET `nome`=?, `email`=?, `password`=? WHERE id = ? ");
			$stmt->bind_param('sssi',$nome, $email, $pass,$id);
		
			if(!$stmt->execute())
			{
				$erro = $stmt->error;
			}
			else
			{
				header("Location:cadastroServidor.php");
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
		$stmt = $obj_mysqli->prepare("DELETE FROM `servidor` WHERE id = ?");
		$stmt->bind_param('i', $id);
		$stmt->execute();
		
		header("Location:cadastroServidor.php");
		exit;
	}
	else
	{
		$stmt = $obj_mysqli->prepare("SELECT * FROM `servidor` WHERE id = ?");
		$stmt->bind_param('i', $id);
		$stmt->execute();
		
		$result = $stmt->get_result();
		$aux_query = $result->fetch_assoc();
		
		$nome = $aux_query["Nome"];
		$email = $aux_query["Email"];
		$pass = $aux_query["Password"];

		
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
        <h4>Biblioteca Comunitária</h4>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

          <div class="ml-auto">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="home.html">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="Busca_servidor.html">Procurar por Servidores</a>
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
					<label for="example-text-input" class="col-xs-2 col-form-label">Nome</label>
					<input class="form-control" name="nome" type="text" placeholder="Qual seu nome?" value="<?=$nome?>" >
					
                    <label for="example-text-input" class="col-xs-2 col-form-label">Email</label>
					<input class="form-control" name="email" type="email" placeholder="email@example.com" value="<?=$email?>" >
					
                    <label for="example-email-input" class="col-xs-2 col-form-label">Senha</label>
					<input class="form-control" name="password" type="password" placeholder="******" value="<?=$pass?>" >
					<br>
					<br>
					<input type="hidden" value="<?=$id?>" name="id">
				<!--Alteramos aqui também, para poder mostrar o texto Cadastrar, ou Salvar, de acordo com o momento. :)-->
					<button class="btn btn-success my-2 my-sm-0" type="submit"><?=($id==-1)?"Cadastrar":"Salvar"?></button>
					
				</div>
			</form>
	<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
	<!--Esta parte pode está contida em um arquivo separado -->
	<div class="page-header">
    <h1>&nbsp;Servidores.<br><br> <small>Lista referente a todos os funcionários da biblioteca.</small> </h1>
</div>

	<table class="table table-striped table-bordered table-condensed table-hover" width="450px" border="3" cellspacing="1">
	  <tr>
	    <td><strong>id</strong></td>
	    <td><strong>Nome</strong></td>
	    <td><strong>Email</strong></td>
	    <td><strong>Senha</strong></td>
	    <td><strong>Editar</strong></td>
	    <td><strong>Excluir</strong></td>
      </tr>
      	<?php
	$result = $obj_mysqli->query("SELECT * FROM `servidor`");
	while ($aux_query = $result->fetch_assoc())
    {
	  echo '<tr>';
	  echo '  <td>'.$aux_query["Id"].'</td>';
	  echo '  <td>'.$aux_query["Nome"].'</td>';
	  echo '  <td>'.$aux_query["Email"].'</td>';
		echo '  <td>'.$aux_query["password"].'</td>';
      echo '  <td><a href="'.$_SERVER["PHP_SELF"].'?id='.$aux_query["Id"].'">Editar</a></td>';
      echo '  <td><a href="'.$_SERVER["PHP_SELF"].'?id='.$aux_query["Id"].'&del=true">Excluir</a></td>';
	  echo '</tr>';
	}
	
	$result= $obj_mysqli->query("SELECT SUM(`Id`) FROM `servidor`");
	while ($aux_query = $result->fetch_assoc())
    {
	  echo '<tr>';
	  echo '  <td>'.$aux_query["Id"].'</td>';
	  echo '</tr>';
	}
    ?>
	</table>
  </body>
</html>