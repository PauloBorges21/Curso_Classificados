<?php


class anuncioAddController extends controller
{
    public function index()
    {
        $dados = [];

        if (empty($_SESSION['cLogin'])) {
            header("Location: " . BASE_URL);
            exit;
        }
        $c = new Categorias();
        $categorias = $c->getLista();
        $dados['categorias'] = $categorias;
        $this->loadTemplate('anuncioAdd', $dados);

    }

    public function 

}