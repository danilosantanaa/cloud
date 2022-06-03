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
                $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
                $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_SPECIAL_CHARS);
                $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

                // Verificando se os dados foram digitado corretamente
                if(strlen($nome) < 5) throw new Exception('O nome deve ter pelo menos 5 caracteres!');
            
                // verificar o email
                if(strlen($email) < 5) throw new Exception('O email deve ter pelo menos 5 caracteres!');

                // verificar o email
                if(strlen($telefone) < 7) throw new Exception('O Telefone deve ter pelo menos 7 caracteres!');
                if(strlen($telefone) > 15) throw new Exception('O Telefone ser menor que 15 máximo!');

                // Query SQL
                $sql = "insert into tb_cliente (nome, telefone, email) VALUES (:NOME, :TELEFONE, :EMAIL)";

                // Preparando a consulta SQL
                $stmt = $conn->prepare($sql);
    
                $stmt->bindParam(":NOME", $nome, PDO::PARAM_STR);
                $stmt->bindParam(":TELEFONE", $telefone, PDO::PARAM_STR);
                $stmt->bindParam(":EMAIL", $email, PDO::PARAM_STR);
                
                $stmt->execute();
    
                if($stmt->rowCount()) {
                    echo json_encode(array(
                        "sucesso" => "Dados do cliente cadastrado com sucesso!"
                    ));
                } else {
                    echo json_encode(array(
                        "erro" => "Erro ao cadastrar cliente!"
                    ));
                }
            } catch(PDOException $e) {
                echo json_encode( array ("erro" => $e->getMessage()));
            } catch(Exception $e) {
                echo json_encode( array ("erro" => $e->getMessage()));
            }
            break;

            case "EDITAR":
                try {
                    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
                    $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_SPECIAL_CHARS);
                    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
                    $id = filter_input(INPUT_POST, 'idUser', FILTER_SANITIZE_ENCODED);

                    // Verificando se os dados foram digitado corretamente
                    if(strlen($nome) < 5) throw new Exception('O nome deve ter pelo menos 5 caracteres!');
                
                    // verificar o email
                    if(strlen($email) < 5) throw new Exception('O email deve ter pelo menos 5 caracteres!');
    
                    // verificar o telefone
                    if(strlen($telefone) < 7) throw new Exception('O Telefone deve ter pelo menos 7 caracteres!');
                    if(strlen($telefone) > 15) throw new Exception('O Telefone ser menor que 15 máximo!');

                    // Query SQL
                    $sql = "UPDATE `tb_cliente` SET `nome` = :NOME, `telefone` = :TELEFONE, `email` = :EMAIL WHERE (`id` = :ID);";
    
                    // Preparando a consulta SQL
                    $stmt = $conn->prepare($sql);
        
                    $stmt->bindParam(":NOME", $nome, PDO::PARAM_STR);
                    $stmt->bindParam(":TELEFONE", $telefone, PDO::PARAM_STR);
                    $stmt->bindParam(":EMAIL", $email, PDO::PARAM_STR);
                    $stmt->bindParam(":ID", $id, PDO::PARAM_STR);

                    $stmt->execute();
        
                   
                    echo json_encode(array(
                        "sucesso" => "Dados do cliente atualizado com sucesso!"
                    ));
                   
                } catch(PDOException $e) {
                    echo json_encode( array ("erro" => $e->getMessage()));
                } catch(Exception $e) {
                    echo json_encode( array ("erro" => $e->getMessage()));
                }
                break;
        case "CEMAIL":
            $email = $_GET['email'] ?? null;
            $id = $_GET['id'] ?? 0;

            if($email != null) {
                $sql = "SELECT * FROM tb_cliente WHERE email= :EMAIL". ($id > 0 ? " and id != :ID" : "");
                
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":EMAIL", $email, PDO::PARAM_STR);
                if($id > 0) {
                    $stmt->bindParam(":ID", $id, PDO::PARAM_STR);
                }
                $stmt->execute();

                echo json_encode(array(count($stmt->fetchAll())));
            }
            break;
            case "DEL":
                $id = $_GET['id'] ?? 0;
    
                if($id > 0) {
                    $sql = "DELETE FROM tb_cliente WHERE  id = :ID";
                    
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