<?php

namespace Repositories;

use Lib\DataBase;
use Models\Category;
use PDO;
use PDOException;


class CategoryRepository{

    private DataBase $db;

    public function __construct(){
        $this->db = new DataBase();
    }


    public function registerCategory(Category $category):bool{
        try{
            $insert = $this->db->prepare("INSERT INTO categorias (nombre) VALUES (:name)"); 
            $insert->bindValue(":name", $category->getName(), PDO::PARAM_STR);
            $insert->execute();
            return true;
        }catch(PDOException $e){
            error_log("Error al crear el usuario: ".$e->getMessage());
            return false;
        }finally{
            if(isset($insert)){
                $insert->closeCursor();
            }
        }
    }

    public function getAllCategories(): array {
        try {
            // Preparar y ejecutar la consulta
            $query = $this->db->prepare("SELECT id, nombre FROM categorias");
            $query->execute();
    
            $rows = $query->fetchAll(PDO::FETCH_ASSOC);

            // Filtrar categorías vacías o sin nombre
            $filteredRows = array_filter($rows, function($row) {
                return !empty($row['nombre']);
            });
    
            return array_map(function($row) {
                return Category::fromArray($row);
            }, $filteredRows);
        } catch (PDOException $e) {
            error_log("Error al obtener categorías: " . $e->getMessage());
            return []; 
        } finally {
            if (isset($query)) {
                $query->closeCursor(); 
            }
        }
    }
    
    
}
