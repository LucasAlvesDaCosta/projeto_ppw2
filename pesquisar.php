<?php
    $servidor = "localhost:3307";
    $usuario = "root";
    $senha = "Gravidade";
    $dbname = "tutocrudphp";
    //Criar a conexao
    $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
    
    $pesquisar = $_POST['pesquisar'];
    $result_cursos = "SELECT titulo FROM livros WHERE titulo LIKE '%$pesquisar%' ";
    $resultado_cursos = mysqli_query($conn, $result_cursos);
    $i =1;
    $t = $_POST['select'];
    echo 'Tipo: ' .$t.'<br>';
    if($t == Titulo){
       while($rows_cursos = mysqli_fetch_array($resultado_cursos)){
        echo 'Resultado ' .$i.': ';
        echo ' ' .$rows_cursos['titulo'].'<br>';
       $i +=1;
      } 
    }
         if( $t == Autor){
            $result_cursos = "SELECT titulo, autor FROM livros WHERE autor LIKE '%$pesquisar%' ";
            $resultado_cursos = mysqli_query($conn, $result_cursos);
            
            while($rows_cursos = mysqli_fetch_array($resultado_cursos)){
                echo 'Resultado ' .$i.': ';
                echo ' ' .$rows_cursos['titulo']. ' ____ '; echo 'Autor:( ' .$rows_cursos['autor'].')<br>';
               $i +=1;
          }
        }
              if($t == Categoria){
                $result_cursos = "SELECT titulo,categoria FROM livros WHERE categoria LIKE '%$pesquisar%' ";
                $resultado_cursos = mysqli_query($conn, $result_cursos);

                while($rows_cursos = mysqli_fetch_array($resultado_cursos)){
                    echo 'Resultado ' .$i.': ';
                    echo ' ' .$rows_cursos['titulo'].' |-----| ';echo 'Categoria:( ' .$rows_cursos['categoria'].')<br>';
            
                   $i +=1;
              }
            }
    
?>

 <html>
     <head>
         <title> Resultado da busca.</title>
     </head>
 </html>