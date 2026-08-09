<?php

use App\Models\Idea;
use App\Models\User;

use function Pest\Laravel\actingAs;

it('require authentication to view idea details', function () {
    //    1) create an idea
    $idea = Idea::factory()->create();

    //   2) try to show it in show rout without authentication
    //   3) assert
    $this->get(route('idea.show', $idea))
        ->assertRedirectToRoute('login');
});

it('require authorization to view idea details', function () {
    //    1) create idea
    $idea = Idea::factory()->create();
    //    2) create user and login
    $user = User::factory()->create();
    actingAs($user);
    //    3) try to access the idea with this random user assertForbidden
    $this->get(route('idea.show', $idea))
        ->assertForbidden();
});
