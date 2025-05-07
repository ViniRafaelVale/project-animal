<?php
    require_once "configs/BancoDados.php";

    Class Consulta{

        public static function cadastrar($idVeterinario, $idAnimal, $data, $hora, $tipo, $custo){
            try{
                $conexao = Conexao::getConexao();
                $sql = $conexao->prepare("
                    insert into consulta (Id_Veterinario, Id_Animal, Data, Hora, Tipo, Custo) values (?, ?, ?, ?, ?, ?)
                ");
                $sql->execute([$idVeterinario, $idAnimal, $data, $hora, $tipo, $custo]);

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
                    select c.Id_Veterinario, v.Nome, c.Id_Animal, a.nome, c.Data, c.Hora, c.Tipo, c.Custo from consulta as c join animal as a on a.Id = c.Id_Animal join veterinario as v on v.Id = c.Id_Veterinario;
                ");
                $sql->execute();

                return $sql->fetchAll();
            }catch(Exception $e){
                echo $e->getMessage();
                exit;
            }
        }

        public static function existeConsulta($idVeterinario, $idAnimal, $data, $hora){
            try{
                $conexao = Conexao::getConexao();
                $sql = $conexao->prepare("
                    select count(*) from consulta where Id_Veterinario = ? and Id_Animal = ? and Data = ? and Hora = ?
                ");
                $sql->execute([$idVeterinario, $idAnimal, $data, $hora]);

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

        public static function listarUm($idVeterinario, $idAnimal, $data, $hora){
            try{
                $conexao = Conexao::getConexao();
                $sql = $conexao->prepare("
                    select c.Id_Veterinario, v.Nome, c.Id_Animal, a.nome, c.Data, c.Hora, c.Tipo, c.Custo from consulta as c join animal as a on a.Id = c.Id_Animal join veterinario as v on v.Id = c.Id_Veterinario where c.Id_Veterinario = ? and c.Id_Animal = ? and c.Data = ? and c.Hora = ?;
                ");
                $sql->execute([$idVeterinario, $idAnimal, $data, $hora]);

                return $sql->fetchAll();
            }catch(Exception $e){
                echo $e->getMessage();
                exit;
            }
        }

        public static function alterar($idVeterinario, $idAnimal, $data, $hora, $tipo, $custo){
            try{
                $conexao = Conexao::getConexao();
                $sql = $conexao->prepare("
                    update consulta set tipo = ?, custo = ? where Id_Veterinario = ? and Id_Animal = ? and Data = ? and Hora = ?
                ");
                $sql->execute([$tipo, $custo, $idVeterinario, $idAnimal, $data, $hora]);

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

        public static function deletar($idVeterinario, $idAnimal, $data, $hora){
            try{
                $conexao = Conexao::getConexao();
                $sql = $conexao->prepare("
                    delete from consulta where Id_Veterinario = ? and Id_Animal = ? and Data = ? and Hora = ?
                ");
                $sql->execute([$idVeterinario, $idAnimal, $data, $hora]);

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

        //Listar as consultas de um determinado animal
        public static function consultasAnimal($idAnimal){
            try {
                $conexao = Conexao::getConexao();
                $sql = $conexao->prepare("
                    select c.Id_Veterinario, v.Nome, c.Id_Animal, a.nome, c.Data, c.Hora, c.Tipo, c.Custo from consulta as c join animal as a on a.Id = c.Id_Animal join veterinario as v on v.Id = c.Id_Veterinario where a.Id = ?
                ");
                $sql->execute([$idAnimal]);

                return $sql->fetchAll();
            }catch(Exception $e){
                echo $e->getMessage();
                exit;
            }
        }

        //Mostrar o faturamento da clínica por dia
        public static function faturamentoClinica(){
            try {
                $conexao = Conexao::getConexao();
                $sql = $conexao->prepare("
                    select Data, sum(Custo) from consulta group by Data;
                ");
                $sql->execute();

                return $sql->fetchAll();
            }catch(Exception $e){
                echo $e->getMessage();
                exit;
            }
        }

        //Listar as consultas que aconteceram/acontecerão na mesma data
        public static function consultasData($data){
            try {
                $conexao = Conexao::getConexao();
                $sql = $conexao->prepare("
                    SELECT * FROM consulta where Data = ?
                ");
                $sql->execute([$data]);

                return $sql->fetchAll();
            } catch (Exception $e) {
                echo $e->getMessage();
                exit;
            }
        }
    }
?>