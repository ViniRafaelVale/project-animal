<?php
    require_once "configs/BancoDados.php";

    Class Veterinario{

        public static function existeEmailId($email, $id){
            try{
                $conexao = Conexao::getConexao();
                $sql = $conexao->prepare("
                    select count(*) from veterinario where Email = ? and Id not in (?)
                ");
                $sql->execute([$email, $id]);
    
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

        public static function existeEmail($email){
            try{
                $conexao = Conexao::getConexao();
                $sql = $conexao->prepare("
                    select count(*) from veterinario where Email = ?
                ");
                $sql->execute([$email]);
    
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

        public static function existeTelefoneId($telefone, $id){
            try{
                $conexao = Conexao::getConexao();
                $sql = $conexao->prepare("
                    select count(*) from veterinario where Telefone = ? and Id not in (?)
                ");
                $sql->execute([$telefone, $id]);
    
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

        public static function existeTelefone($telefone){
            try{
                $conexao = Conexao::getConexao();
                $sql = $conexao->prepare("
                    select count(*) from veterinario where Telefone = ?
                ");
                $sql->execute([$telefone]);
    
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

        public static function cadastrar($nome, $email, $telefone, $senha){
            try{
                $senhaCriptografada = password_hash($senha, PASSWORD_BCRYPT);

                $conexao = Conexao::getConexao();
                $sql = $conexao->prepare("
                    insert into veterinario (Nome, Email, Telefone, Senha) values (?, ?, ?, ?)
                ");
                $sql->execute([$nome, $email, $telefone, $senhaCriptografada]);

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

        public static function fazerLogin($email, $senha){
            try {
                $conexao = Conexao::getConexao();
                $sql = $conexao->prepare("
                    select * from veterinario where Email = ?
                ");
                $sql->execute([$email]);

                $resultado = $sql->fetchAll();

                if($resultado == []){
                    return false;
                }else{
                    if(password_verify($senha, $resultado[0]["Senha"])){
                        return $resultado[0]["Id"];
                    }else{
                        return false;
                    }
                }
            } catch (Exception $e) {
                echo $e->getMessage();
                exit;
            }
        }

        public static function listarTodos(){
            try{
                $conexao = Conexao::getConexao();
                $sql = $conexao->prepare("
                    select Id, Nome, Email, Telefone from veterinario;
                ");
                $sql->execute();

                return $sql->fetchAll();
            }catch(Exception $e){
                echo $e->getMessage();
                exit;
            }
        }

        public static function existeId($id){
            try{
                $conexao = Conexao::getConexao();
                $sql = $conexao->prepare("
                    select count(*) from veterinario where Id = ?
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
                    select Id, Nome, Email, Telefone from veterinario where Id = ?
                ");
                $sql->execute([$id]);

                return $sql->fetchAll();
            }catch(Exception $e){
                echo $e->getMessage();
                exit;
            }
        }

        public static function alterar($id, $nome, $email, $telefone, $senhaAtual, $senhaNova){
            try{
                $conexao = Conexao::getConexao();
                $sql = $conexao->prepare("
                    select * from veterinario where Id = ?
                ");
                $sql->execute([$id]);

                $resultado = $sql->fetchAll();

                if(password_verify($senhaAtual, $resultado[0]["Senha"])){
                    $senhaCriptografada = password_hash($senhaNova, PASSWORD_BCRYPT);

                    $sql1 = $conexao->prepare("
                        update veterinario set Nome = ?, Email = ?, Telefone = ?, Senha = ? where Id = ?
                    ");
                    $sql1->execute([$nome, $email, $telefone, $senhaCriptografada, $id]);

                    if($sql1->rowCount() > 0){
                        return true;
                    }else{
                        return false;
                    }
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
                    delete from consulta where Id_Veterinario = ?
                ");
                $sql1 = $conexao->prepare("
                    delete from veterinario where Id = ?
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
    }
?>