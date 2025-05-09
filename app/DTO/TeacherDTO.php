<?php

namespace App\DTO;


class TeacherDTO implements DtoInterface
{
    public function __construct(
        public string $name,
        public string $summary,
        public string $phone,
        public string $whatsappPhone,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'],
            $data['summary'],
            $data['phone'],
            $data['whatsappPhone']
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'phone' => $this->phone,
            'whatsapp_phone' => $this->whatsappPhone,
            'summary' => $this->summary,
        ];
    }
}
