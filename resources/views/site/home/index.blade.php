<x-site-layout>
    <x-site.svgs.cca-sketch-mobile class="lg:hidden"/>
    <x-site.svgs.cca-sketch-desktop class="hidden lg:block"/>
    <div class="mt-1 p-4 bg-surface">
        <h1 class="text-center text-2xl font-yellowtail">Quality Service Since 1995</h1>
    </div>

    <div class="mt-1 grid gap-1 md:grid-cols-3">
        @foreach($recentPosts as $post)
            <div class="relative -z-10">
                <img class="object-cover aspect-[4/3]" src="{{ asset($post->images[0]->thumbnail_path ?? $post->images[0]->file_path)  }}" alt="">
                <div class="absolute right-0 bottom-0 left-0 h-1/6 bg-gradient-to-t from-surface"></div>
                <h2 class="absolute bottom-0 left-0 p-4 text-lg">{{ $post->title }}</h2>
            </div>
        @endforeach
    </div>

    <div class="mt-1 grid gap-1 md:grid-cols-2">
        <x-site.svgs.garage-sketch-tile-services/>
        <x-site.svgs.garage-sketch-tile-about/>
    </div>

</x-site-layout>
