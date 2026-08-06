<?php

it('can register', function () {
    visit('/register')
        ->fill('name', 'John Doe')
        ->fill('email', 'example@email.com')
        ->fill('password', 'password123')
        ->click('Create Account')
        ->assertpathIs('/');

    $this->assertAuthenticated();

    $this->assertDatabaseHas('users', [
        'name' => 'John Doe',
        'email' => 'example@email.com',
    ]);
});

it('request a valid email', function () {
    visit('/register')
        ->fill('name', 'John Doe')
        ->fill('email', 'exampleemail.com')
        ->fill('password', 'password123')
//        ->debug();
        ->click('Create Account')
        ->assertpathIs('/register');
});
