<?php


class Usuarios
{
    private $pdo;
    private $nome;
    private $email;
    private $senha;
    private $telefone;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @return mixed
     */
    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getSenha()
    {
        return $this->senha;
    }


    /**
     * @return mixed
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * @param mixed $telefone
     */
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    public function verificaUsuario($email)
    {
        $sql = "SELECT id FROM tb_usuarios where email = :email";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":email", $email);
        $sql->execute();
        if ($sql->rowCount() == 0) {
            return true;
        }
    }

    public function cadastrar($nome, $email, $senha, $telefone)
    {

        $sql = "INSERT INTO tb_usuarios (nome, email, senha, telefone) VALUES (:nome, :email, :senha, :telefone)";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":nome", $nome);
        $sql->bindValue(":email", $email);
        $sql->bindValue(":senha", md5($senha));
        $sql->bindValue(":telefone", $telefone);
        $sql->execute();

        return true;

    }

    public function login($email, $senha)
    {
    $sql= "SELECT id FROM tb_usuarios WHERE email = :email AND senha = :senha";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":email", $email);
        $sql->bindValue(":senha", md5($senha));
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $dado = $sql->fetch();
           $_SESSION['cLogin'] = $dado->id;
            return true;
        }else{
            return false;
        }
    }

    public function GetUser($id){
        $sql = "SELECT nome FROM tb_usuarios WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql-> execute();
        if ($sql->rowCount() > 0) {
            return $nameUser = $sql->fetch();
        }
    }

    public function getTotalUsuarios(){
        $sql = $this->pdo->query("SELECT COUNT(*) as c FROM tb_usuarios");
        $sql = $sql->fetch();
        return $sql;
    }

}