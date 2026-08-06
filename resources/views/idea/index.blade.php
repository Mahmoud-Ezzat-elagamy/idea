@php use App\IdeaStatus; @endphp
<x-layouts.layout>
    <header class="py-8 md:py-12">
        <h1 class="text-3xl font-bold">Ideas</h1>
        <p class="text-muted-foreground text-sm mt-2">Capture your thoughts. Make a plan.</p>
    </header>

{{--    Create a new idea               --}}
    <x-card
        x-data
        {{--            $dispatch(eventName,     eventDetails   --}}
        @click="$dispatch('open-modal', 'create-idea')"
        is="button"
        class="w-full h-32 text-left mb-8">
        What is the idea?
    </x-card>

        {{--    Filtering               --}}
    <div>
        <a href="/ideas" class="btn {{ request()->has('status') ? 'btn-outlined' : '' }}">All
            <span>{{ $statusCount['all'] }}</span></a>
        @foreach(IdeaStatus::cases() as $status)
            <a href="/ideas?status={{$status->value}}"
               class="btn {{request("status") === $status->value ? '' : 'btn-outlined'}}">
                {{$status->label()}}

                <span class="pl-2">
                {{$statusCount->has($status->value)? $statusCount[$status->value] : 0}}
            </span>
            </a>
        @endforeach
    </div>

    <div class="mt-10 text-muted-foreground">
        {{--        Show all ideas           --}}
        <div class="grid md:grid-cols-2 gap-6">
            @forelse($ideas as $idea)
                <x-card href="{{ route('idea.show', $idea) }}">
                    <h3 class="text-foreground text-lg">{{$idea->title}}</h3>

                    <x-idea.status-label status="{{$idea->status->value}}">
                        {{ $idea->status->label() }}
                    </x-idea.status-label>

                    <div class="mt-5 line-clamp-3 ">{{$idea->description}}</div>
                    <div class="mt-4">{{$idea->created_at->diffForHumans()}}</div>
                </x-card>
            @empty
                <x-card is="div">
                    <p>No Ideas at this time.</p>
                </x-card>
            @endforelse
        </div>
        {{--        out modal for idea       --}}
        <x-modal name="create-idea" title="Create Idea">
            <form x-data="{ ideaStatus: @js(IdeaStatus::cases()[0]->value) }" action="{{route('idea.store')}}"
                  method="post">
                @csrf
                <input type="hidden" name="status" x-model="ideaStatus">

                <div class="space-y-6">
                    <x-form.field
                        label="Title"
                        name="title"
                        type="text"
                        placeholder="Enter a title for you idea"
                        autofocus
                        required
                    />
                    <div class="space-y-2">
                        <label for="status" class="label">Status</label>
                        <div class="flex items-center gap-3">
                            @foreach(IdeaStatus::cases() as $status)
                                <button
                                    type="button"
                                    @click="ideaStatus = @js($status->value)"
                                    class="btn flex-1 h-10"
                                    :class="{'btn-outlined': @js($status->value) !== ideaStatus}"
                                >{{$status->label()}}</button>
                            @endforeach

                            <x-form.error name="status" />

                        </div>
                    </div>

                    <x-form.field
                        label="Description"
                        name="description"
                        type="textarea"
                        placeholder="Enter a title for you idea"
                        autofocus
                    />
                    <div class="flex justify-end gap-x-5">
                        <button type="button"
                        @click="$dispatch('close-modal')">Cancel</button>
                        <button class="btn" type="submit">Create</button>
                    </div>
                </div>
            </form>
        </x-modal>
    </div>
</x-layouts.layout>
