<?php
require 'config.php';
require 'classes/anuncios.class.php';
$a = new Anuncios($pdo);
if (!isset($_SESSION['cLogin']) && empty($_SESSION['cLogin'])) {

    if (isset($_POST['titulo']) && !empty($_POST['titulo'])) {
        $idUsuario = filter_input(INPUT_POST, 'uid', FILTER_SANITIZE_NUMBER_INT);
        $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
        $idCategoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_NUMBER_INT);
        $valor = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_NUMBER_FLOAT);
        $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
        $estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING);

        $insereAnuncio = $a->insertAnuncio($idUsuario, $titulo, $idCategoria, $valor, $descricao, $estado);

        if ($insereAnuncio) {
            header('Location: meus-anuncios.php');
            exit;
        } else {
            header('Location: add-anuncio.php');
            exit;
        }
    }
} else {
    header('Location: login.php');
    exit;
}

