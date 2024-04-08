<?php
require_once __DIR__ . "/../vendor/autoload.php";

use Rob\Aluraplay\Model\User;
use Rob\Aluraplay\Repositories\UserRepository;

$email = isset ($argv[1]) ? $argv[1] : null;
$password = isset ($argv[2]) ? $argv[2] : null;

if (!$email || !$password) {
    echo "Você precisa fornecer email e senha para criar um(a) usuário(a)" . PHP_EOL;
    exit();
}

try {
    $user = new User(
        id: null,
        email: $email,
        password: $password
    );

    $userRepository = new UserRepository();

    if (!$userRepository->save($user)) {
        echo "Erro ao tentar adicionar usuário(a)" . PHP_EOL;
    }

} catch (InvalidArgumentException $ex) {
    echo "Argumento inválido: " . $ex->getMessage() . PHP_EOL;
} catch (PDOException $ex) {
    echo "Erro na conexão com o banco de dados: " . $ex->getMessage() . PHP_EOL;
} catch (Exception $ex) {
    echo $ex->getMessage() . PHP_EOL;
}
