<?php
namespace Services;

use Repositories\UserRepository;
use Models\User;

class UserService {

    private UserRepository $userRepository;

    public function __construct() {
        // Inicializa el repositorio de usuarios
        $this->userRepository = new UserRepository();
    }

    // Registra un nuevo usuario
    public function registerUser(User $user): bool {
        return $this->userRepository->registerUser($user);
    }

    // Inicia sesión con el correo electrónico
    public function login(String $email) {
        return $this->userRepository->comprobarCorreo($email);
    }

    // Actualiza la información del usuario
    public function actualizar(String $email) {
        return $this->userRepository->actualizar($email);
    }

    // Obtiene un usuario por su correo electrónico
    public function getUserByEmail(string $email): ?User {
        return $this->userRepository->getUserByEmail($email);
    }

    // Actualiza la información de un usuario
    public function updateUser(User $user): bool {
        return $this->userRepository->updateUser($user);
    }

    // Obtiene un usuario por su token de recuperación
    public function getUserByTokenRecuperacion(string $token): ?User {
        return $this->userRepository->getUserByTokenRecuperacion($token);
    }

    // Establece un token de recuperación para un usuario
    public function setTokenRecuperacion(User $user, string $token): bool {
        return $this->userRepository->setTokenRecuperacion($user, $token);
    }

    // Actualiza el token de recuperación de un usuario
    public function updateTokenRecuperacion(User $user, string $token): bool {
        return $this->userRepository->updateTokenRecuperacion($user, $token);
    }

    // Obtiene un token usando un identificador único
    public function getTokenByUniqueId(string $uniqueId): ?string {
        return $this->userRepository->getTokenByUniqueId($uniqueId);
    }

    // Guarda un token usando un identificador único
    public function saveToken(string $uniqueId, string $token): bool {
        return $this->userRepository->saveToken($uniqueId, $token);
    }

    // Obtiene un usuario por su token
    public function getUserByToken(string $token): ?User {
        return $this->userRepository->getUserByToken($token);
    }
}
?>