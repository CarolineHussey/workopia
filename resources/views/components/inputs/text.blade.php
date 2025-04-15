@props(['id', 'name', 'label' => null, 'type' => 'text', 'value' =>'', 'placeholder' => '', 'required' => false])


<div class="my-5">
    @if($label)
    <label for="{{$id}}" class="block text-gray-700">{{$label}}</label>
    @endif

    <input id="{{$id}}" type="{{$type}}" name="{{$name}}" class="w-full px-4 py-2 border rounded focus:outline-none @error($name) border-red-500 @enderror" placeholder="{{$placeholder}}" value="{{old($name, $value)}}" {{$required ? 'required' : ''}}>

    @error($name)
    <p class="text-red-500 mt-2 text-sm">{{$message}}</p>
    @enderror
  </div>