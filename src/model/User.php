<?php

namespace Rob\Aluraplay\Model;

use InvalidArgumentException;

class User
{
    private ?int $id;
    private string $email;
    private string $hash;

    private static string $hashAlg = PASSWORD_ARGON2ID;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(?int $id, string $email, string $password, bool $alreadyHashed = false)
    {
        $this
            ->defineId($id)
            ->defineEmail($email)
            ->defineHash($password, $alreadyHashed);
    }

    public function id(): int
    {
        return $this->id;
    }

    public function defineId(?int $id): User
    {
        $this->id = $id;
        return $this;
    }

    public function email(): string
    {
        return $this->email;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function defineEmail(string $email): User
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("email");
        }
        $this->email = $email;
        return $this;
    }

    public function hash(): string
    {
        return $this->hash;
    }

    public function definePassword(string $password): User
    {
        return $this->defineHash($password);
    }

    public function defineHash(string $password, bool $alreadyHashed = false): User
    {
        if ($alreadyHashed) {
            $this->hash = $password;
            return $this;
        }

        $this->hash = password_hash($password, self::$hashAlg);
        return $this;
    }

    public function verifyPassword(string $password): bool
    {
        if (!password_verify($password, $this->hash)) {
            return false;
        }

        if (password_needs_rehash($password, self::$hashAlg)) {
            // update hash
        }

        return true;
    }

    public static function passwordNeedsRehash(string $password): bool
    {
        return password_needs_rehash($password, self::$hashAlg);
    }

    public static function rehash(string $password): string
    {
        $newHash = password_hash($password, self::$hashAlg);
        return $newHash;
    }
}
