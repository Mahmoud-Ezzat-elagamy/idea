@props(['name', 'title'])

<div
    x-data="{show: false, name:'{{$name}}' }"
    x-show="show"
    @keydown.escape.window="show = false"
    @open-modal.window="if($event.detail === name) show = true"
    @close-modal = "show = false"
    x-transition:enter="ease-out duration-250"
    x-transition:enter-start="opacity-0 -translate-x-4 -translate-y-4"
    x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-250"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0 -translate-x-4 -translate-y-4"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-xs"
    style="display: none"
>
    <x-card
        @click.away="show = false"
        class="shadow-xl max-w-2xl w-full max-h-[80dvh] overflow-auto relative"
    >
        @if(isset($title))
            <div class="">
                <h2 class="text-2xl font-bold mb-6 text-center">{{$title}}</h2>
            </div>
        @endif

        <button aria-label="close modal" @click="show = false" class="absolute top-3 right-3">
            <x-icons.close />
        </button>

        {{$slot}}
    </x-card>
</div>
