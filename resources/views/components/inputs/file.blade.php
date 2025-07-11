@props(['id', 'name', 'label' => null, 'required' => false])

<div class="mb-4">
    @if($label)
    <label for="{{$id}}" name="{{$name}}" class="block text-gray-700">{{$label}}</label>
    @endif
    <input
        id="{{$id}}"
        type="file"
        name="{{$name}}"
        class="w-full px-4 py-2 border rounded focus:outline-none @error($name) border-red-500 @enderror"
        {{$required ? 'required' : ''}}
    />
    @error($name)
    <p class="text-red-500 mt-2 text-sm">{{$message}}</p>
    @enderror
</div>