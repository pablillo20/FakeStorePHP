<?php
namespace Services;
use Repositories\UserRepository;
use Models\User;

class UserService{

    private UserRepository $userRepository;
    
    public function __construct(){
        $this->userRepository = new UserRepository();
    }

    public function registerUser(User $user): bool {
        return $this->userRepository->registerUser($user);
    }

    public function login(String $email){
        return $this->userRepository->comprobarCorreo($email);
    }
    
}
?>