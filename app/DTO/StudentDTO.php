<?php

namespace App\DTO;


class StudentDTO implements DtoInterface
{
    public function __construct(
        public string $name,
        public string $studentNumber,
        public string $gender,
        public string $birth,
        public int $universityId,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'],
            $data['studentNumber'],
            $data['gender'],
            $data['birth'],
            $data['universityId']
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'student_number' => $this->studentNumber,
            'gender' => $this->gender,
            'birth' => $this->birth,
            'university_id' => $this->universityId
        ];
    }
}