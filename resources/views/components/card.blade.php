@props(['room'])

<div
    class="z-10 grid h-60 grid-cols-[30%_minmax(0px,1fr)_30%] grid-rows-1 overflow-hidden rounded-xl bg-white shadow-md">
    <div class="relative">
        @if ($room->images->count())
            <img class="h-full w-full" src="{{ Vite::asset('storage/app/' . $room->images->first()->src) }}"
                alt="image">
            <div class="absolute bottom-1 right-2 rounded-md bg-gray-500 bg-opacity-60 px-1 text-white">
                {{ $room->images->count() }}
            </div>
        @else
            <div class="flex h-full w-full items-center justify-center border-r-2 border-solid border-gray-200">
                <x-svg-icon class="h-10 w-10 fill-dark-blue" name="image"></x-svg-icon>
            </div>
            <div class="absolute bottom-1 right-2 rounded-md bg-gray-500 bg-opacity-60 px-1 text-white">
                0
            </div>
        @endif
    </div>
    <div class="text-dark-blue scrollbar-hide flex flex-col gap-2 overflow-scroll px-3 py-2">
        <div class="break-words text-xl font-semibold">
            <p>{{ $room->name }}</p>
        </div>
        <div class="flex items-center gap-2">
            <x-svg-icon class="fill-orange-500" name="star"></x-svg-icon>
            <p class="text-xl">{{ $room->avgPoint() }}</p>
        </div>
        <div class="flex items-center gap-2">
            <x-svg-icon class="fill-blue-500" name="phone"></x-svg-icon>
            <p class="text-xl">{{ $room->user->phone }}</p>
        </div>
        <div class="flex items-center gap-2">
            <x-svg-icon class="fill-purple-500" name="user"></x-svg-icon>
            <p class="text-xl">{{ $room->quantity }}</p>
        </div>
        <div>
            {{ $room->description }}
        </div>
    </div>
    <div class="p-3">
        <div class="bg-dark-blue flex h-full flex-col items-center justify-center rounded-md text-center text-white">
            <div class="text-2xl">
                {{ $room->price_text }} VNĐ
            </div>
            <div>
                1 tháng
            </div>
            <a class="text-dark-blue mt-1 block rounded-md bg-white p-2 shadow-sm hover:bg-slate-100"
                href="{{ route('rooms.show', $room) }}">
                Xem thêm
            </a>
        </div>
    </div>
</div>
