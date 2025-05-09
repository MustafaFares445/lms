<?php

namespace Tests\Traits;

trait ApiTestTrait
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ]);
    }
}