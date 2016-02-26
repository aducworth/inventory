<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class InventoryTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testAuth()
    {
        $this->visit('/')->seePageIs('/auth/login');
    }
}
