<?php

namespace pdo;
class Funcionario 
{
    private $db;
    private $id;
    private $chapa;
    private $nome;
    private $cargo;
    private $setor;
    private $salario;
    
    function __construct(\PDO $db) 
    {
        $this->db = $db;
    }
    
    function listar()
    {
        $query = "SELECT * FROM funcionarios ORDER BY id DESC";
        
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(\PDO::FETCH_BOTH);
    }
    
    function inserir($chapa, $nome, $cargo, $setor, $salario)
    {
        $query = "INSERT INTO funcionarios "
                . "(chapa, nome, cargo, setor, salario) "
                    . "VALUES (:chapa, :nome, :cargo, :setor, :salario)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":chapa", $chapa);
        $stmt->bindValue(":nome", $nome);
        $stmt->bindValue(":cargo", $cargo);
        $stmt->bindValue(":setor", $setor);
        $stmt->bindValue(":salario", $salario);
        
        if($stmt->execute())
        {
            return true;
        }
        else
        {
            return false;
        } 
    }
    
    function atualizar($id, $chapa, $nome, $cargo, $setor, $salario)
    {
        $query = "UPDATE funcionarios SET chapa = :chapa, "
                . "nome = :nome, cargo = :cargo, setor = :setor, salario = :salario "
                . "WHERE id = :id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->bindValue(":chapa", $chapa);
        $stmt->bindValue(":nome", $nome);
        $stmt->bindValue(":cargo", $cargo);
        $stmt->bindValue(":setor", $setor);
        $stmt->bindValue(":salario", $salario);
        
        if($stmt->execute())
        {
            return true;
        }
        else
        {
            return false;
        } 
    }
    
    function deletar($id)
    {
        $query = "DELETE FROM funcionarios WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        
        if($stmt->execute())
        {
            return true;
        }
        else
        {
            return false;
        } 
    }
}
