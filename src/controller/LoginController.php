<?php

namespace Rob\Aluraplay\Controller;

use Exception;
use Rob\Aluraplay\Model\User;
use Rob\Aluraplay\Core\Redirector;
use InvalidArgumentException;

class LoginController extends UserController
{
    public function post(): void
    {
        $message = ['success' => 0];

        $email = $this->request->post('email', FILTER_VALIDATE_EMAIL);
        $password = $this->request->post('password');

        if (!$email) {
            throw new InvalidArgumentException("email");
        }

        $user = $this->repository->findByEmail($email);
        $correctPassword = password_verify($password, $user?->hash() ?? " ");

        if ($user && $correctPassword) {
            if (User::passwordNeedsRehash($password)) {
                $this->repository->rehashPassword($user, $password);
            }

            $_SESSION['loged'] = true;
            $message['success'] = 1;
            Redirector::redirectTo("/", $message);
        }

        Redirector::redirectTo("/login", $message);
    }

    public function processRequest(): void
    {
        if ($this->isLogedUser()) {
            Redirector::redirectTo("/");
        }

        try {
            $this->post();
        } catch (InvalidArgumentException $ex) {
            Redirector::redirectTo("/login", ['invalid' => $ex->getMessage()]);
        } catch (Exception $ex) {
            Redirector::redirectTo("/login", ['error' => $ex->getMessage()]);
        }
    }
}
