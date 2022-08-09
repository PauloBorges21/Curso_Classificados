<?php
require 'inc/header.php';

?>


    <div class="container">
        <h1>Cadastre-se</h1>
        <?php
        $u = new Usuarios($pdo);
        if (isset($_POST['email']) && !empty($_POST['email'])) {

            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);


            if (!empty($email) && !empty($senha)) {

                if ($u->verificaUsuario($email) == false) {
                    if ($u->login($email, $senha)) {?>
                     <script type="text/javascript">window.location.href="./";</script>
                    <?php
                    } else {?>
            <div class="alert alert-warning">Usuário e/ou Senha errados!</div>
                    <?php }
                } else {
                    ?>
                    <div class="alert alert-warning">Usuário e/ou Senha errados!</div>
                <?php }

            } else {
                ?>
                <div class="alert alert-warning">Preencha Todos os Campos</div>
            <?php }
        }

        ?>
        <form method="post" action="">

            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" name="email" id="email" class="form-control">
            </div>

            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="senha" class="form-control">
            </div>


            <input type="submit" value="Enviar" class="btn btn-default">


        </form>
    </div>


<?php
require 'inc/footer.php';
?>