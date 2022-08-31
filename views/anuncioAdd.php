<div class="container">
    <h1>Meus Anúncios - Adicionar novo anúncio</h1>
    <form method="post" action="submit-anuncio.php" enctype="multipart/form-data">
        <div class="form-group">
            <label for="categoria">Categoria:</label>
            <select name="categoria" id="categoria" class="form-control" required>
                <option selected disabled>Selecione</option>
                <?php foreach ($categorias as $item): ?>
                    <option value="<?php echo $item->id?>"><?php echo $item->categoria?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" id="titulo" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="titulo">Valor:</label>
            <input type="text" name="valor" id="valor" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="descricao">Descrição:</label>
            <textarea class="form-control" name="descricao" id="descricao" required></textarea>
        </div>
        <div class="form-group">
            <label for="estado">Estado de conservação:</label>
            <select name="estado" id="estado" class="form-control" required>
                <option selected disabled>Selecione</option>
                <option value="0">Ruim</option>
                <option value="1">Bom </option>
                <option value="2">Ótimo</option>
            </select>
        </div>
        <input type="hidden" name="uid" value="<?php echo $_SESSION['cLogin']?>" >
        <input type="submit" name="enviar" value="Enviar" class="btn btn-default">
    </form>
</div>
