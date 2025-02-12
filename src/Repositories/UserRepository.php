<?php

namespace Repositories;

use Lib\DataBase;
use Models\User;
use PDO;
use PDOException;

class UserRepository
{
    private DataBase $db;

    public function __construct()
    {
        $this->db = new DataBase();
    }

    public function registerUser(User $user): bool {
        try {
            $insert = $this->db->prepare("INSERT INTO usuarios (nombre, apellidos, email, password, rol, confirmado, token, token_exp, token_recuperacion) 
            VALUES(:name, :lastName, :email, :password, :role, :confirmed, :token, :token_exp, :token_recuperacion)");
            $insert->bindValue(":name", $user->getName(), PDO::PARAM_STR);
            $insert->bindValue(":lastName", $user->getLastName(), PDO::PARAM_STR);
            $insert->bindValue(":email", $user->getEmail(), PDO::PARAM_STR);
            $insert->bindValue(":password", $user->getPassword(), PDO::PARAM_STR);
            $insert->bindValue(":role", $user->getRol(), PDO::PARAM_STR);
            $insert->bindValue(":confirmed", $user->getConfirmado(), PDO::PARAM_BOOL);
            $insert->bindValue(":token", $user->getToken(), PDO::PARAM_STR);
            $insert->bindValue(":token_exp", $user->getTokenExp(), PDO::PARAM_STR);
            $insert->bindValue(":token_recuperacion", $user->getTokenRecuperacion(), PDO::PARAM_STR);

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

    public function getUserByEmail(string $email): ?User {
        try {
            $select = $this->db->prepare("SELECT * FROM usuarios WHERE email = :email");
            $select->bindValue(":email", $email, PDO::PARAM_STR);
            $select->execute();
            $result = $select->fetch(PDO::FETCH_ASSOC);
            return $result ? User::fromArray($result) : null;
        } catch (PDOException $e) {
            error_log("Error al obtener el usuario por email: " . $e->getMessage());
            return null;
        } finally {
            if (isset($select)) {
                $select->closeCursor();
            }
        }
    }

    public function updateUser(User $user): bool {
        try {
            $update = $this->db->prepare("UPDATE usuarios SET nombre = :name, apellidos = :lastName, email = :email, password = :password, rol = :role, confirmado = :confirmed, token = :token, token_recuperacion = :token_recuperacion, token_exp = :token_exp WHERE id = :id");
            $update->bindValue(":name", $user->getName(), PDO::PARAM_STR);
            $update->bindValue(":lastName", $user->getLastName(), PDO::PARAM_STR);
            $update->bindValue(":email", $user->getEmail(), PDO::PARAM_STR);
            $update->bindValue(":password", $user->getPassword(), PDO::PARAM_STR);
            $update->bindValue(":role", $user->getRol(), PDO::PARAM_STR);
            $update->bindValue(":confirmed", $user->getConfirmado(), PDO::PARAM_BOOL);
            $update->bindValue(":token", $user->getToken(), PDO::PARAM_STR);
            $update->bindValue(":token_recuperacion", $user->getTokenRecuperacion(), PDO::PARAM_STR);
            $update->bindValue(":token_exp", $user->getTokenExp(), PDO::PARAM_STR);
            $update->bindValue(":id", $user->getId(), PDO::PARAM_INT);
            $update->execute();
            return $update->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error al actualizar el usuario: " . $e->getMessage());
            return false;
        } finally {
            if (isset($update)) {
                $update->closeCursor();
            }
        }
    }

    public function getUserByTokenRecuperacion(string $token): ?User
    {
        try {
            $select = $this->db->prepare("SELECT * FROM usuarios WHERE token_recuperacion = :token");
            $select->bindValue(":token", $token, PDO::PARAM_STR);
            $select->execute();
            $result = $select->fetch(PDO::FETCH_ASSOC);
            return $result ? User::fromArray($result) : null;
        } catch (PDOException $e) {
            error_log("Error al obtener el usuario por token de recuperación: " . $e->getMessage());
            return null;
        } finally {
            if (isset($select)) {
                $select->closeCursor();
            }
        }
    }

    public function setTokenRecuperacion(User $user, string $token): bool {
        try {
            $update = $this->db->prepare("UPDATE usuarios SET token_recuperacion = :token WHERE email = :email");
            $update->bindValue(":token", $token, PDO::PARAM_STR);
            $update->bindValue(":email", $user->getEmail(), PDO::PARAM_STR);
            $update->execute();
            return $update->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error al actualizar el token de recuperación: " . $e->getMessage());
            return false;
        } finally {
            if (isset($update)) {
                $update->closeCursor();
            }
        }
    }

    public function updateTokenRecuperacion(User $user, string $token): bool {
        try {
            $update = $this->db->prepare("UPDATE usuarios SET token_recuperacion = :token WHERE email = :email");
            $update->bindValue(":token", $token, PDO::PARAM_STR);
            $update->bindValue(":email", $user->getEmail(), PDO::PARAM_STR);
            $update->execute();
            return $update->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error al actualizar el token de recuperación: " . $e->getMessage());
            return false;
        } finally {
            if (isset($update)) {
                $update->closeCursor();
            }
        }
    }

    public function getTokenByUniqueId(string $uniqueId): ?string {
        try {
            $select = $this->db->prepare("SELECT token FROM tokens WHERE unique_id = :uniqueId");
            $select->bindValue(":uniqueId", $uniqueId, PDO::PARAM_STR);
            $select->execute();
            $result = $select->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['token'] : null;
        } catch (PDOException $e) {
            error_log("Error al obtener el token por identificador único: " . $e->getMessage());
            return null;
        } finally {
            if (isset($select)) {
                $select->closeCursor();
            }
        }
    }

    public function saveToken(string $uniqueId, string $token): bool {
        try {
            $insert = $this->db->prepare("INSERT INTO tokens (unique_id, token) VALUES (:uniqueId, :token)");
            $insert->bindValue(":uniqueId", $uniqueId, PDO::PARAM_STR);
            $insert->bindValue(":token", $token, PDO::PARAM_STR);
            $insert->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Error al guardar el token: " . $e->getMessage());
            return false;
        } finally {
            if (isset($insert)) {
                $insert->closeCursor();
            }
        }
    }

    public function getUserByToken(string $token): ?User {
        try {
            $select = $this->db->prepare("SELECT * FROM usuarios WHERE token = :token");
            $select->bindValue(":token", $token, PDO::PARAM_STR);
            $select->execute();
            $result = $select->fetch(PDO::FETCH_ASSOC);
            return $result ? User::fromArray($result) : null;
        } catch (PDOException $e) {
            error_log("Error al obtener el usuario por token: " . $e->getMessage());
            return null;
        } finally {
            if (isset($select)) {
                $select->closeCursor();
            }
        }
    }
}
?>