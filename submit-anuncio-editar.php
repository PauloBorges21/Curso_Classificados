<?php
require 'config.php';
require 'classes/anuncios.class.php';
$a = new Anuncios($pdo);
if (!isset($_SESSION['cLogin']) && empty($_SESSION['cLogin'])) {

    if (isset($_POST['titulo']) && !empty($_POST['titulo'])) {
        $idUsuario = filter_input(INPUT_POST, 'uid',  FILTER_SANITIZE_NUMBER_INT);
        $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
        $idCategoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_NUMBER_INT);
        $valor = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_NUMBER_FLOAT);
        $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
        $estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING);
        $idAnuncio = filter_input(INPUT_POST, 'aid',  FILTER_SANITIZE_NUMBER_INT);
        $fotos = $_FILES['fotos'];
        $idAnuncioT = base64_encode($idAnuncio);
       // $fotos = filter_input(INPUT_POST, 'fotos', FILTER_DEFAULT , FILTER_REQUIRE_ARRAY);
        if(!isset($fotos) || empty($fotos)  ){
        $fotos = array();
        }

      //  echo $idAnuncio ;
        //print_r($fotos);
        $insereAnuncio = $a->editarAnuncio($idUsuario, $titulo, $idCategoria, $valor, $descricao, $estado, $fotos,$idAnuncio);

        print_r($insereAnuncio);
        if ($insereAnuncio) {
            header("Location: editar-anuncio.php?id=".$idAnuncioT);
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

