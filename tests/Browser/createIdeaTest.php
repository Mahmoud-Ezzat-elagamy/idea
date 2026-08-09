<?php

use App\Models\User;

it('can create idea', closure: function () {
    $this->actingAs($user = User::factory()->create());

    visit('/ideas')
        ->click('@create-idea-button')
        ->fill('title', 'Create idea')
        ->click('@button-status-completed')
        ->fill('description', 'Idea created description')
        ->fill('@add-link-input', 'https://example.com')
        ->click('@add-link-button')
        ->fill('@add-link-input', 'https://example2.com')
        ->click('@add-link-button')
        ->click('Create')
        ->assertPathIs('/ideas');

    $idea = $user->ideas()->first();

    expect($idea)->toMatchArray([
        'title' => 'Create idea',
        'description' => 'Idea created description',
        'status' => 'completed',
        'links' => ['https://example.com', 'https://example2.com'],
    ]);
});
