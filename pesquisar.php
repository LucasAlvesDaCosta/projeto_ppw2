
 <html>
     <head>
         <title> Resultado da busca.</title>
     </head>
     <body>
      <?=$ident = $_POST['select'];?>
      <?php 
         if($ident == Titulo)
           $ident = 'Autor';
      ?>
     <table class="table table-striped table-bordered table-condensed table-hover" width="450px" border="3" cellspacing="1">
	  <tr>
        <td><strong>numero</strong></td>
	    <td><strong>Titulo</strong></td>
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
    $result_cursos = "SELECT titulo,autor FROM livros WHERE titulo LIKE '%$pesquisar%' ";
    $resultado_cursos = mysqli_query($conn, $result_cursos);
    $i =1;
    $t = $_POST['select'];
          
    echo ' = Resultado para: ' .$t.'<br>';
    if($t == Titulo){
       while($rows_cursos = mysqli_fetch_array($resultado_cursos)){
           echo '<tr>';
        echo '<td>' .$i.'</td>';
        echo '<td>' .$rows_cursos['titulo'].'</td>';
        echo '<td>' .$rows_cursos['autor'].'</td>';
        echo '</tr>';
       $i +=1;
      } 
    }
         if( $t == Autor){
            $result_cursos = "SELECT titulo, autor FROM livros WHERE autor LIKE '%$pesquisar%' ";
            $resultado_cursos = mysqli_query($conn, $result_cursos);
            
            while($rows_cursos = mysqli_fetch_array($resultado_cursos)){
                echo '<tr>';
                echo '<td>' .$i.'</td>';
                echo ' <td>' .$rows_cursos['titulo']. ' </td>';
                echo '<td>' .$rows_cursos['autor'].'</td>';
                echo '</tr>';
               $i +=1;
          }
        }
              if($t == Categoria){
                $ident= 'Categoria';
                $result_cursos = "SELECT titulo,categoria FROM livros WHERE categoria LIKE '%$pesquisar%' ";
                $resultado_cursos = mysqli_query($conn, $result_cursos);

                while($rows_cursos = mysqli_fetch_array($resultado_cursos)){
                    echo '<tr>';
                    echo '<td>' .$i.'</td>';
                    echo '<td>' .$rows_cursos['titulo'].'</td>';
                    echo '<td>' .$rows_cursos['categoria'].'</td>';
                    echo '</tr>';
                   $i +=1;
              }
            }

            if($t == ISBN){
                $result_cursos = "SELECT titulo,ISBN FROM livros WHERE ISBN LIKE '%$pesquisar%' ";
                $resultado_cursos = mysqli_query($conn, $result_cursos);

                while($rows_cursos = mysqli_fetch_array($resultado_cursos)){
                    echo '<tr>';
                    echo '<td>' .$i.'</td>';
                    echo '<td>' .$rows_cursos['titulo'].'</td>';
                    echo '<td>' .$rows_cursos['ISBN'].'</td>';
                    echo '</tr>';
                   $i +=1;
              }
            }
    
?>
     </table>
    </body>
 </html>