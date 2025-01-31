<?php

namespace Repositories;

use Lib\DataBase;
use Models\User;
use PDO;
use PDOException;


class UserRepository{

    private DataBase $db;

    public function __construct(){
        $this->db = new DataBase();
    }

    public function registerUser(User $user): bool {
        try {
            $insert = $this->db->prepare("INSERT INTO usuarios (nombre, apellidos, email, password, rol, confirmado, token, token_exp) 
            VALUES(:name, :lastName, :email, :password, :role, :confirmed, :token, :token_exp)");
            $insert->bindValue(":name", $user->getName(), PDO::PARAM_STR);
            $insert->bindValue(":lastName", $user->getLastName(), PDO::PARAM_STR);
            $insert->bindValue(":email", $user->getEmail(), PDO::PARAM_STR);
            $insert->bindValue(":password", $user->getPassword(), PDO::PARAM_STR);
            $insert->bindValue(":role", $user->getRol(), PDO::PARAM_STR);
            $insert->bindValue(":confirmed", $user->getConfirmado(), PDO::PARAM_BOOL);
            $insert->bindValue(":token", $user->getToken(), PDO::PARAM_STR);
            $insert->bindValue(":token_exp", $user->getTokenExp(), PDO::PARAM_STR);

            $insert->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Error al crear el usuario: " . $e->getMessage());
            return false;
        } finally {
            if (isset($insert)) {
                $insert->closeCursor();
            }
        }
    }

    public function comprobarCorreo(string $email):User |bool{
        try{
            $select = $this->db->prepare("SELECT * FROM usuarios WHERE email = :email");
            $select->bindValue(":email", $email, PDO::PARAM_STR);
            $select->execute();
            $result = $select->fetch(PDO::FETCH_ASSOC);
            if($result){
                return User::fromArray($result);
            }else{
                return false;
            }

        }catch(PDOException $e){
            error_log("Error al comprobar el correo: ".$e->getMessage());
            return false;
        }finally{
            if(isset($select)){
                $select->closeCursor();
            }
        }
    }

    // Confirmar un usuario por su correo
    public function actualizar(string $email): bool {
        try {
            $update = $this->db->prepare("UPDATE usuarios SET confirmado = 1 WHERE email = :email");
            $update->bindValue(":email", $email, PDO::PARAM_STR);
            $update->execute();

            return $update->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error al confirmar el usuario: " . $e->getMessage());
            return false;
        } finally {
            if (isset($update)) {
                $update->closeCursor();
            }
        }
    }
       
}
?>