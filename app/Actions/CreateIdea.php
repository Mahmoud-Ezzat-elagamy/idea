<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateIdea
{
    /**
     * @throws \Throwable
     */
    public function handle($attributes, ?User $user = null): void
    {
        //        if there is no assume that the user is the authenticated one
        $user ??= Auth::user();

        //        Idea data + image
        $ideaData = $attributes->except(['steps', 'image']);
        if ($attributes->image) {
            $image_path = $attributes['image']->store('ideas', 'public');
            $ideaData['image_path'] = $image_path;
        }

        $stepsData = collect($attributes->steps)->map(fn ($step) => [
            'description' => $step,
        ]) ?? [];

        //        acting with the database
        DB::transaction(function () use ($stepsData, $ideaData) {
            $idea = Auth::user()->ideas()->create($ideaData); // add idea
            if ($stepsData) { // add steps
                $idea->steps()->createMany($stepsData);
            }
        });

    }
}
