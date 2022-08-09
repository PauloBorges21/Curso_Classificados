<?php

require 'inc/header.php';
require 'classes/anuncios.class.php';

$user = new Usuarios($pdo);

$a = new Anuncios($pdo);
$u = new Usuarios($pdo);

if (!isset($_SESSION['cLogin']) && empty($_SESSION['cLogin'])) { ?>
    <script type="text/javascript">window.location.href = "login.php";</script>
  <?php  } else {
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id = addslashes($_GET['id']);

        $infoI = $a->getImagensAnuncio(base64_decode($id));
        $infoA = $a->getDadosAnuncio(base64_decode($id));

    } else { ?>
        <script type="text/javascript">window.location.href = "index.php";</script>
    <?php }
}
?>
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-5">
               <div class="carousel slide" data-ride="carousel" id="meuCarousel">
                   <div class="carousel-inner" role="listbox">
                       <?php foreach ($infoI as $key => $fotos) :?>
                        <div class="item <?php echo ($key == '0') ? 'active':''; ?>">
                            <img src="assets/images/anuncios/<?php echo $fotos->url;?>">
                        </div>
                       <?php endforeach;?>
                   </div>

                   <a class="left carousel-control" href="#meuCarousel" role="button" data-slide="prev"><span><</span></a>
                   <a class="right carousel-control" href="#meuCarousel" role="button" data-slide="next"><span>></span></a>

               </div>
            </div>
            <div class="col-sm-7">
                <h1><?php echo $infoA->titulo ?></h1>
                <h4><?php echo $infoA->categoria ?></h4>
                <p><?php echo $infoA->descricao ?></p>
                <br>
                <h3>R$ <?php echo number_format($infoA->valor, 2) ?></h3>
                <h4>Telefone: <?php echo $infoA->telefone ?></h4>
            </div>
        </div>
    </div>

<?php
require 'inc/footer.php';
?>