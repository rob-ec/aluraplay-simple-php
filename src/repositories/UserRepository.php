<?php

namespace Rob\Aluraplay\Repositories;

use Rob\Aluraplay\Core\ConnectionCreator;
use Rob\Aluraplay\Model\User;

use PDO;
use PDOStatement;
use PDOException;
use InvalidArgumentException;

class UserRepository
{
    private PDO $connection;
    private string $table = "users";

    public function __construct(PDO $connection = null)
    {
        $this->connection = $connection ?? ConnectionCreator::create();
    }

    /** 
     * @throws InvalidArgumentException 
     */
    private function hidratate(array $userData): ?User
    {
        if (empty($userData)) {
            return null;
        }

        return new User(
            id: $userData['id'],
            email: $userData['email'],
            password: $userData['password'],
            alreadyHashed: true
        );
    }

    /** 
     * @throws InvalidArgumentException 
     */
    private function hidratateRows(PDOStatement $stmt): array
    {
        $users = [];
        $rows = $stmt->fetchAll();

        foreach ($rows as $userData) {
            $users[] = $this->hidratate($userData);
        }

        return $users;
    }

    /**
     * @throws PDOException
     */
    public function all(): array
    {
        $querySelectAll = "SELECT * FROM {$this->table}";

        $stmt = $this->connection->prepare($querySelectAll);
        $stmt->execute();

        return $this->hidratateRows($stmt);
    }

    /**
     * @throws PDOException
     */
    public function findById(int $id): ?User
    {
        $querySelectByID = "SELECT * FROM {$this->table} WHERE id = :id";

        $stmt = $this->connection->prepare($querySelectByID);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        $success = $stmt->execute();

        if ($success) {
            $userData = $stmt->fetch();
            return $this->hidratate($userData);
        }

        return null;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function findByEmail(string $email): ?User
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("email");
        }

        $querySelectByEmail = "SELECT * FROM {$this->table} WHERE email = :email";

        $stmt = $this->connection->prepare($querySelectByEmail);
        $stmt->bindValue(":email", $email);
        $success = $stmt->execute();

        if ($success) {
            return $this->hidratate($stmt->fetch());
        }

        return null;
    }

    /**
     * @throws PDOException
     */
    public function save(User $user): bool
    {
        $queryInsertUser = "INSERT INTO {$this->table} (email, password) VALUES (:email, :password)";

        $stmt = $this->connection->prepare($queryInsertUser);
        $stmt->bindValue(":email", $user->email());
        $stmt->bindValue(":password", $user->hash());

        $success = $stmt->execute();

        if ($success) {
            $user->defineId($this->connection->lastInsertId());
        }

        return $success;
    }

    /**
     * @throws PDOException
     */
    public function update(User $user): bool
    {
        $queryUpdateUser = "UPDATE {$this->table} SET email = :email, password = :password WHERE id = :id";

        $stmt = $this->connection->prepare($queryUpdateUser);
        $stmt->bindValue(":id", $user->id(), PDO::PARAM_INT);
        $stmt->bindValue(":email", $user->email());
        $stmt->bindValue(":password", $user->hash());

        $success = $stmt->execute();

        return $success;
    }

    /**
     * @throws PDOException
     */
    public function delete(int $id): bool
    {
        $queryDeleteUser = "DELETE FROM {$this->table} WHERE id = :id";

        $stmt = $this->connection->prepare($queryDeleteUser);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        $success = $stmt->execute();

        return $success;
    }

    /**
     * @throws PDOException
     */
    public function rehashPassword(User $user, string $password): bool
    {
        $user->defineHash(User::rehash($password), true);
        return $this->update($user);
    }
}
