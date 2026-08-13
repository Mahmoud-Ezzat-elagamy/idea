@php use App\Models\Idea; @endphp
@props([
    'label' => false,
    'name',
    'type' => 'text',
    'value' => null,
    ])
{{--{{ $idea?->$name }}--}}
<div class="space-y-1">
    @if($label)
        <label for="{{$name}}" class="label">{{$label}}</label>
    @endif

    @if($type === 'textarea')
        <textarea
            id="{{$name}}" name="{{$name}}" placeholder="Describe your idea" class="textarea" {{$attributes}}
        >{{ old($name, $value) }}</textarea>
    @else
        <input type="{{$type}}"
               class="input"
               id="{{$name}}"
               name="{{$name}}"
               value="{{ old($name, $value) }}"
               {{ $attributes }}
        />
    @endif

    <x-form.error name="{{$name}}" />
</div>
