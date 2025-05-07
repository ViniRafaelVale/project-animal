<?php

    session_start();

    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    require_once "model/Animal.php";
    require_once "model/Veterinario.php";
    require_once "configs/utils.php";
    require_once "configs/methods.php";

    if(!parametrosValidos($_SESSION, ["idVeterinario"])){
        responder(401, ["status" => "Negado, você deve estar logado para acessar esta página!"]);
    }

    if(isMetodo("POST")){
        if (parametrosValidos($_POST, ["nome", "telefoneDono", "emailDono", "dataNas", "descricao"])) {
            $nome = $_POST["nome"];
            $telefoneDono = $_POST["telefoneDono"];
            $emailDono = $_POST["emailDono"];
            $dataNas = $_POST["dataNas"];
            $descricao = $_POST["descricao"];
    
            if(Animal::cadastrar($nome, $telefoneDono, $emailDono, $dataNas, $descricao)) {
                $msg = ["status" => "Cadastro de animal realizado com sucesso!"];
                responder(201, $msg);
            } else {
                $msg = ["status" => "Cadastro não pode ser realizado!"];
                responder(500, $msg);
            }
        }else{
            responder(404, ["status" => "Parâmetros inválidos!"]);
        }
    }

    if(isMetodo("GET")){
        if(parametrosValidos($_GET, ["idAnimal"])){
            $id = $_GET["idAnimal"];

            if(Animal::existeAnimal($id)){
                $resultado = Animal::listarUm($id);
                responder(200, $resultado);
            }else{
                $msg = ["status" => "Este animal não existe"];
                responder(400, $msg);
            }
        }else if(parametrosValidos($_GET, ["idVeterinario"])){
            $idVeterinario = $_GET["idVeterinario"];

            if(Veterinario::existeId($idVeterinario)){
                $resultado = Animal::animaisVeterinario($idVeterinario);
                if($resultado == []){
                    responder(200, ["status" => "Tabela vazia - Este veterinário ainda não consultou nenhum animal!"]);
                }else{
                    responder(200, $resultado);
                }
            }else{
                $msg = ["status" => "Este veterinário não existe!"];
                responder(400, $msg);
            }
        }else if(parametrosValidos($_GET, ["email", "telefone"])){
            $emailDono = $_GET["email"];
            $telefoneDono =$_GET["telefone"];

            $resultado = Animal::animaisDono($emailDono, $telefoneDono);
            if($resultado == []){
                responder(200, ["status" => "Tabela vazia - Não há animais cadastrados com esse e-mail e telefone!"]);
            }else{
                responder(200, $resultado);
            }
        }else{
            $resultado = Animal::listarTodos();

            if($resultado == []){
                responder(200, ["status" => "Tabela vazia - Não há animais cadastrados!"]);
            }else{
                responder(200, $resultado);
            }
        }
    }

    if(isMetodo("PUT")){
        if(parametrosValidos($_PUT,["id", "nome", "telefoneDono", "emailDono", "dataNas", "descricao"])){
            $id = $_PUT["id"];
            $nome = $_PUT["nome"];
            $telefoneDono = $_PUT["telefoneDono"];
            $emailDono = $_PUT["emailDono"];
            $dataNas = $_PUT["dataNas"];
            $descricao = $_PUT["descricao"];

            $resultado = Animal::alterar($id, $nome, $telefoneDono, $emailDono, $dataNas, $descricao);
            if($resultado){
                responder(200, ["status" => "Animal editado com sucesso!"]);
            }else{
                responder(500, ["status" => "Erro ao editar o animal!"]);
            }
        }else{
            responder(400, ["status" => "Parâmetros invalidos!"]);
        }
    }

    if(isMetodo("DELETE")) {
        if(parametrosValidos($_DELETE,["id"])){
            $id = $_DELETE["id"];
    
            $resultado = Animal::deletar($id);
            if($resultado){
                responder(200, ["status" => "Animal deletado com sucesso!"]);
            } else {
                responder(500, ["status" => "Erro ao deletar o animal!"]);
            }
        }else{
            responder(400, ["status" => "Parâmetros invalidos!"]);
        }
    }
?>