<?php

namespace Controllers;

use Lib\Pages;
use Models\User;
use Services\UserService;
use Exception;
use Lib\Security;
use Lib\Email;



namespace Controllers;

use Lib\Pages;
use Models\User;
use Services\UserService;
use Exception;
use Lib\Security;
use Lib\PhpMail;

class AuthController
{
    private Pages $pages;
    private UserService $userService;
    private PhpMail $email;

    public function __construct()
    {
        $this->email = new PhpMail();
        $this->pages = new Pages();
        $this->userService = new UserService();
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['data'])) {
                $user = User::fromArray($_POST['data']);

                $user->sanitize();
                try {
                    if ($user->validationLogin()) {

                        $usuario = $this->userService->login($_POST['data']['email']);
                    } else {
                        $errors = User::getErrores();
                        $this->pages->render('Auth/loginForm', ['errors' => $errors]);
                        return;
                    }
                    if ($usuario->getConfirmado() == 1) {


                        if ($usuario && password_verify($_POST['data']['password'], $usuario->getPassword())) {
                            $_SESSION['user']['username'] = $usuario->getName();
                            $_SESSION['user']['email'] = $usuario->getEmail();
                            $_SESSION['user']['id'] = $usuario->getId();
                            $_SESSION['login'] = 'Success';

                            if ($usuario->getRol() === 'admin') {
                                $_SESSION['admin'] = 1;
                            }
                            $this->pages->render('Layout/principal');
                        } else {
                            $_SESSION['login'] = 'Fail';
                            $this->pages->render('Auth/loginForm');
                        }
                    }else{
                        $_SESSION['confirmacion'] = false;
                        $this->pages->render('Auth/loginForm');
                    }
                } catch (Exception $e) {
                    $_SESSION['login'] = 'Fail';
                    $_SESSION['errors'] = $e->getMessage();
                    $this->pages->render('Auth/loginForm');
                }
            } else {
                $this->pages->render('Auth/loginForm');
            }
        } else {
            $this->pages->render('Auth/loginForm');
        }
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['data'])) {
                $user = User::fromArray($_POST['data']);
                $user->sanitize();
                if ($user->validation()) {
                    $password = password_hash($user->getPassword(), PASSWORD_BCRYPT, ['cost' => 5]);
                    $user->setPassword($password);

                    $token = Security::crearToken(Security::secretKey(), [$user->getEmail()]);
                    $user->setToken($token);

                    try {
                        $this->userService->registerUser($user);

                        $this->email->enviarToken($user->getEmail(), $user->getName(), $token);

                        $this->pages->render('Auth/loginForm');
                    } catch (Exception $e) {
                        $_SESSION['register'] = 'Fail';
                        $_SESSION['errors'] = $e->getMessage();
                    }
                } else {
                    $_SESSION['register'] = 'Fail';
                    $errors = User::getErrores();
                    $this->pages->render('Auth/registerForm', ['errors' => $errors]);
                }
            } else {
                $_SESSION['register'] = 'Fail'; // Si no hay datos
            }
        } else {
            $this->pages->render('Auth/registerForm');
        }
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();
        $this->pages->render('Auth/loginForm');
        exit();
    }

    public function confirmarCuenta($token)
    {
        if (isset($token)) {
            try {
                if (Security::validateToken($token)) {
                    $_SESSION['mensaje'] = 'Cuenta confirmada con éxito';
                    header('Location: ' . BASE_URL . 'login');
                } else {
                    $_SESSION['mensaje'] = 'Token inválido o expirado';
                    header('Location: ' . BASE_URL . 'register');
                }
            } catch (Exception $e) {
                $_SESSION['mensaje'] = 'Error al confirmar la cuenta';
                echo $e->getMessage();
            }
        } else {
            $_SESSION['mensaje'] = 'Token no proporcionado';
            header('Location: ' . BASE_URL . 'register');
        }
    }
}
