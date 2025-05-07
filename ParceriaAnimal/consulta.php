<?php

    session_start(); 

    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    require_once "model/Consulta.php";
    require_once "model/Veterinario.php";
    require_once "model/Animal.php";
    require_once "configs/utils.php";
    require_once "configs/methods.php";

    if(!parametrosValidos($_SESSION, ["idVeterinario"])){
        responder(401, ["status" => "Negado, você deve estar logado para acessar esta página!"]);
    }

    if(isMetodo("POST")){
        if (parametrosValidos($_POST, ["idAnimal", "data", "hora", "tipo", "custo"])) {
            $idVeterinario = $_SESSION["idVeterinario"];
            $idAnimal = $_POST["idAnimal"];

            if(Animal::existeAnimal($idAnimal)){
                $data = $_POST["data"];
                $hora = $_POST["hora"];

                if(Consulta::existeConsulta($idVeterinario, $idAnimal, $data, $hora)){
                    $msg = ["status" => "Esta consulta já existe"];
                    responder(400, $msg);
                }else{
                    $tipo = $_POST["tipo"];
                    $custo = $_POST["custo"];

                    if(Consulta::cadastrar($idVeterinario, $idAnimal, $data, $hora, $tipo, $custo)){
                        $msg = ["status" => "Cadastro de consulta realizado com sucesso!"];
                        responder(201, $msg);
                    }else{
                        $msg = ["status" => "Cadastro não pode ser realizado!"];
                        responder(500, $msg);
                    }
                }
            }else{
                $msg = ["status" => "O animal não existe!"];
                responder(400, $msg);
            }
        }else{
            responder(404, ["status" => "Parâmetros inválidos!"]);
        }
    }

    if(isMetodo("GET")){
        if(parametrosValidos($_GET, ["idVeterinario", "idAnimal", "data", "hora"])){
            $idVeterinario = $_GET["idVeterinario"];
            $idAnimal = $_GET["idAnimal"];
            $data = $_GET["data"];
            $hora = $_GET["hora"];

            if(Consulta::existeConsulta($idVeterinario, $idAnimal, $data, $hora)){
                $resultado = Consulta::listarUm($idVeterinario, $idAnimal, $data, $hora);
                responder(200, $resultado);
            }else{
                $msg = ["status" => "Esta consulta não existe"];
                responder(400, $msg);
            }
        }else if(parametrosValidos($_GET, ["idAnimal"])){
            $idAnimal = $_GET["idAnimal"];

            if(Animal::existeAnimal($idAnimal)){
                $resultado = Consulta::consultasAnimal($idAnimal);

                if($resultado == []){
                    responder(200, ["status" => "Tabela vazia - Este animal ainda não foi consultado!"]);
                }else{
                    responder(200, $resultado);
                }
            }else{
                $msg = ["status" => "Este animal não existe"];
                responder(400, $msg);
            }
        }else if(parametrosValidos($_GET, ["data"])){
            $data = $_GET["data"];

            $resultado = Consulta::consultasData($data);
            if($resultado == []){
                responder(200, ["status" => "Tabela vazia - Nenhuma consulta aconteceu/acontecerá nesta data!"]);
            }else{
                responder(200, $resultado);
            }
        }else if(parametrosValidos($_GET, ["faturamento"])){
            $resultado = Consulta::faturamentoClinica();

            if($resultado == []){
                responder(200, ["status" => "Tabela vazia - Não há consultas cadastradas, sem faturamentos!"]);
            }else{
                responder(200, $resultado);
            }
        }else{
            $resultado = Consulta::listarTodos();

            if($resultado == []){
                responder(200, ["status" => "Tabela vazia - Não há consultas cadastradas!"]);
            }else{
                responder(200, $resultado);
            }
        }
    }

    if(isMetodo("PUT")){
        if(parametrosValidos($_PUT,["idAnimal", "data", "hora", "tipo", "custo"])){
            $idVeterinario = $_SESSION["idVeterinario"];
            $idAnimal = $_PUT["idAnimal"];
            $data = $_PUT["data"];
            $hora = $_PUT["hora"];
            $tipo = $_PUT["tipo"];
            $custo = $_PUT["custo"];

            $resultado = Consulta::alterar($idVeterinario, $idAnimal, $data, $hora, $tipo, $custo);
            if($resultado){
                responder(200, ["status" => "Consulta editada com sucesso!"]);
            }else{
                responder(500, ["status" => "Erro ao editar a consulta!"]);
            }
        }else{
            responder(400, ["status" => "Parâmetros invalidos!"]);
        }
    }

    if(isMetodo("DELETE")) {
        if(parametrosValidos($_DELETE,["idAnimal", "data", "hora"])){
            $idVeterinario = $_SESSION["idVeterinario"];
            $idAnimal = $_DELETE["idAnimal"];
            $data = $_DELETE["data"];
            $hora = $_DELETE["hora"];
    
            $resultado = Consulta::deletar($idVeterinario, $idAnimal, $data, $hora);
            if($resultado){
                responder(200, ["status" => "Consulta deletada com sucesso!"]);
            } else {
                responder(500, ["status" => "Erro ao deletar a consulta!"]);
            }
        }else{
            responder(400, ["status" => "Parâmetros invalidos!"]);
        }
    }
?>