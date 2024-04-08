<?php
require_once __DIR__ . "/../vendor/autoload.php";

use Rob\Aluraplay\Repositories\UserRepository;

$id = isset ($argv[1]) ? $argv[1] : null;

if (!$id) {
    echo "Você precisa fornecer um id para deletar um(a) usuário(a)" . PHP_EOL;
    exit();
}

try {
    $userRepository = new UserRepository();

    if (!$userRepository->delete($id)) {
        echo "Erro ao tentar excluir usuário(a)" . PHP_EOL;
    }
} catch (InvalidArgumentException $ex) {
    echo "Argumento inválido: " . $ex->getMessage() . PHP_EOL;
} catch (PDOException $ex) {
    echo "Erro na conexão com o banco de dados: " . $ex->getMessage() . PHP_EOL;
} catch (Exception $ex) {
    echo $ex->getMessage() . PHP_EOL;
}
