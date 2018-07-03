
 <html>
     <head>
         <title> Resultado da busca.</title>
     </head>
     <body>
      <?=$ident = $_POST['select'];?>
      <?php
        if($ident == Nome)
        $ident = 'UF';
      ?>
     <table class="table table-striped table-bordered table-condensed table-hover" width="450px" border="3" cellspacing="1">
	  <tr>
        <td><strong>numero</strong></td>
	    <td><strong>nome</strong></td>
	    <td><strong><?=$ident?></strong></td>
      </tr> 
    

<?php
    $servidor = "localhost:3307";
    $usuario = "root";
    $senha = "Gravidade";
    $dbname = "tutocrudphp";
    //Criar a conexao
    $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
    
    $pesquisar = $_POST['pesquisar'];
    $result_cursos = "SELECT Nome,uf FROM cliente WHERE Nome LIKE '%$pesquisar%' ";
    $resultado_cursos = mysqli_query($conn, $result_cursos);
    $i =1;
    $t = $_POST['select'];
          
    echo ' = Resultado para: ' .$t.'<br>';
    if($t == Nome){
       while($rows_cursos = mysqli_fetch_array($resultado_cursos)){
           echo '<tr>';
        echo '<td>' .$i.'</td>';
        echo '<td>' .$rows_cursos['Nome'].'</td>';
        echo '<td>' .$rows_cursos['uf'].'</td>';
        echo '</tr>';
       $i +=1;
      } 
    }
         if( $t == Email){
            $result_cursos = "SELECT Nome,Email FROM cliente WHERE Email LIKE '%$pesquisar%' ";
            $resultado_cursos = mysqli_query($conn, $result_cursos);
            
            while($rows_cursos = mysqli_fetch_array($resultado_cursos)){
                echo '<tr>';
                echo '<td>' .$i.'</td>';
                echo ' <td>' .$rows_cursos['Nome']. ' </td>';
                echo '<td>' .$rows_cursos['Email'].'</td>';
                echo '</tr>';
               $i +=1;
          }
        }
              if($t == Cidade){
                $result_cursos = "SELECT Nome,cidade FROM cliente WHERE cidade LIKE '%$pesquisar%' ";
                $resultado_cursos = mysqli_query($conn, $result_cursos);

                while($rows_cursos = mysqli_fetch_array($resultado_cursos)){
                    echo '<tr>';
                    echo '<td>' .$i.'</td>';
                    echo '<td>' .$rows_cursos['Nome'].'</td>';
                    echo '<td>' .$rows_cursos['cidade'].'</td>';
                    echo '</tr>';
                   $i +=1;
              }
            }
    
?>
     </table>
    </body>
 </html>