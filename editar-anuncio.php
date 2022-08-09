<?php
require 'inc/header.php';

if (!isset($_SESSION['cLogin']) && empty($_SESSION['cLogin'])) { ?>
    <script type="text/javascript">window.location.href = "login.php";</script>
<?php }

require 'classes/anuncios.class.php';
require 'classes/categoria.class.php';
$a = new Anuncios($pdo);
$c = new Categoria($pdo);

$categorias = $c->getLista();
$idAnuncio = $_GET['id'];
$info = $a->getDadosAnuncio(base64_decode($idAnuncio));
?>
<div class="container">
    <h1>Meus Anúncios - Editar anúncio</h1>
    <form method="post" action="submit-anuncio-editar.php" enctype="multipart/form-data">
        <div class="form-group">
            <label for="categoria">Categoria:</label>
            <select name="categoria" id="categoria" class="form-control" required>
                <option selected disabled>Selecione</option>
                <?php foreach ($categorias as $item): ?>
                    <option <?php echo ($info->id_categoria == $item->id) ? 'selected="selected"' : ""; ?>
                            value="<?php echo $item->id ?>"><?php echo $item->categoria ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" id="titulo" class="form-control" value="<?php echo $info->titulo; ?>"
                   required>
        </div>
        <div class="form-group">
            <label for="titulo">Valor:</label>
            <input type="text" name="valor" id="valor" class="form-control" value="<?php echo $info->valor ?>" required>
        </div>
        <div class="form-group">
            <label for="descricao">Descrição:</label>
            <textarea class="form-control" name="descricao" id="descricao"
                      required><?php echo $info->descricao ?></textarea>
        </div>
        <div class="form-group">
            <label for="estado">Estado de conservação:</label>
            <select name="estado" id="estado" class="form-control" required>
                <option selected disabled>Selecione</option>
                <option value="1" <?php echo ($info->estado == '0') ? 'selected="selected"' : ''; ?>>Ruim</option>
                <option value="2"<?php echo ($info->estado == '1') ? 'selected="selected"' : ''; ?>>Bom</option>
                <option value="3"<?php echo ($info->estado == '2') ? 'selected="selected"' : ''; ?>>Ótimo</option>
            </select>
        </div>
        <input type="hidden" name="uid" value="<?php echo $_SESSION['cLogin'] ?>">
        <input type="hidden" name="aid" value="<?php echo base64_decode($idAnuncio) ?>">

        </br></br>
        <div class="form-group">
            <label for="add_foto">Fotos do anúncio:</label>
            <input type="file" name="fotos[]" multiple/>
            </br>

            <div class="panel panel-default">
                <div class="panel-heading">Fotos do Anúncio</div>
                <div class="panel-body">
                    <?php
                    $fotos = $a->getImagensAnuncio(base64_decode($idAnuncio));
                    if (isset($fotos)):
                        foreach ($fotos as $itens) :?>
                            <div class="foto-item">
                                <img src="assets/images/anuncios/<?php echo $itens->url ?>" class="img-thumbnail"
                                     border="0">
                                <a href="excluir-imagem.php?id=<?php echo $itens->id ?>"
                                   class="btn btn-default">Excluir</a>
                            </div>
                        <?php endforeach;
                    endif;
                    ?>
                </div>
            </div>
        </div>
        <input type="submit" name="enviar" value="Salvar" class="btn btn-default">

    </form>
</div>
<?php require 'inc/footer.php'; ?>
