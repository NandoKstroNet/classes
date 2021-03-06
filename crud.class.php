<?php

class Model
{
    protected $db;
    
    public function __construct() 
    {
        $this->db = new mysqli('localhost', 'root', 'php123', 'atemde');
    }
    
    
    public function insert($tabela, Array $dados) 
    {        
        foreach ($dados as $inds => $vals)
        {
            $campos[] = $inds;
            $valores[] = $vals;
        }

        $campos = implode(', ', $campos);
        $valores = "'".implode("','", $valores)."'";
        $query = $this->db->prepare("INSERT INTO `{$tabela}` ({$campos}) VALUES ({$valores})");
        return $query->execute();
    }
    
    public function read($tabela, $where = NULL, Array $dados, $order = NULL) 
    {        
        $where = ($where != NULL ? "WHERE {$where}" : "");
        $order = ($order != NULL ? "{$order}" : "");
        
        if(empty($dados))
        { 
            $campos = "*";
        }
        else
        {
            $campos = implode(', ', array_values($dados));
        }
        
        $result = '$'.implode(', $', array_values($dados));
            
        return $this->db->query("SELECT {$campos}  FROM `{$tabela}` {$where} {$order}");                
    }
    
    public function update($tabela, Array $dados, $where) 
    {
        
        foreach ($dados as $ind => $val)
        {
            $campos[] = "{$ind} = '{$val}'";
        }
        
        $campos = implode(', ', $campos);
        
        return $this->db->query("UPDATE `{$tabela}` SET {$campos} WHERE {$where}");
    }
    
    public function delete($tabela, $where) 
    {        
        $this->db->query("DELETE FROM `{$tabela}` WHERE {$where}");  
    }

}
