<?php
session_start();
require 'classes/anuncios.class.php';
require 'config.php';
if (isset($_SESSION['cLogin']) && !empty($_SESSION['cLogin'])) {
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $idDescode = $_GET['id'];
       //  echo $idDescode;
        $a = new Anuncios($pdo);
        //$excluir = $a->desativarAnuncio($idDescode);
        $idAnuncio = $a->desativarImagem($idDescode);
        $idAnuncio = base64_encode($idAnuncio->id_anuncio);
        if (isset($idAnuncio)) {
            header("Location: editar-anuncio.php?id=".$idAnuncio);
            exit;
        } else {
            header('Location: meus-anuncios.php');
            exit;
        }

    } else {
        header('Location: meus-anuncios.php');
    }
} else {
    header('Location: login.php');
    exit;
}

