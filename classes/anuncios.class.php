<?php


class Anuncios
{
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getTotalAnuncios($filtros)
    {
        $filtroString = array('1=1');
        //$filtroString = array();
        if (!empty($filtros['categoria'])) {
            $filtroString[] = 'tb_anuncios.id_categoria = :id_categoria';
        }
        if (!empty($filtros['preco'])) {
            $filtroString[] = 'tb_anuncios.valor BETWEEN :preco1 AND :preco2';
        }
        if (!empty($filtros['estado'])) {
            $filtroString[] = 'tb_anuncios.estado = :estado';
        }

        $sql = $this->pdo->prepare("SELECT COUNT(*) as c FROM tb_anuncios WHERE ".implode(' AND ',$filtroString));

        if (!empty($filtros['categoria'])) {
            $sql->bindValue(':id_categoria',$filtros['categoria']);
        }
        if (!empty($filtros['preco'])) {
            $preco = explode('-', $filtros['preco']);
            $sql->bindValue(':preco1',$preco['0']);
            $sql->bindValue(':preco2',$preco['1']);
        }
        if (!empty($filtros['estado'])) {
            $sql->bindValue(':estado',$filtros['estado']);
        }

        $sql->execute();
        $sql = $sql->fetch();
        return $sql;
    }

    public function getMeusAnuncios($idUsuario)
    {
        $anuncios = array();
        $sql = ("SELECT *,
        (SELECT tb_anuncios_imagem.url FROM tb_anuncios_imagem 
        WHERE tb_anuncios_imagem.id_anuncio = tb_anuncios.id AND ativo =1 limit 1 ) as url
        FROM tb_anuncios WHERE id_usuario = :id_usuario AND ativo = 1");
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_usuario", $idUsuario);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $anuncios = $sql->fetchAll();
        }
        return $anuncios;
    }

