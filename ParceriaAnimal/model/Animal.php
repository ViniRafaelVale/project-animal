<?php
    require_once "configs/BancoDados.php";

    Class Animal{

        public static function cadastrar($nome, $telefoneDono, $emailDono, $dataNas, $descricao){
            try{
                $conexao = Conexao::getConexao();
                $sql = $conexao->prepare("
                    insert into animal (Nome, Telefone_dono, Email_dono, Data_nas, Descricao) values (?, ?, ?, ?, ?)
                ");
                $sql->execute([$nome, $telefoneDono, $emailDono, $dataNas, $descricao]);

                if($sql->rowCount() > 0){
                    return true;
                }else{
                    return false;
                }
            }catch(Exception $e){
                echo $e->getMessage();
                exit;
            }
        }

        public static function listarTodos(){
            try{
                $conexao = Conexao::getConexao();
                $sql = $conexao->prepare("
                    select * from animal;
                ");
                $sql->execute();

                return $sql->fetchAll();
            }catch(Exception $e){
                echo $e->getMessage();
                exit;
            }
        }

        public static function existeAnimal($id){
            try{
                $conexao = Conexao::getConexao();
                $sql = $conexao->prepare("
                    select count(*) from animal where Id = ?
                ");
                $sql->execute([$id]);

                if($sql->fetchColumn() > 0){
                    return true;
                }else{
                    return false;
                }
            }catch(Exception $e){
                echo $e->getMessage();
                exit;
            }
        }

        public static function listarUm($id){
            try{
                $conexao = Conexao::getConexao();
                $sql = $conexao->prepare("
                    select * from animal where Id = ?
                ");
                $sql->execute([$id]);

                return $sql->fetchAll();
            }catch(Exception $e){
                echo $e->getMessage();
                exit;
            }
        }

        public static function alterar($id, $nome, $telefoneDono, $emailDono, $dataNas, $descricao){
            try{
                $conexao = Conexao::getConexao();
                $sql = $conexao->prepare("
                    update animal set Nome = ?, Telefone_dono = ?, Email_dono = ?, Data_nas = ?, Descricao = ? where Id = ?
                ");
                $sql->execute([$nome, $telefoneDono, $emailDono, $dataNas, $descricao, $id]);

                if($sql->rowCount() > 0){
                    return true;
                }else{
                    return false;
                }
            }catch(Exception $e){
                echo $e->getMessage();
                exit;
            }
        }

        public static function deletar($id){
            try{
                $conexao = Conexao::getConexao();

                $sql = $conexao->prepare("
                    delete from consulta where Id_Animal = ?
                ");
                $sql1 = $conexao->prepare("
                    delete from animal where Id = ?
                ");

                $sql->execute([$id]);
                $sql1->execute([$id]);

                if($sql1->rowCount() > 0){
                    return true;
                }else{
                    return false;
                }
            }catch(Exception $e){
                echo $e->getMessage();
                exit;
            }
        }

        //Listar os animais que um determinado veterinário já consultou
        public static function animaisVeterinario($idVeterinario){
            try {
                $conexao = Conexao::getConexao();
                $sql = $conexao->prepare("
                    SELECT a.* FROM animal a, veterinario v, consulta c WHERE c.Id_Veterinario = ? and c.Id_Veterinario = v.Id and c.Id_Animal = a.Id;
                ");
                $sql->execute([$idVeterinario]);

                return $sql->fetchAll();
            }catch(Exception $e) {
                echo $e->getMessage();
                exit;
            }
        }

        //Listar, em ordem alfabética, animais que tenham o mesmo telefone e email do dono
        public static function animaisDono($email, $telefone){
            try {
                $conexao = Conexao::getConexao();
                $sql = $conexao->prepare("
                    SELECT * FROM animal WHERE Email_dono= ? and Telefone_dono = ? ORDER BY Nome;
                ");
                $sql->execute([$email, $telefone]);

                return $sql->fetchAll();
            }catch(Exception $e) {
                echo $e->getMessage();
                exit;
            }
        }
    }
?>