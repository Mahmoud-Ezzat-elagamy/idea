<?php

use App\Models\Idea;
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

it('can edit idea', closure: function () {
    $this->actingAs($user = User::factory()->create());

    $idea = Idea::factory()->for($user)->create();

    visit(route('idea.show', $idea))
        ->click('@edit-idea-button')
        ->fill('title', 'Create idea')
        ->click('@button-status-completed')
        ->fill('description', 'Idea created description')
        ->fill('@add-link-input', 'https://example.com')
        ->click('@add-link-button')
        ->fill('@add-link-input', 'https://example2.com')
        ->click('@add-link-button')
        ->debug()
        ->click('Update')
        ->assertPathIs('/ideas/'.$idea->id);

    $idea = $user->ideas()->first();

    expect($idea)->toMatchArray([
        'title' => 'Create idea',
        'description' => 'Idea created description',
        'status' => 'completed',
        'links' => [$idea->links[0], 'https://example.com', 'https://example2.com'],
    ]);
});
