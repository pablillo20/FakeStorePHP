<?php



namespace Controllers;

use Lib\Pages;
use Models\User;
use Services\UserService;
use Exception;


class AuthController
{
    private Pages $pages;
    private UserService $userService;

    public function __construct()
    {
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
                    try {
                        $this->userService->registerUser($user);
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
}