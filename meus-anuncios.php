<?php
require 'inc/header.php';
if (empty($_SESSION['cLogin'])) {
    header('Location: login.php');
    exit;
}
require 'classes/anuncios.class.php';

$a = new Anuncios($pdo);
$anuncios = $a->getMeusAnuncios($_SESSION['cLogin']);
?>

<div class="container">
    <h1>Meus Anúncios</h1>
    <a href="add-anuncio.php" class="btn btn-default">Adicionar Anúncio</a>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Foto</th>
            <th>Título</th>
            <th>Valor</th>
            <th>Ações</th>
        </tr>
        </thead>
        <?php
        foreach ($anuncios as $item): ?>
            <tr>
                <td> <?php if ($anuncios && empty($item->url) ): ?>
                        <img src="assets/images/default.png" alt="produto" title="icone produtos" height="50"
                             border="0">
                    <?php else: ?>
                        <img src="assets/images/anuncios/<?php echo $item->url ?>" height="100" border="0">


                    <?php endif; ?>
                </td>
                <td><?php echo $item->titulo ?></td>
                <td>R$<?php echo number_format($item->valor, 2) ?></td>
                <td>
                    <a href="editar-anuncio.php?id=<?php echo base64_encode($item->id) ?>" class="btn btn-warning">Editar</a>
                    <a href="excluir-anuncio.php?id=<?php echo base64_encode($item->id) ?>" class="btn btn-danger">Excluir</a>
                </td>

            </tr>

        <?php endforeach;
        ?>
    </table>
</div>


<?php
require 'inc/footer.php';
?>
