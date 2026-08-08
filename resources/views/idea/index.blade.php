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
        class="w-full h-32 text-left mb-8"
        data-test="create-idea-button"
    >
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
            <form
                x-data="{
                ideaStatus: 'pending',
                newLink: '',
                links: [],
                newStep: '',
                steps: []
                }"
                action="{{route('idea.store')}}"
                method="post"
            >
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
                                    data-test="button-status-{{$status->value}}"
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

{{--Steps--}}
                    <fieldset class="space-y-3">
                        <strong class="inline-block">Steps</strong>
                        <template x-for="( step, index ) in steps">
                            <div class="flex items-center">
                                <input class="input flex-1" x-model="step" name="steps[]">
                                <button
                                    @click="steps.splice(index, 1)"
                                    type="button"
                                    aria-label="Remove Step"
                                    class="w-10 flex items-center justify-center"
                                >
                                    <x-icons.close class="text-white" />
                                </button>
                            </div>
                        </template>
                        <div class="flex items-center">
                            <input
                                type="text"
                                placeholder="What you need to be done"
                                class="flex-1 input"
                                spellcheck="false"
                                x-model="newStep"
                                data-test="add-step-input"
                            >
                            <button
                                @click="steps.push(newStep.trim()); newStep= '';"
                                :disabled="newStep.trim().length === 0"
                                type="button"
                                aria-label="Add a new step"
                                class="w-10 flex items-center justify-center"
                                data-test="add-step-button"
                            >
                                <x-icons.close class="rotate-45 text-white" />
                            </button>
                        </div>
                    </fieldset>

{{--Links--}}
                    <fieldset class="space-y-3">
                        <label class="inline-block">Links</label>
                        <template x-for="( link, index ) in links">
                            <div class="flex items-center">
                                <input class="input flex-1" x-model="link" name="links[]">
                                <button
                                    @click="links.splice(index, 1)"
                                    type="button"
                                    aria-label="Remove link"
                                    class="w-10 flex items-center justify-center"
                                >
                                    <x-icons.close class="text-white" />
                                </button>
                            </div>
                        </template>
                        <div class="flex items-center">
                            <input
                                type="url"
                                placeholder="http://example.com"
                                class="flex-1 input"
                                spellcheck="false"
                                x-model="newLink"
                                autocomplete="url"
                                data-test="add-link-input"
                            >
                            <button
                                @click="links.push(newLink.trim()); newLink= '';"
                                :disabled="newLink.trim().length === 0"
                                type="button"
                                aria-label="Add a new link"
                                class="w-10 flex items-center justify-center"
                                data-test="add-link-button"
                            >
                                <x-icons.close class="rotate-45 text-white" />
                            </button>
                        </div>
                    </fieldset>

                    <div class="flex justify-end gap-x-5">
                        <button type="button"
                                @click="$dispatch('close-modal')">Cancel
                        </button>
                        <button class="btn" type="submit">Create</button>
                    </div>
                </div>
            </form>
        </x-modal>
    </div>
</x-layouts.layout>
