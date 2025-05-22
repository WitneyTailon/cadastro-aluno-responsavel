<?php
class Model {
    private $connect;
    
    public function __construct() {
        try {
            $this->connect = new PDO("mysql:host=localhost;dbname=identificar_responsavel", 'root', 'mysql2024');
            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro de conexão: " . $e->getMessage());
        }
    }

    public function buscarEstudante($id_estudante) {
       try {
            $stmt = $this->connect->prepare("SELECT id, matricula, nome, curso, ano_ingresso FROM estudantes WHERE id = :id_estudante");
            $stmt->bindParam(":id_estudante", $id_estudante);
            $execute_status = $stmt->execute();
            if ($execute_status) {
                $estudante = $stmt->fetch(PDO::FETCH_ASSOC);
                return $estudante;
            }
       } catch (PDOException $e) {
            die("Erro ao buscar estudante: " . $e->getMessage());
       }
    }

    public function salvarEstudante($matricula_estudante, $nome_estudante, $curso_estudante, $ano_ingresso_estudante, $nome_responsavel, $contato_responsavel, $parentesco_responsavel, $ContResp) {
        try {
            // Inicia transação
            $this->connect->beginTransaction();
            
            // Insere o estudante
            $stmtEstudante = $this->connect->prepare("
                INSERT INTO estudantes (matricula, nome, curso, ano_ingresso) 
                VALUES (:matricula, :nome, :curso, :ano_ingresso)
            ");
            $stmtEstudante->bindParam(':matricula', $matricula_estudante);
            $stmtEstudante->bindParam(':nome', $nome_estudante);
            $stmtEstudante->bindParam(':curso', $curso_estudante);
            $stmtEstudante->bindParam(':ano_ingresso', $ano_ingresso_estudante);
            
            if (!$stmtEstudante->execute()) {
                throw new Exception("Falha ao inserir estudante");
            }
            
            // Obtém o ID do estudante inserido
            $id_estudante = $this->connect->lastInsertId();
            
            // Prepara a query para responsáveis uma única vez
            $stmtResponsavel = $this->connect->prepare("
                INSERT INTO responsaveis (id_estudante, nome, contato, parentesco) 
                VALUES (:id_estudante, :nome, :contato, :parentesco)
            ");
            
            if ($ContResp == 0) {
                $stmtResponsavel->closeCursor();
                
                // Faz novos bindings para cada responsável
                $stmtResponsavel->bindValue(':id_estudante', $id_estudante);
                $stmtResponsavel->bindValue(':nome', $nome_responsavel[0]);
                $stmtResponsavel->bindValue(':contato', $contato_responsavel[0]);
                $stmtResponsavel->bindValue(':parentesco', $parentesco_responsavel[0]);
                
                if (!$stmtResponsavel->execute()) {
                    $errorInfo = $stmtResponsavel->errorInfo();
                    throw new Exception("Falha ao inserir responsável #" . (0+1) . ": " . $errorInfo[2]);
                }
            }
            else {
                // Insere cada responsável
                for ($i = 0; $i < count($nome_responsavel); $i++) {
                    // Limpa os bindings anteriores
                    $stmtResponsavel->closeCursor();
                    
                    // Faz novos bindings para cada responsável
                    $stmtResponsavel->bindValue(':id_estudante', $id_estudante);
                    $stmtResponsavel->bindValue(':nome', $nome_responsavel[$i]);
                    $stmtResponsavel->bindValue(':contato', $contato_responsavel[$i]);
                    $stmtResponsavel->bindValue(':parentesco', $parentesco_responsavel[$i]);
                    
                    if (!$stmtResponsavel->execute()) {
                        $errorInfo = $stmtResponsavel->errorInfo();
                        throw new Exception("Falha ao inserir responsável #" . ($i+1) . ": " . $errorInfo[2]);
                    }
                }
            }
            
            // Confirma a transação
            $this->connect->commit();
            
            return $id_estudante;
            
        } catch (Exception $e) {
            // Reverte a transação em caso de erro
            if ($this->connect->inTransaction()) {
                $this->connect->rollBack();
            }
            error_log("Erro em salvarEstudante: " . $e->getMessage());
            throw $e;
        }
    }
    
    public function salvarResponsavel($id_estudante, $nome_responsavel, $contato_responsavel, $parentesco_responsavel){
        try {
            $stmt = $this->connect->prepare("
            INSERT INTO responsaveis (id_estudante, nome, contato, parentesco) 
            VALUES (:id_estudante, :nome, :contato, :parentesco)
            ");
            $stmt->bindParam(':id_estudante', $id_estudante);
            $stmt->bindParam(':nome', $nome_responsavel);
            $stmt->bindParam(':contato', $contato_responsavel);
            $stmt->bindParam(':parentesco', $parentesco_responsavel);
            $execute_status = $stmt->execute();
            if ($execute_status) {
                return $this->buscarEstudante($id_estudante);
            }
        } catch (PDOException $e) {
            die("Erro ao salvar responsavel: " . $e->getMessage());
        }
    }

    public function editarEstudante($id_estudante, $matricula_estudante, $nome_estudante, $curso_estudante, $ano_ingresso_estudante) {
        try {
            $stmt = $this->connect->prepare("
                UPDATE estudantes 
                SET matricula = :matricula, nome = :nome, curso = :curso, ano_ingresso = :ano_ingresso
                WHERE id = :id_estudante
            ");
            $stmt->bindParam(':id_estudante', $id_estudante);
            $stmt->bindParam(':matricula', $matricula_estudante);
            $stmt->bindParam(':nome', $nome_estudante);
            $stmt->bindParam(':curso', $curso_estudante);
            $stmt->bindParam(':ano_ingresso', $ano_ingresso_estudante);
            $execute_status = $stmt->execute();
            if ($execute_status) {
                return $this->buscarEstudante($id_estudante);
            }
            exit;
        } catch (PDOException $e) {
            die("Erro ao editar estudante: " . $e->getMessage());
        } 
    }

    public function editarResponsavel($id_estudante, $nome_responsavel, $novo_nome_responsavel, $contato_responsavel, $parentesco_responsavel) {
        try {
            $stmt = $this->connect->prepare("
                UPDATE responsaveis 
                SET nome = :nome, contato = :contato, parentesco = :parentesco
                WHERE id_estudante = :id_estudante AND nome = :antigo_nome
            ");
            $stmt->bindParam(':nome', $novo_nome_responsavel);
            $stmt->bindParam(':contato', $contato_responsavel);
            $stmt->bindParam(':parentesco', $parentesco_responsavel);
            $stmt->bindParam(':id_estudante', $id_estudante);
            $stmt->bindParam(':antigo_nome', $nome_responsavel);
            $execute_status = $stmt->execute();
            if ($execute_status) {
                return $this->buscarEstudante($id_estudante);
            }
            exit;
        } catch (PDOException $e) {
            die("Erro ao editar responsavel: " . $e->getMessage());
        } 
    }

    public function buscarEstudantes($filtroNome = null, $filtroAno = null, $filtroCurso = null) {
        try {
            $sql = "SELECT matricula, id, ano_ingresso, nome, curso FROM estudantes WHERE 1=1";
            $params = [];
            
            if ($filtroNome) {
                $sql .= " AND nome LIKE :nome";
                $params[':nome'] = '%' . $filtroNome . '%';
            }
            
            if ($filtroAno) {
                if ($filtroAno === 'concluido') {
                    $sql .= " AND ano_ingresso < 2023";
                } else {
                    $sql .= " AND ano_ingresso = :ano_ingresso";
                    $params[':ano_ingresso'] = $filtroAno;
                }
            }
            
            if ($filtroCurso) {
                $sql .= " AND curso = :curso";
                $params[':curso'] = $filtroCurso;
            }
            
            $stmt = $this->connect->prepare($sql);
            
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die("Erro ao buscar estudantes: " . $e->getMessage());
        }
    }

    public function buscarResponsaveis($id_estudante) {
        try {
            $stmt = $this->connect->prepare("SELECT id, nome, contato, parentesco FROM responsaveis WHERE id_estudante = :id_estudante");
            $stmt->bindParam(":id_estudante", $id_estudante);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die("Erro ao buscar responsável: " . $e->getMessage());
        }
    }

    // Adicionar função de deletar no Model.php
    public function deletarEstudante($id) {
        try {
            $stmt = $this->connect->prepare("DELETE FROM estudantes WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $executeStatus = $stmt->execute();
            if ($executeStatus) {
                $stmt = $this->connect->prepare("DELETE FROM responsaveis WHERE id_estudante = :id");
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $executeStatus = $stmt->execute();
            }
        } catch (PDOException $e) {
            die("Erro ao excluir estudante: " . $e->getMessage());
        }
    }

    public function deletarResponsavel($id) {
        try {
            $stmt = $this->connect->prepare("SELECT id_estudante FROM responsaveis WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $estudante = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt = $this->connect->prepare("DELETE FROM responsaveis WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $executeStatus = $stmt->execute();
            if ($executeStatus) {
                $stmt = $this->connect->prepare("SELECT id, matricula, nome, curso, ano_ingresso FROM estudantes WHERE id = :id_estudante");
                $stmt->bindParam(":id_estudante", $estudante['id_estudante']);
                $executeStatus = $stmt->execute();
                if ($executeStatus) {
                    $estudante = $stmt->fetch(PDO::FETCH_ASSOC);
                    $matricula = $estudante['matricula'];
                    $nome = $estudante['nome'];
                    $curso = $estudante['curso'];
                    $ano_ingresso = $estudante['ano_ingresso'];
                    $id = $estudante['id'];
                    header("Location:router.php?rota=detalhesEstudante&matricula=$matricula&nome=$nome&curso=$curso&anoIngresso=$ano_ingresso&id=$id");
                }
            }
        } catch (PDOException $e) {
            die("Erro ao excluir responsavel: " . $e->getMessage());
        }
    }
    
}

?>