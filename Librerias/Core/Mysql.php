<?php

class Mysql extends Conexion{

    private $conexion;
    private $stringquery;
   // private $arrayValues;

    function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->conect();
    }

    //insertar un registro 
    public function insert(string $query, array $array)
    {
        
        //Se puede refactorizar este codigo sin problema yeahhh
        $insert = $this->conexion->prepare($query);
        $respuestaInsert = $insert->execute($array);       
        if($respuestaInsert){
            return $this->conexion->lastInsertId();
        }

    }

    //Consulta de 1 solo registro especifico 
    public function select(string $query){
        $this->stringquery = $query;
        $result = $this->conexion->prepare($this->stringquery);
        $result->execute();
        $data = $result->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    //Consulta de todos los registros
    public function select_all(string $query){
        $this->stringquery = $query;
        $result = $this->conexion->prepare($this->stringquery);
        $result->execute();
        $data = $result->fetchall(PDO::FETCH_ASSOC);
        return $data;
    }

    //Actualizar registro
    public function update(string $query, array $arrayValues)
    {
        $this->stringquery = $query;
        $this->arrayValues = $arrayValues;
        $update = $this->conexion->prepare($this->stringquery);
        $respuestaExecute = $update->execute($this->arrayValues);       
        if($respuestaExecute){
            $lastInsert = $this->conexion->lastInsertId();
        }
        return $respuestaExecute;
    }

    //Eliminar registro 
    public function delete(string $query)
    {
        $this->stringquery = $query;
        $result = $this->conexion->prepare($this->stringquery);
        $respuestaExcute = $result->execute();
        return $respuestaExcute;
    }
}

?>