<?php


class Categoria
{
        public function __construct($pdo)
        {
            $this->pdo = $pdo;
        }

        public function getLista()
        {
            $categoriaArray =  array();

            $sql = ('SELECT * FROM tb_categoria where ativo = 1');
            $sql = $this->pdo->prepare($sql);
            $sql-> execute();
            if($sql->rowCount() > 0){
                $categoriaArray =  $sql->fetchAll();
            }

            return $categoriaArray;
        }
}