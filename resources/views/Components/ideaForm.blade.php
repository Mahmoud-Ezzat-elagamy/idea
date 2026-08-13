@php use App\IdeaStatus;use App\Models\Idea;@endphp

@props([
    'name',
    'title',
    'idea' => new Idea(),
])

<x-modal name="{{ $idea->exists ? 'edit-idea' : 'create-idea'  }}"
         title="{{ $idea->exists ? 'Edit Idea' : 'Create Idea'  }}">
    <form
        x-data="{
                ideaStatus: @js(old('status', $idea->status->value)),
                newLink: '',
                links: @js( old('links', $idea->links ?? [])  ),
                newStep: '',
                steps: @js(old( 'steps', $idea->steps->map->only(['id', 'description', 'completed'])))
            }"
        action="{{$idea->exists ? route('idea.update', $idea) : route('idea.store')}}"
        method="post"
        {!! app()->runningUnitTests() ? '' : 'enctype="multipart/form-data"' !!}
    >
        @csrf
        @method($idea->exists ? 'PATCH' : 'POST')
        <input type="hidden" name="status" x-model="ideaStatus"
               value= @js(old('ideaStatus', $idea->status->value ?? IdeaStatus::values()[0]))
        >

        <div class="space-y-6">
            <x-form.field
                label="Title"
                name="title"
                type="text"
                placeholder="Enter a title for you idea"
                autofocus
                required
                :value="$idea->title"
            />
            <div class="space-y-2">
                <label for="status" class="label">Status</label>
                <div class="flex items-center gap-3">
                    @foreach(IdeaStatus::cases() as $status)
                        <button
                            type="button"
                            @click="ideaStatus = @js($status->value)"
                            class="btn flex-1 h-10"
                            :class="{ 'btn-outlined': ideaStatus !== @js($status->value) }"
                            data-test="button-status-{{$status->value}}"
                        >{{$status->label()}}</button>
                    @endforeach

                    <x-form.error name="status" />

                </div>
            </div>

            <x-form.field
                label="Description"
                name="description"
                type="textarea"
                placeholder="Enter a description for your idea"
                :value="$idea->description"
            />

            <div class="space-y-2">
                <label for="image" class="label">Featured Image</label>

                <input type="file" name="image" accept="image/*">
                <x-form.error name="image" />
            </div>

            @if($idea->image_path)
                <div class="mb-4 -mx-4 -mt-4 rounded-t-lg overflow-hidden space-y-2">
                    <img src="{{ asset('storage/'. $idea->image_path) }}" alt="{{ $idea->title }}"
                         class="w-full h-48 object-cover">

                    <button class="btn btn-outlined w-full rounded-large" form="delete-image-form">Remove Image</button>
                </div>
            @endif

            {{--Steps--}}
            <fieldset class="space-y-3">
                <strong class="inline-block">Steps</strong>
                <template x-for="( step, index ) in steps" :key="step.id">
                    <div class="flex items-center">
                        <input class="input flex-1" x-model="step.description" :name="`steps[${index}][description]`">
                        <input class="input flex-1" x-model="step.completed ? '1' : '0'"
                               :name="`steps[${index}][completed]`" type="hidden">
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
                        @click="steps.push({description: newStep.trim(), completed: false}); newStep= '';"
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
                <strong class="inline-block">Links</strong>
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
                <button class="btn" type="submit">{{ $idea->exists ? 'Update': 'Create' }}</button>
            </div>
        </div>
    </form>
    @if($idea->exists && $idea->image_path)
        <form action="{{ route('idea.destroy-image', $idea) }}" method="POST" id="delete-image-form">
            @csrf
            @method('DELETE')
        </form>
    @endif
</x-modal>
