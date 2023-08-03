<?php

require_once 'database.php';

class User {
    private $conn;

    //Constructor
    public function __construct(){
        $database = new Database();
        $db = $database -> dbConnection();
        $this -> conn = $db;
    }

    //Execute queries SQL
    public function runQuery($sql){
        $stmt = $this -> $conn -> prepare($sql);
        return $stmt;
    }

    //Insert
    public function insert($codigo, $nombre, $descripcion, $costo, $existencia, $suplidor){
        try{
            $stmt = $this -> conn -> prepare("INSERT INTO productos (codigo, nombre, descripcion, costo, existencia, suplidor) VALUES (:codigo, :nombre, :descripcion, :costo, :existencia, :suplidor)");
            $stmt -> bindparam(":codigo", $codigo);
            $stmt -> bindparam(":nombre", $nombre);
            $stmt -> bindparam(":descripcion", $descripcion);
            $stmt -> bindparam(":costo", $costo);
            $stmt -> bindparam(":existencia", $existencia);
            $stmt -> bindparam(":suplidor", $suplidor);
            $stmt -> execute();
            return $stmt;

        } catch(PDOException $e){
            echo $e -> getMessage();
        }
    }

    //Update
    public function update($codigo, $nombre, $descripcion, $costo, $existencia, $suplidor){
        try {
            $stmt = $this -> conn -> prepare("UPDATE productos SET nombre = :nombre, descripcion = :descripcion, costo = :costo, existencia = :existencia, suplidor = :suplidor WHERE codigo = :codigo");
            $stmt -> bindparam(":codigo", $codigo);
            $stmt -> bindparam(":nombre", $nombre);
            $stmt -> bindparam(":descripcion", $descripcion);
            $stmt -> bindparam(":costo", $costo);
            $stmt -> bindparam(":existencia", $existencia);
            $stmt -> bindparam(":suplidor", $suplidor);
            $stmt -> execute();
            return $stmt;
    
        } catch(PDOException $e){
            echo $e -> getMessage();
        }
    }

    //Delete
    public function delete($codigo){
        try {
            $stmt = $this -> conn -> prepare("DELETE FROM productos WHERE codigo = :codigo");
            $stmt -> bindparam(":codigo", $codigo);
            $stmt -> execute();
            return $stmt;
        } catch(PDOException $e){
            echo $e -> getMessage();
        }
    }

    //Redirect URL method
    public function redirect($url){
        header("Location: $url");
    }
}
?>