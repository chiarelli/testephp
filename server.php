<?php

error_reporting( E_ALL );

$servidor = 'testephp.infoideias.com.br';
$usuario = 'phalcont_teste01';
$senha = 'Ph01al98!@#';
$banco = 'phalcont_teste01';

require_once dirname(__FILE__) . '/includes/Infoideias_Server.php';

$server = new Infoideias_Server($servidor, $usuario, $senha, $banco);
$server->registerRouter();


// Testes

// $server->act_get_menu(['imobiliaria_id' => '99901']);