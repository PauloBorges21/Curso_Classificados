<?php

require 'inc/header.php';
require 'classes/anuncios.class.php';
require 'classes/categoria.class.php';

$user = new Usuarios($pdo);

$a = new Anuncios($pdo);
$u = new Usuarios($pdo);
$c = new Categoria($pdo);

$filtros = array(
    'categoria' => '',
    'preco' => '',
    'estado' => '');

if (isset($_GET['filtros'])) {
    $filtros = $_GET['filtros'];
}

$totalAnuncio = $a->getTotalAnuncios($filtros);
$totalUsuario = $u->getTotalUsuarios();
$categoria = $c->getLista();
$p = 1;

if (isset($_GET['p']) && !empty($_GET['p'])) {
    $p = addslashes($_GET['p']);
}
$quantidadePorPagina = 2;
//estamos arredondando para cima,por exemplo se a conta der 2.1 vai ser arredondado para 3 para ir para proxima pagina
$totalPaginas = ceil($totalAnuncio->c / $quantidadePorPagina);


$ultimosAnuncios = $a->getUltimosAnuncios($p, $quantidadePorPagina, $filtros);
//$nameUser esta sendo puxado pelo header
?>
    <div class="container-fluid">
        <div class="jumbotron">
            <?php if (isset($_SESSION['cLogin']) && !empty($_SESSION['cLogin'])): ?>
                <h2>Bem Vindo <?= $nameUser->nome ?> </h2>
            <?php endif; ?>
            <h3>Nós temos hoje <?php echo $totalAnuncio->c; ?> Anúncios</h3>
            <p>E mais de <?= $totalUsuario->c; ?> usuários cadastrados</p>
        </div>

        <div class="row">
            <div class="col-sm-3">
                <h4>Pesquisa Avançada</h4>
                <form method="get">
                    <div class="form-group">
                        <label for="categoria" id="categoria">Categoria</label>
                        <select name="filtros[categoria]" class="form-control">
                            <option></option>
                            <?php foreach ($categoria as $cat): ?>
                                <option value="<?php echo $cat->id ?>" <?php echo ($cat->id == $filtros['categoria']) ? 'selected=selected' : ''; ?> ><?php echo $cat->categoria ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="preco" id="preco">Preço</label>
                        <select name="filtros[preco]" class="form-control">
                            <option></option>
                            <option value="0-50" <?php echo ($filtros['preco'] == '0-50') ? 'selected=selected' : ''; ?>>
                                R$ 0 - 50
                            </option>
                            <option value="51-100" <?php echo ($filtros['preco'] == '51-100') ? 'selected=selected' : ''; ?> >
                                R$ 51 - 100
                            </option>
                            <option value="101-200" <?php echo ($filtros['preco'] == '101-200') ? 'selected=selected' : ''; ?>>
                                R$ 101 - 200
                            </option>
                            <option value="201-500" <?php echo ($filtros['preco'] == '201-500') ? 'selected=selected' : ''; ?> >
                                R$ 101 - 500
                            </option>
                            <option value="501-10000000" <?php echo ($filtros['preco'] == '501-1000') ? 'selected=selected' : ''; ?> >
                                R$ 501 - 1000
                            </option>

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="estado" id="estado">Estado</label>
                        <select name="filtros[estado]" class="form-control">
                            <option></option>
                            <option value="1" <?php echo ($filtros['estado'] == '1') ? 'selected=selected' : ''; ?>>
                                Ruim
                            </option>
                            <option value="2" <?php echo ($filtros['estado'] == '2') ? 'selected=selected' : ''; ?> >
                                Bom
                            </option>
                            <option value="3" <?php echo ($filtros['estado'] == '3') ? 'selected=selected' : ''; ?>>
                                Ótimo
                            </option>

                        </select>
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-info" value="Buscar">
                    </div>


                </form>
            </div>
            <div class="col-sm-8">
                <h4>Últimos Anúncios</h4>
                <table class="table table-striped">
                    <tbody>
                    <?php foreach ($ultimosAnuncios as $anuncio): ?>
                        <tr>
                            <td><?php if ($anuncio && empty($anuncio->url)): ?>
                                    <img src="assets/images/default.png" alt="produto" title="icone produtos"
                                         height="50" border="0">
                                <?php else: ?>
                                    <img src="assets/images/anuncios/<?php echo $anuncio->url; ?>" height="100"
                                         border="0">
                                <?php endif; ?>
                            </td>

                            <td><a href="produto.php?id=<?php echo base64_encode($anuncio->id); ?>">
                                    <?php echo $anuncio->titulo; ?></a><br>
                                <?php echo $anuncio->categoria; ?>
                            </td>

                            <td>R$<?php echo number_format($anuncio->valor, 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <ul class="pagination">
                    <?php
                    for ($i = 1; $i <= $totalPaginas; $i++):?>
                        <li><a href="index.php?p=<?php echo $i ?>"><?php echo $i ?></a></li>
                    <?php endfor; ?>


                    <?php //paginacao($totalAnuncio->c) ?>

                </ul>
            </div>
        </div>

    </div>

<?php
// API config
$API_Key = 'AIzaSyD_107LHecTTnWS9jyb1MOM64b0WVkBUpU';
$Channel_ID = 'UCP8aDnT-gbkqnCjUPrIKsIQ';
$Max_Results = 10;
$apiError = 'Vídeo não encontrado';
// Get videos from channel by YouTube Data API
$apiData = @file_get_contents('https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&channelId=' . $Channel_ID . '&maxResults=' . $Max_Results . '&key=' . $API_Key . '');
if ($apiData) {
    $videoList = json_decode($apiData);
    //var_dump($videoList);
} else {
    echo 'Invalid API key or channel ID.';
}

if (!empty($videoList->items)) {
    foreach ($videoList->items as $item) {
        // Embed video
        if (isset($item->id->videoId)) {
            echo ' 
            <div class="yvideo-box"> 
                <iframe width="280" height="150" src="https://www.youtube.com/embed/' . $item->id->videoId . '" frameborder="0" allowfullscreen></iframe> 
                <h4>' . $item->snippet->title . '</h4> 
            </div>';
        }
    }
} else {
    echo '<p class="error">' . $apiError . '</p>';
}

require 'inc/footer.php';
?>