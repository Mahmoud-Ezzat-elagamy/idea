<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Idea;
use Illuminate\Support\Facades\DB;
use Throwable;

class UpdateIdea
{
    /**
     * @throws Throwable
     */
    public function handle(array $attributes, Idea $idea): void
    {
        $ideaData = collect($attributes)->except(['steps', 'image'])->toArray();
        if (collect($attributes)->has('image')) {
            $image_path = $attributes['image']->store('ideas', 'public');
            $ideaData['image_path'] = $image_path;
        }

        $stepsData = $attributes['steps'] ?? [];

        //        acting with the database
        DB::transaction(function () use ($stepsData, $ideaData, $idea) {
            $idea->update($ideaData); // add idea

            $idea->steps()->delete();

            $idea->steps()->createMany($stepsData);
        });

    }
}
