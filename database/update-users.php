<?php
require_once __DIR__ . "/../vendor/autoload.php";

use Rob\Aluraplay\Model\User;
use Rob\Aluraplay\Repositories\UserRepository;

$id = isset ($argv[1]) ? $argv[1] : null;
$email = isset ($argv[2]) ? $argv[2] : null;
$password = isset ($argv[3]) ? $argv[3] : null;

if (!$id || !$email || !$password) {
    echo "Você precisa fornecer id, email e senha para atualizar um(a) usuário(a)" . PHP_EOL;
    exit();
}

try {

    $userRepository = new UserRepository();
    $user = new User(
        id: $id,
        email: $email,
        password: $password
    );

    if (!$userRepository->update($user)) {
        echo "Erro ao tentar atualizar usuário(a)" . PHP_EOL;
    }

} catch (InvalidArgumentException $ex) {
    echo "Argumento inválido: " . $ex->getMessage() . PHP_EOL;
} catch (PDOException $ex) {
    echo "Erro na conexão com o banco de dados: " . $ex->getMessage() . PHP_EOL;
} catch (Exception $ex) {
    echo $ex->getMessage() . PHP_EOL;
}
