@props(['id', 'name', 'label' => null, 'value' =>'', 'options' => []])

<div class="mb-4">
    @if($label)
    <label for="{{$id}}" name="{{$name}}" class="block text-gray-700">{{$label}}</label>
    @endif
    <select
        id="{{$id}}"
        name="{{$name}}"
        class="w-full px-4 py-2 border rounded focus:outline-none @error($name) border-red-500 @enderror"
    >
        @foreach($options as $optionValue => $optionLabel)
        <option value="{{$optionValue}}" {{old($name, $value) == $optionValue ? 'selected' : ''}}>
            {{$optionLabel}}
        </option>
        @endforeach
        @error($name)
        <p class="text-red-500 mt-2 text-sm">{{$message}}</p>
        @enderror
    </select>
</div>