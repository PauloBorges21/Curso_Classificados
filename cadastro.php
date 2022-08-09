<?php
include('inc/header.php');
require 'classes/usuarios.class.php';
require 'config.php';
?>
    <div class="container">
        <h1>Cadastre-se</h1>
        <?php
        $u = new Usuarios($pdo);
        if (isset($_POST['email']) && !empty($_POST['email'])) {
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
            $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);

            if (!empty($nome) && !empty($email) && !empty($senha) && !empty($telefone)) {

                if ($u->verificaUsuario($email)) {
                    if ($u->cadastrar($nome, $email, $senha, $telefone)) {
                        ?>
                        <div class="alert alert-success"><strong>Parabéns</strong> Cadastrado com sucesso.<a
                                    href="login.php">Faça seu login agora</a></div>
                    <?php
                    } else {
                        echo 'erro na inserção no banco de dados';
                    }
                } else {
                    ?>
                    <div class="alert alert-warning">Usuário já Cadastrado.<a
                                href="login.php">Faça seu login agora</a></div>
                <?php }

            } else {
                ?>
                <div class="alert alert-warning">Preencha Todos os Campos</div>
            <?php }
        }

        ?>
        <form method="post" action="">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome" class="form-control">
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" name="email" id="email" class="form-control">
            </div>

            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="senha" class="form-control">
            </div>

            <div class="form-group">
                <label for="telefone">Telefone:</label>
                <input type="telefone" name="telefone" id="telefone" class="form-control">
            </div>
            <input type="submit" value="Cadastrar" class="btn btn-default">


        </form>
    </div>

<?php
include 'inc/footer.php';
?>