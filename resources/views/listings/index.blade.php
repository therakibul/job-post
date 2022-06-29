<x-layout>
    @include('partials._hero')
    @include('partials._search')
    <div class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4">
        @unless (count($listings) == 0)
            @foreach ($listings as $listing)
                <x-listing-card :listing="$listing" />
            @endforeach
            @else 
                <h2>No Listing Found.</h2>
        @endunless
    </div>
    <x-card class="mt-3">
        {{$listings->links()}}
    </x-card>
</x-layout>
