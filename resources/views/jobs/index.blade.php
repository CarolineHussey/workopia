<x-layout>

<h1 class="text-2xl font-bold mb-5">All Jobs</h1>
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

    @forelse($jobs as $job)
    <x-job-card :job="$job"/>
    @empty<p>There are no jobs available at present. Please try again later.</p>
    @endforelse
  </div>
  {{--pagination links--}}
  {{$jobs->links()}}

</x-layout>