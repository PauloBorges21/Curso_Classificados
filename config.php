<?php
require 'environment.php';

$config = array();

if(ENVIRONMENT == 'development') {
    define('BASE_URL','http://localhost/classificados');
    $config['dbname'] = 'db_classificados';
    $config['host'] = 'localhost';
    $config['dbuser'] = 'root';
    $config['dbpass'] = '';

}elseif (ENVIRONMENT == 'deploy'){
    define("BASE_URL","https://deploy.rai.com.br/");
    $config['dbname'] = 'db_rating';
    $config['host'] = 'localhost';
    $config['dbuser'] = 'root';
    $config['dbpass'] = '';

}else{
    define("BASE_URL","https://producao.com.br/");
    $config['dbname'] = 'db_rating';
    $config['host'] = 'localhost';
    $config['dbuser'] = 'root';
    $config['dbpass'] = '';
}

try {
    $db = new stdClass;
    $db->driver = 'mysql';
    $db->host = $config['host'];
    $db->port = 3306;
    $db->database = $config['dbname'];
    $db->username = $config['dbuser'];
    $db->password = $config['dbpass'];
    $db->unixSocket = '';
    $db->charset = 'utf8';
    $db->options = [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_PERSISTENT => true
    ];
    $db->dns = "mysql:dbname={$db->database};port={$db->port};host={$db->host}";
    $pdo = new PDO($db->dns, $db->username, $db->password, $db->options);
} catch(PDOException $e) {
    echo "ERRO: ".$e->getMessage();
    exit;
}