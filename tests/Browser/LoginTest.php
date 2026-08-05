<?php

use App\Models\User;

it('can login', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password123')
    ]);
    visit('/login')
        ->fill('email', $user->email)
        ->fill('password', 'password123')
        ->click('@login')
        ->assertpathIs('/');

    $this->assertAuthenticated();
});

it('logs out user', function () {
//    create the user
    $user = User::factory()->create();

//    login the user
    //    Auth::login($user);
    $this->actingAs($user);

//    click the logout button
    visit('/')->click('@logout');

//    expect the current state to be Guest
    $this->assertGuest();
});
