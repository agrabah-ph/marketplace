<?php

namespace Tests\Feature;

use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use WithoutMiddleware; // use the trait
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRegister()
    {
        DB::beginTransaction();
        $faker = Factory::create();
        $array = [
            'name' => $faker->name,
            'email' => $faker->email,
            'password' => $password = $faker->password,
            'password_confirmation' => $password,
        ];

        $response = $this->post('register', $array);
        $response->assertStatus(302);
        DB::rollBack();
    }
}
