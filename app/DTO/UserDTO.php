<?php

namespace App\DTO;


class UserDTO implements DtoInterface
{
    public function __construct(
        public string $name,
        public string $username,
        public ?string $email,
        public ?string $phone,
        public ?string $password,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'],
            $data['username'],
            $data['email'] ?? null,
            $data['phone'] ?? null,
            $data['password'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => $this->password
        ];
    }
}