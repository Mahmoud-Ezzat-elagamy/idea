<?php


use App\Models\Idea;
use App\Models\User;

it('can create idea', closure: function () {
    $this->actingAs($user = User::factory()->create());
    visit(route('idea.index'))
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

    $idea = $user->refresh()->ideas()->first();

    expect([
        'title' => $idea->title,
        'description' => $idea->description,
        'status' => $idea->status->value, // Extract the backing string ('completed')
        'links' => $idea->links->toArray(), // Convert ArrayObject to a primitive array
    ])->toBe([
        'title' => 'Create idea',
        'description' => 'Idea created description',
        'status' => 'completed',
        'links' => [
            'https://example.com',
            'https://example2.com',
        ],
    ]);
});
