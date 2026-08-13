@props(['idea'])

<x-layouts.layout>
    <div class="py-8 max-w-4xl mx-auto">
        <div class="flex justify-between mb-6">
            <a href="{{ route('idea.index') }}" class="flex items-center gap-2 text-sm font-bold">
                <x-icons.arrow-back />
                Back to Ideas
            </a>

            <div class="flex items-center justify-between">
                <button class="btn btn-outlined"
                        x-data
                        @click="$dispatch('open-modal', 'edit-idea')"
                        data-test="edit-idea-button"
                >
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
        <div class="space-y-6">

            @if($idea->image_path)
                <div class="overflow-hidden rounded-lg">

                    <img src="{{ asset('storage/' .$idea->image_path) }}"
                         alt="image"
                         class="w-full h-auto object-cover" />
                </div>
            @endif

            <h1 class="font-bold text-4xl">{{ $idea->title }}</h1>

            <div class="flex gap-x-3 items-center">
                <x-idea.status-label
                    status="{{ $idea->status->value }}">{{ $idea->status->label() }}</x-idea.status-label>

                <div class="text-muted-foreground text-sm"> {{ $idea->created_at->diffForHumans() }}</div>
            </div>

            @if($idea->description)
                <x-card is="div">
                    <div class="text-foreground prose prose-invert">
                        {!! $idea->formattedDescription !!}
                    </div>
                </x-card>
            @endif

            @if($idea->steps->count())
                <div class="space-y-3">
                    <h3 class="text-2xl font-bold">Steps</h3>
                    @foreach($idea->steps as $step)
                        <form
                            action="{{route('step.update', $step)}}"
                            method="post">
                            @csrf
                            @method('PATCH')
                            <x-card class="flex items-center gap-x-3">
                                <button
                                    class="size-5 rounded-md items-center flex justify-center border border-primary  text-primary-foreground font-bold {{$step->completed ? 'bg-primary': ''}}">
                                    @if($step->completed)
                                        &check;
                                    @endif
                                </button>
                                <span>{{$step->description}}</span>
                            </x-card>
                        </form>
                    @endforeach
                </div>
            @endif

            @if($idea->links->count())
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
        <x-ideaForm
            name="edit-idea"
            title="Edit Idea"
            :idea="$idea"
        />
    </div>
</x-layouts.layout>
