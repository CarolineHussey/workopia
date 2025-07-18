<x-layout>
  <div class="bg-white rounded-lg shadow-md w-full md:max-w-xl mx-auto mt-12 p-8 py-12">
    <h2 class="text-4xl text-center font-bold mb-4">Login</h2>
    <form method="POST" action="{{route('login.authenticate')}}">
      @csrf
      <x-inputs.text id="email" name="email" type="email" placeholder="Email Address" />
      <x-inputs.text id="password" name="password" type="password" placeholder="Password" />
      <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded focus:outline-none">Login</button>
      <div class="mt-4 text-gray-500">
        <p>Don't have an account? <a href="/register" class="text-blue-900">Register</a></p>
        
      </div>
    </form>
  </div>
</x-layout>