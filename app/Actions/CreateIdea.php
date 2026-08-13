<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class CreateIdea
{
    /**
     * @throws Throwable
     */
    public function handle(array $attributes, ?User $user = null): void
    {
        $user ??= Auth::user();

        $ideaData = collect($attributes)->except(['steps', 'image'])->toArray();
        if (isset($attributes['image']) && $attributes['image']) {
            $image_path = $attributes['image']->store('ideas', 'public');
            $ideaData['image_path'] = $image_path;
        }

        $stepsData = collect($attributes['steps'] ?? [])->map(fn ($step) => [
            'description' => $step['description'],
        ])->toArray();

        DB::transaction(function () use ($stepsData, $ideaData, $user) {
            $idea = $user->ideas()->create($ideaData);
            if ($stepsData) {
                $idea->steps()->createMany($stepsData);
            }
        });
    }
}
