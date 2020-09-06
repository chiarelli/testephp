<?php


$servidor = 'testephp.infoideias.com.br';
$usuario = 'phalcont_teste01';
$senha = 'Ph01al98!@#';
$banco = 'phalcont_teste01';

// conectando com MYSQLI


$mysqli = new mysqli($servidor, $usuario, $senha, $banco);
if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());

$sql = "SELECT * FROM imobiliaria";
$result = $mysqli -> query($sql);
$pai = mysqli_fetch_array($result);

var_dump($pai);
echo "<BR><br>";


// conectando com PDO 
   
$con = new PDO("mysql:host=192.168.1.24;dbname=teste;charset=utf8", "root", "british@admin");
    
   
$rs = $con->prepare($sql);
$rs->execute();
$rows = $rs->fetchAll();
var_dump($rows);

		?>