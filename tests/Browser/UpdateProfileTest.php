<?php

use App\Models\User;
use App\Notifications\EmailChanged;

it('should be authenticated to update', function () {
    $this->get(route('profile.edit'))->assertRedirect(route('login'));
});

it('update the profile successfully', function () {
    $this->actingAs($user = User::factory()->create());

    visit(route('profile.update'))
        ->assertValue('name', $user->name)
        ->assertValue('email', $user->email)
        ->assertValue('password', '')
        ->fill('name', 'New name')
        ->fill('email', 'email@gmail.com')
        ->click('Update account')
        ->assertSee('Your profile has been updated.');

    expect($user->fresh())->toMatchArray([
        'name' => 'New name',
        'email' => 'email@gmail.com',
    ]);
});

it('update the profile successfully with password', function () {
    $this->actingAs($user = User::factory()->create());

    visit(route('profile.update'))
        ->assertValue('name', $user->name)
        ->assertValue('email', $user->email)
        ->assertValue('password', '')
        ->fill('name', 'New name')
        ->fill('email', 'email@gmail.com')
        ->fill('password', 'password123')
        ->click('Update account')
        ->assertSee('Your profile has been updated.');

    expect($user->fresh())->toMatchArray([
        'name' => 'New name',
        'email' => 'email@gmail.com',
    ])->and(Hash::check('password123', $user->fresh()->password))->toBeTrue();
});
it('send a notification to the old user when email updated', function () {
    $this->actingAs($user = User::factory()->create());

    Notification::fake();
    $oldEmail = $user->email;

    visit(route('profile.update'))
        ->assertValue('email', $user->email)
        ->fill('email', 'email@gmail.com')
        ->click('Update account')
        ->assertSee('Your profile has been updated.');

    Notification::assertSentOnDemand(EmailChanged::class, fn (EmailChanged $notification, $routes, $notifiable) => $notifiable->routes['mail'] === $oldEmail);
});
