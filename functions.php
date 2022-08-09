<?php
//Paginação

function paginacao($totalAnuncios)
{
    $quantidadePorPagina = 2;
    //estamos arredondando para cima,por exemplo se a conta der 2.1 vai ser arredondado para 3 para ir para proxima pagina
    $totalPaginas = ceil($totalAnuncios / $quantidadePorPagina);

    for ($i = 1; $i <= $totalPaginas; $i++):
        $htmlLi = '<li><a href="index.php?p='.$i.'">' . $i . '</a></li>';
    endfor;

   echo $htmlLi;
}
