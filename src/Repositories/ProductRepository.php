<?php

namespace Repositories;

use Lib\DataBase;
use Models\Product;
use PDO;
use PDOException;


class ProductRepository{

    private DataBase $db;

    public function __construct(){
        $this->db = new DataBase();
    }


    public function registerProduct(Product $product):bool{
        try{
            $insert = $this->db->prepare("INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, oferta, fecha, imagen) VALUES (:categoria_id, :nombre, :descripcion, :precio, :stock, :oferta, :fecha, :imagen)"); 
            $insert->bindValue(":categoria_id", $product->getCategoriaId(), PDO::PARAM_INT);
            $insert->bindValue(":nombre", $product->getNombre(), PDO::PARAM_STR);
            $insert->bindValue(":descripcion", $product->getDescripcion(), PDO::PARAM_STR);
            $insert->bindValue(":precio", $product->getPrecio(), PDO::PARAM_STR);
            $insert->bindValue(":stock", $product->getStock(), PDO::PARAM_INT);
            $insert->bindValue(":oferta", $product->getOferta(), PDO::PARAM_INT);
            $insert->bindValue(":fecha", $product->getFecha(), PDO::PARAM_STR);
            $insert->bindValue(":imagen", $product->getImagen(), PDO::PARAM_STR);

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

    public function getAllProducts(): array{
        try{
            $query = $this->db->prepare("SELECT * FROM productos");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            error_log("Error al obtener los productos: ".$e->getMessage());
            return [];
        }finally{
            if(isset($query)){
                $query->closeCursor();
            }
        }
    }

    public function getProductById(int $id): Product|bool{
        try{
            $query = $this->db->prepare("SELECT * FROM productos WHERE id = :id");
            $query->bindValue(":id", $id, PDO::PARAM_INT);
            $query->execute();

            $data = $query->fetch(\PDO::FETCH_ASSOC);
            if($data){
                return Product::fromArray($data);
            }

            return false;
        }catch(PDOException $e){
            error_log("Error al obtener el producto: ".$e->getMessage());
            return false;
        }finally{
            if(isset($query)){
                $query->closeCursor();
            }
        }
    }

    public function updateProduct(Product $product): void {
        try {
            $update = $this->db->prepare("UPDATE productos SET categoria_id = :categoria_id, nombre = :nombre, descripcion = :descripcion, precio = :precio, stock = :stock, oferta = :oferta WHERE id = :id");
            $update->bindValue(":categoria_id", $product->getCategoriaId(), PDO::PARAM_INT);
            $update->bindValue(":nombre", $product->getNombre(), PDO::PARAM_STR);
            $update->bindValue(":descripcion", $product->getDescripcion(), PDO::PARAM_STR);
            $update->bindValue(":precio", $product->getPrecio(), PDO::PARAM_STR);
            $update->bindValue(":stock", $product->getStock(), PDO::PARAM_INT);
            $update->bindValue(":oferta", $product->getOferta(), PDO::PARAM_INT);
            $update->bindValue(":id",$product->getId(),PDO::PARAM_INT);

            $update->execute();
        } catch (PDOException $e) {
            error_log("Error al actualizar el producto: " . $e->getMessage());
        } finally {
            if (isset($update)) {
                $update->closeCursor();
            }
        }
    }

    public function getProductsByCategoryId(?int $categoryId = null): array {
        try {
            // Si no se pasa un categoryId, obtener todos los productos
            if ($categoryId === null) {
                $query = $this->db->prepare("SELECT * FROM productos");
            } else {
                // Si se pasa un categoryId, filtrar por categoría
                $query = $this->db->prepare("SELECT * FROM productos WHERE categoria_id = :categoria_id");
                $query->bindValue(":categoria_id", $categoryId, PDO::PARAM_INT);
            }
    
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener los productos por categoría: " . $e->getMessage());
            return [];
        } finally {
            if (isset($query)) {
                $query->closeCursor();
            }
        }
    }

    public function DeleteProduct (int $id):bool{
        try{
            $query = $this->db->prepare("DELETE FROM PRODUCTOS WHERE id = :id");
            $query->bindValue(":id", $id, PDO::PARAM_INT);
            $query->execute();
            return true;
        }catch(PDOException $e){
            error_log("Error al eliminar el producto: ".$e->getMessage());
            return false;
        }finally{
            if(isset($query)){
                $query->closeCursor();
            }
        }
    }
}
