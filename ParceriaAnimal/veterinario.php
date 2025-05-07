<?php

    session_start();

    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    require_once "model/Veterinario.php";
    require_once "configs/utils.php";
    require_once "configs/methods.php";

    if(isMetodo("POST")){
        if(parametrosValidos($_SESSION, ["idVeterinario"])){
            responder(401, ["status" => "Negado, você já está logado!"]);
        }

        if(parametrosValidos($_POST, ["email", "senha", "fazerLogin"])){
            $email = $_POST["email"];
            $senha = $_POST["senha"];
    
            $resultado = Veterinario::fazerLogin($email, $senha);
    
            if(!$resultado){
                responder(401, ["status" => "Email ou senha incorretos!"]);
            }
            $_SESSION["idVeterinario"] = $resultado;
            responder(200,["status" => "Seja bem-vindo!"]);
        }

        if (parametrosValidos($_POST, ["nome", "email", "telefone", "senha"])) {
            $nome = $_POST["nome"];
            $email = $_POST["email"];
            $telefone = $_POST["telefone"];
            $senha = $_POST["senha"];
    
            if ( (!Veterinario::existeEmail($email)) && (!Veterinario::existeTelefone($telefone)) ) {
                if (Veterinario::cadastrar($nome, $email, $telefone, $senha)) {
                    $msg = ["status" => "Cadastro de veterinário realizado com sucesso!"];
                    responder(201, $msg);
                } else {
                    $msg = ["status" => "Cadastro não pode ser realizado!"];
                    responder(500, $msg);
                }
            }else{
                $msg = ["status" => "Este veterinário já existe"];
                responder(400, $msg);
            }
        }else{
            responder(404, ["status" => "Parâmetros inválidos!"]);
        }
    }

    if(isMetodo("GET")){
        if(parametrosValidos($_GET, ["logout"])){
            session_destroy();
            responder(200, ["status" => "Chegou ao fim!"]);
        }

        if(parametrosValidos($_GET, ["id"])){
            $id = $_GET["id"];

            if(Veterinario::existeId($id)){
                $resultado = Veterinario::listarUm($id);
                responder(200, $resultado);
            }else{
                $msg = ["status" => "Este veterinário não existe"];
                responder(400, $msg);
            }
        }else{
            $resultado = Veterinario::listarTodos();

            if($resultado == []){
                responder(200, ["status" => "Tabela vazia - Não há veterinários cadastrados!"]);
            }else{
                responder(200, $resultado);
            }
        }
    }

    if(isMetodo("PUT")){
        if(!parametrosValidos($_SESSION, ["idVeterinario"])){
            responder(401, ["status" => "Negado, você não está logado!"]);
        }

        if(parametrosValidos($_PUT,["nome", "email", "telefone", "senhaAtual", "senhaNova"])){
            $id = $_SESSION["idVeterinario"];
            $email = $_PUT["email"];
            $telefone = $_PUT["telefone"];

            if( (!Veterinario::existeEmailId($email, $id)) && (!Veterinario::existeTelefoneId($telefone, $id)) ){
                $nome = $_PUT["nome"];
                $senhaAtual = $_PUT["senhaAtual"];
                $senhaNova = $_PUT["senhaNova"];

                $resultado = Veterinario::alterar($id, $nome, $email, $telefone, $senhaAtual, $senhaNova);
                if($resultado){
                    responder(200, ["status" => "Veterinário editado com sucesso!"]);
                }else{
                    responder(500, ["status" => "Erro ao editar o veterinário!"]);
                }
            }else{
                responder(400, ["status" => "Não é permitido dois ou mais veterinários possuirem o mesmo e-mail ou telefone!"]);
            }
        }else{
            responder(400, ["status" => "Parâmetros invalidos!"]);
        }
    }

    if (isMetodo("DELETE")) {
        if(!parametrosValidos($_SESSION, ["idVeterinario"])){
            responder(401, ["status" => "Negado, você não está logado!"]);
        }

        $id = $_SESSION["idVeterinario"];

        $resultado = Veterinario::deletar($id);
        if($resultado){
            session_destroy();
            responder(200, ["status" => "Veterinário deletado com sucesso! Sua sessão chegou ao fim!"]);
        } else {
            responder(500, ["status" => "Erro ao deletar o veterinário!"]);
        }
    }
?>