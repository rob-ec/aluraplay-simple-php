<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Rob\Aluraplay\Repositories\UserRepository;
use Rob\Aluraplay\Model\User;

/**
 * @param User[] $users
 */
function usersTable(array $users): void
{
    if (!empty ($users)) {
        echo "ID\tEMAIL" . PHP_EOL;
    }

    foreach ($users as $user) {
        echo "{$user->id()}\t{$user->email()}" . PHP_EOL;
    }
}

$id = isset ($argv[1]) ? $argv[1] : false;

/** @var User[] $users */
$users = [];

try {
    $usersRepository = new UserRepository();
    $users = $id ? [$usersRepository->findById($id)] : $usersRepository->all();

    usersTable($users);
} catch (InvalidArgumentException $ex) {
    echo "Problema ao buscar dados: {$ex->getMessage()} de usuário(a) invalido" . PHP_EOL;
} catch (PDOException $ex) {
    echo "Problema na conexão com o banco de dados: " . $ex->getMessage() . PHP_EOL;
} catch (Exception $ex) {
    echo $ex->getMessage() . PHP_EOL;
}
