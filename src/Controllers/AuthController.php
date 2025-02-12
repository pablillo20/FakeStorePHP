<?php

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
    private CartController $cartCartController;

    public function __construct()
    {
        $this->email = new PhpMail();
        $this->pages = new Pages();
        $this->userService = new UserService();
        $this->cartCartController = new CartController();
    }

    public function login()
    {
        // Verifica si la solicitud es POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verifica si los datos están presentes
            if (isset($_POST['data'])) {
                $user = User::fromArray($_POST['data']);

                $user->sanitize();
                try {
                    // Valida los datos del usuario
                    if ($user->validationLogin()) {

                        $usuario = $this->userService->login($_POST['data']['email']);
                    } else {
                        $errors = User::getErrores();
                        $this->pages->render('Auth/loginForm', ['errors' => $errors]);
                        return;
                    }
                    // Verifica si el usuario existe y está confirmado
                    if ($usuario) {
                        if ($usuario->getConfirmado() == 1) {
                            // Verifica la contraseña
                            if ($usuario && password_verify($_POST['data']['password'], $usuario->getPassword())) {
                                $_SESSION['user']['username'] = $usuario->getName();
                                $_SESSION['user']['email'] = $usuario->getEmail();
                                $_SESSION['user']['id'] = $usuario->getId();
                                $_SESSION['login'] = 'Success';

                                if ($usuario->getRol() === 'admin') {
                                    $_SESSION['admin'] = 1;
                                }
                                $userId = $_SESSION['user']['id'];
                                $this->cartCartController->addSessionCart($userId);
                                $this->pages->render('Layout/principal');
                            } else {
                                $_SESSION['login'] = 'Fail';
                                $this->pages->render('Auth/loginForm');
                            }
                        } else {
                            $_SESSION['confirmacion'] = false;
                            $this->pages->render('Auth/loginForm');
                        }
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
        // Verifica si la solicitud es POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verifica si los datos están presentes
            if (isset($_POST['data'])) {
                $user = User::fromArray($_POST['data']);
                $user->sanitize();
                // Valida los datos del usuario
                if ($user->validation()) {
                    $password = password_hash($user->getPassword(), PASSWORD_BCRYPT, ['cost' => 5]);
                    $user->setPassword($password);

                    $token = Security::crearToken(Security::secretKey(), [$user->getEmail()]);
                    $user->setToken($token);

                    $tokenExp = date('Y-m-d H:i:s', strtotime('+1 hour'));
                    $user->setTokenExp($tokenExp);

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
        // Cierra la sesión del usuario
        session_unset();
        session_destroy();
        $this->pages->render('Auth/loginForm');
        exit();
    }

    public function confirmarCuenta($uniqueId)
    {
        // Verifica si el identificador único está presente
        if (isset($uniqueId)) {
            try {
                // Buscar el token usando el identificador único
                $token = $this->userService->getTokenByUniqueId($uniqueId);

                if ($token && Security::validateToken($token)) {
                    // Obtener el usuario por el token
                    $usuario = $this->userService->getUserByToken($token);
                    if ($usuario) {
                        // Confirmar la cuenta del usuario
                        $usuario->setConfirmado(true);
                        $this->userService->updateUser($usuario);

                        $_SESSION['mensaje'] = 'Cuenta confirmada con éxito';
                        header('Location: ' . BASE_URL . 'login');
                    } else {
                        $_SESSION['mensaje'] = 'Usuario no encontrado';
                        header('Location: ' . BASE_URL . 'register');
                    }
                } else {
                    $_SESSION['mensaje'] = 'Token inválido o expirado';
                    header('Location: ' . BASE_URL . 'register');
                }
            } catch (Exception $e) {
                $_SESSION['mensaje'] = 'Error al confirmar la cuenta';
                echo $e->getMessage();
            }
        } else {
            $_SESSION['mensaje'] = 'Identificador único no proporcionado';
            header('Location: ' . BASE_URL . 'register');
        }
    }

    public function requestPasswordReset()
    {
        // Verifica si la solicitud es POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verifica si el correo electrónico está presente
            if (isset($_POST['data']['email'])) {
                $email = $_POST['data']['email'];
                $usuario = $this->userService->getUserByEmail($email);

                if ($usuario) {
                    $token = Security::crearTokenRecuperacion(Security::secretKey(), [$email]);
                    $this->userService->updateTokenRecuperacion($usuario, $token);

                    $this->email->enviarTokenRecuperacion($email, $usuario->getName(), $token);
                    $_SESSION['password_reset'] = 'Success';
                } else {
                    $_SESSION['password_reset'] = 'Fail';
                }
            } else {
                $_SESSION['password_reset'] = 'Fail';
            }
        }
        $this->pages->render('Auth/loginForm');
    }

    public function resetPassword($uniqueId)
    {
        // Verifica si la solicitud es POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verifica si la nueva contraseña está presente
            if (isset($_POST['data']['password'])) {
                try {
                    // Buscar el token usando el identificador único
                    $token = $this->userService->getTokenByUniqueId($uniqueId);

                    if ($token && Security::validateTokenRecuperacion($token)) {
                        $usuario = $this->userService->getUserByTokenRecuperacion($token);
                        if ($usuario) {
                            // Actualizar la contraseña del usuario
                            $newPassword = password_hash($_POST['data']['password'], PASSWORD_BCRYPT, ['cost' => 5]);
                            $usuario->setPassword($newPassword);
                            $usuario->setTokenRecuperacion(null);
                            $this->userService->updateUser($usuario);

                            $_SESSION['password_reset'] = 'Success';
                            $this->pages->render('Auth/loginForm');
                        } else {
                            $_SESSION['password_reset'] = 'Fail';
                            $this->pages->render('Auth/resetPasswordForm', ['uniqueId' => $uniqueId, 'errors' => ['Usuario no encontrado']]);
                        }
                    } else {
                        $_SESSION['password_reset'] = 'Fail';
                        $this->pages->render('Auth/resetPasswordForm', ['uniqueId' => $uniqueId, 'errors' => ['Token inválido o expirado']]);
                    }
                } catch (Exception $e) {
                    $_SESSION['password_reset'] = 'Fail';
                    $this->pages->render('Auth/resetPasswordForm', ['uniqueId' => $uniqueId, 'errors' => [$e->getMessage()]]);
                }
            } else {
                $_SESSION['password_reset'] = 'Fail';
                $this->pages->render('Auth/resetPasswordForm', ['uniqueId' => $uniqueId, 'errors' => ['La contraseña es requerida']]);
            }
        } else {
            $this->pages->render('Auth/resetPasswordForm', ['uniqueId' => $uniqueId]);
        }
    }
}
