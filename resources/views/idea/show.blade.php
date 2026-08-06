@php
    ['title' => $title, 'description' => $description, 'links'=>$links] = $idea->attributesToArray();
@endphp

<x-layouts.layout>
    <div class="py-8 max-w-4xl mx-auto">
        <div class="flex justify-between mb-6">
            <a href="{{ route('idea.index') }}" class="flex items-center gap-2 text-sm font-bold">
                <x-icons.arrow-back />
                Back to Ideas
            </a>

            <div class="flex items-center justify-between">
                <button class="btn btn-outlined">
                    <x-icons.external />
                    Edit Idea
                </button>
                <form method="post" action="{{ route('idea.destroy', $idea) }}">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outlined text-red-500" type="submit">
                        <x-icons.trash />
                        Delete
                    </button>
                </form>
            </div>
        </div>
        {{--header, status bar, description, links--}}
        <div class="">
            <h1 class="font-bold text-4xl">{{ $title }}</h1>

            <div class="mt-2 flex gap-x-3 items-center">
                <x-idea.status-label
                    status="{{ $idea->status->value }}">{{ $idea->status->label() }}</x-idea.status-label>

                <div class="text-muted-foreground text-sm"> {{ $idea->created_at->diffForHumans() }}</div>
            </div>

            <x-card is="div" class="mt-6">
                <div class="text-foreground">
                    {{ $description }}
                </div>
            </x-card>

            @if($idea->links)
                <div class="mt-6">
                    <h3 class="text-2xl font-bold">Links</h3>
                    <div class="space-y-3 mt-3">
                        @foreach($idea->links as $link)
                            <x-card href="{{ $link }}" class="text-primary flex gap-x-3">
                                <x-icons.external />
                                {{ $link }}</x-card>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layouts.layout>