    public function getUltimosAnuncios($page, $qtPorPagina,$filtros)
    {

       // var_dump($filtros);

        //Page tem que começar de 0 e multiplicar pelo limite de quantidade por pagina
        $offset = ($page - 1) * $qtPorPagina;

        //   O array tem esse parametro para bular a consulta se tiver vazia, temos o WHERE na consulta por isso    precisamos desse  macete;
        $filtroString = array('1=1');
        //$filtroString = array();
        if (!empty($filtros['categoria'])) {
            $filtroString[] = 'tb_anuncios.id_categoria = :id_categoria';
        }
        if (!empty($filtros['preco'])) {
            $filtroString[] = 'tb_anuncios.valor BETWEEN :preco1 AND :preco2';
        }
        if (!empty($filtros['estado'])) {
            $filtroString[] = 'tb_anuncios.estado = :estado';
        }


        $anuncios = array();
        $sql = ("SELECT *,
        (SELECT tb_anuncios_imagem.url FROM tb_anuncios_imagem 
        WHERE tb_anuncios_imagem.id_anuncio = tb_anuncios.id AND ativo =1 limit 1 ) as url,
        (SELECT tb_categoria.categoria FROM tb_categoria 
        WHERE tb_categoria.id = tb_anuncios.id_categoria AND ativo =1 ) as categoria
        FROM tb_anuncios WHERE ativo =1 AND ".implode(' AND ', $filtroString)."   ORDER BY id DESC LIMIT $offset , $qtPorPagina"
        );
        $sql = $this->pdo->prepare($sql);
        if (!empty($filtros['categoria'])) {
            $sql->bindValue(':id_categoria',$filtros['categoria']);
        }
        if (!empty($filtros['preco'])) {
            $preco = explode('-', $filtros['preco']);
            $sql->bindValue(':preco1',$preco['0']);
            $sql->bindValue(':preco2',$preco['1']);
        }
        if (!empty($filtros['estado'])) {
            $sql->bindValue(':estado',$filtros['estado']);
        }
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $anuncios = $sql->fetchAll();
        }
        return $anuncios;
    }

    public function getDadosAnuncio($id)
    {
        $array = array();
        $arrayFotos = array();
        $sql = ("SELECT *,
 (SELECT tb_categoria.categoria FROM tb_categoria 
        WHERE tb_categoria.id = tb_anuncios.id_categoria AND ativo =1 ) as categoria,
        (SELECT tb_usuarios.telefone FROM tb_usuarios 
        WHERE tb_usuarios.id = tb_anuncios.id_usuario AND ativo =1 ) as telefone
 FROM tb_anuncios WHERE id = :id AND ativo = 1");
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $array = $sql->fetch();
        }
        return $array;
    }

    public function getImagensAnuncio($id)
    {

        $sql = ("SELECT id,url FROM tb_anuncios_imagem WHERE id_anuncio = :id_anuncio AND ativo = 1");
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_anuncio", $id);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            return $sql->fetchAll();
        }
    }

    public function insertAnuncio($idUsuario, $titulo, $idCategoria, $valor, $descricao, $estado)
    {
        $sql = 'INSERT INTO tb_anuncios (id_usuario,titulo,id_categoria,valor,descricao,estado) VALUES (:id_usuario,:titulo,:id_categoria,:valor,:descricao,:estado)';
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_usuario", $idUsuario);
        $sql->bindValue(":titulo", $titulo);
        $sql->bindValue(":id_categoria", $idCategoria);
        $sql->bindValue(":valor", $valor);
        $sql->bindValue(":descricao", $descricao);
        $sql->bindValue(":estado", $estado);
        $sql->execute();

        return true;
    }

    public function insertAnuncioImagem($idAnuncio, $url)
    {
        $sql = 'INSERT INTO tb_anuncios_imagem (id_anuncio,url) VALUES (:id_anuncio,:url)';
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_anuncio", $idAnuncio);
        $sql->bindValue(":url", $url);
        $sql->execute();

        return true;
    }

    public function editarAnuncio($idUsuario, $titulo, $idCategoria, $valor, $descricao, $estado, $fotos, $idAnuncio)
    {
        $origi = "";

        $sql = 'UPDATE tb_anuncios SET id_usuario = :id_usuario,titulo = :titulo, id_categoria = :id_categoria, valor = :valor, descricao = :descricao, estado = :estado WHERE id = :id';
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_usuario", $idUsuario);
        $sql->bindValue(":titulo", $titulo);
        $sql->bindValue(":id_categoria", $idCategoria);
        $sql->bindValue(":valor", $valor);
        $sql->bindValue(":descricao", $descricao);
        $sql->bindValue(":estado", $estado);
        $sql->bindValue(":id", $idAnuncio);
        $sql->execute();

        if (count($fotos) > 0) {

            for ($i = 0; $i < count($fotos['tmp_name']); $i++) {
                $tipo = $fotos['type'][$i];

                if (in_array($tipo, array('image/jpeg', 'imagem/png'))) {
                    $tmpName = md5(time() . rand(0, 9999)) . '.jpg';
                    $destino = 'D:/laragon/www/Curso/projeto_classificados/assets/images/anuncios/';
                    $destinoFull = $destino . $tmpName;
                    move_uploaded_file($fotos['tmp_name'][$i], $destinoFull);

                    //Pegando altura e Largura da imagem com PHP
                    list($widthOrig, $heigthOrig) = getimagesize($destinoFull);

                    // Fazendo a conta para o PHP dimensionar a imagem
                    $ratio = $widthOrig / $heigthOrig;

                    // Declarando um Limite para a imagem inserida
                    $width = "500";
                    $heigth = "500";

                    if ($width / $heigth > $ratio) {
                        $width = $heigth * $ratio;
                    } else {
                        $heigth = $width / $ratio;
                    }

                    $img = imagecreatetruecolor($width, $heigth);
                    if ($tipo == 'image/jpeg') {
                        $origi = imagecreatefromjpeg($destinoFull);
                    } elseif ($tipo == 'image/png') {

                        $origi == imagecreatefrompng($destinoFull);
                    }

                    imagecopyresampled($img, $origi, 0, 0, 0, 0, $width, $heigth, $widthOrig, $heigthOrig);

                    imagejpeg($img, $destinoFull, 80);

                    $this->insertAnuncioImagem($idAnuncio, $tmpName);
                }
            }

        }

        return true;
    }

    public function desativarAnuncio($id)
    {
        $sql = 'SELECT url FROM tb_anuncios_imagem 
        WHERE id_anuncio = :id_anuncio limit 1';
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_anuncio", $id);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $sql = 'UPDATE tb_anuncios_imagem SET ativo = 0 where id_anuncio = :id_anuncio';
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':id_anuncio', $id);
            $sql->execute();
        }

        $sql = 'UPDATE tb_anuncios SET ativo = 0 where id = :id';
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();
    }

    public function excluirAnuncio($id)
    {
        $sql = 'DELETE FROM tb_anuncios_imagens where id_anuncio = :id_anuncio';
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue($id, ':id_anuncio');
        $sql->execute();

        $sql = 'DELETE FROM tb_anuncios where id = :id';
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue($id, ':id');
        $sql->execute();

    }

    public function desativarImagem($id)
    {
        $idUsu = 0;
        $sql = 'SELECT id_anuncio FROM tb_anuncios_imagem WHERE id = :id';
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $row = $sql->fetch();
            $idUsu = $row;
        }

        $sql = 'UPDATE tb_anuncios_imagem SET ativo = 0 where id = :id';
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        return $idUsu;
    }


}