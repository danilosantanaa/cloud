<?php
require_once("../config.php");

/**
 * API com objetivo de realizar um CRUD
 */

$action = $_GET["action"] ?? null;

if(!is_null($action)) {
    switch(strtoupper($action)){
        case "CRIAR":
            try {
                $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_SPECIAL_CHARS);
                $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS);
                $isativo = $_POST['isadmin'] ?? '0';

                // Verificando se os dados foram digitado corretamente
                if(strlen($usuario ) < 5) throw new Exception('O usuário deve ter pelo menos 5 caracteres!');
            
                // verificar o email
                if(strlen($senha) < 8) throw new Exception('O senha deve ter pelo menos 8 caracteres!');

                // verificar o email
                $isativo = $isativo == 'T' ? '1' : '0';

                // Query SQL
                $sql = "insert into tb_usuario(usuario, senha, is_admin) VALUES (:USUARIO, :SENHA, :ATV)";

                // Preparando a consulta SQL
                $stmt = $conn->prepare($sql);
    
                $stmt->bindParam(":USUARIO", $usuario, PDO::PARAM_STR);
                $senhaCrip =  password_hash($senha, PASSWORD_DEFAULT);
                $stmt->bindParam(":SENHA", $senhaCrip, PDO::PARAM_STR);
                $stmt->bindParam(":ATV", $isativo, PDO::PARAM_STR);
                
                $stmt->execute();
    
                if($stmt->rowCount()) {
                    echo json_encode(array(
                        "sucesso" => "Dados do usuario cadastrado com sucesso!"
                    ));
                } else {
                    echo json_encode(array(
                        "erro" => "Erro ao cadastrar usuario!"
                    ));
                }
            } catch(PDOException $e) {
                echo json_encode( array ("erro" => $e->getMessage()));
            } catch(Exception $e) {
                echo json_encode( array ("erro" => $e->getMessage()));
            }
            break;

        case "EDITAR":
            // Pode ser implementado aqui
        break;            
        case "CUSER":
            $usuario = $_GET['usuario'] ?? null;
            $id = $_GET['id'] ?? 0;

            if($usuario != null) {
                $sql = "SELECT * FROM tb_usuario WHERE usuario= :USUARIO". ($id > 0 ? " and id != :ID" : "");
                
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":USUARIO", $usuario, PDO::PARAM_STR);
                if($id > 0) {
                    $stmt->bindParam(":ID", $id, PDO::PARAM_STR);
                }
                $stmt->execute();

                echo json_encode(array(count($stmt->fetchAll())));
            }
            break;
            case "CATV":
                try {
                    $id = $_GET['id'] ?? 0;
                    $status = $_GET['atv'] ?? null;

                    // Verificando se foi informado corretamente os dados
                    if($id == 0 || $status == null) throw new Exception("Parâmentros informado inválido!");

                    // Verificando se foi passado os status corretamente
                    if($status != "0" && $status != "1") throw new Exception('Status passado possúi valores inválido!');

                    // Query que realizarar atualização no banco
                    $sql = "update tb_usuario set is_admin = :ATV where id = :ID";
                    
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":ID", $id, PDO::PARAM_STR);
                    $t = $status == "0" ? '0' : '1';
                    $stmt->bindParam(":ATV", $t, PDO::PARAM_STR);
            
                    $stmt->execute();
                    
                    // Verificando se houve alterações bem sucedida!
                    if($stmt->rowCount()) {
                        echo json_encode(array(
                            "sucesso" => "Usuário ".( $status == '1' ? 'ATIVADO' : 'DESATIVADO' ). "!"
                        ));
                    } else {
                        echo json_encode(array(
                            "erro" => "ERRO ao tentar atualizar o status de usuário!"
                        ));
                    }
    
                } catch(PDOException $e) {
                    echo json_encode( array ("erro" => $e->getMessage()));
                } catch(Exception $e) {
                    echo json_encode( array ("erro" => $e->getMessage()));
                }
                break;
            case "DEL":
                $id = $_GET['id'] ?? 0;
    
                if($id > 0) {
                    $sql = "DELETE FROM tb_usuario WHERE  id = :ID";
                    
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":ID", $id, PDO::PARAM_STR);
                    $stmt->execute();
    
                    if($stmt->rowCount()) {
                        echo json_encode(array(
                            "sucesso" => "Dados do cliente apagado com sucesso!"
                        ));
                    } else {
                        echo json_encode(array(
                            "erro" => "Erro ao apagar cliente!"
                        ));
                    }
                }
                break;
    }
}