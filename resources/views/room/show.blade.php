<x-app>
    <div class="mt-3 px-[5%] md:px-[10%] xl:px-[15%] 2xl:px-[30%]">
        <div
            class="z-10 grid h-60 grid-cols-[30%_minmax(0px,1fr)_30%] grid-rows-1 overflow-hidden rounded-xl bg-white shadow-md">
            <div>
                @if ($room->images->count())
                    <img class="h-full w-full" src="{{ Vite::asset('storage/app/' . $room->images->first()->src) }}"
                        alt="image">
                @else
                    <div class="flex h-full w-full items-center justify-center border-r-2 border-solid border-gray-200">
                        <x-svg-icon class="h-24 w-24" name="image"></x-svg-icon>
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
                <div class="">
                    {{ $room->description }}
                </div>
            </div>
            <div class="p-3">
                <div
                    class="bg-dark-blue flex h-full flex-col items-center justify-center rounded-md text-center text-white">
                    <div class="text-2xl">
                        {{ $room->price_text }} VNĐ
                    </div>
                    <div>
                        1 tháng
                    </div>
                    @can(['update', 'delete'], $room)
                        <div class="flex gap-2">
                            <a class="text-dark-blue mt-1 block rounded-md bg-white p-2 shadow-sm hover:bg-slate-100"
                                href="{{ route('rooms.edit', $room) }}">
                                <x-svg-icon class="fill-dark-blue" name="edit"></x-svg-icon>
                            </a>
                            <form action="{{ route('rooms.destroy', $room) }}" method="POST">
                                @csrf
                                @method('delete')
                                <button
                                    class="text-dark-blue mt-1 block rounded-md bg-white p-2 shadow-sm hover:bg-slate-100">
                                    <x-svg-icon class="fill-dark-blue" name="delete"></x-svg-icon>
                                </button>
                            </form>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
    <div class="mt-3 h-[52em] px-[5%] md:px-[10%] xl:px-[15%] 2xl:px-[30%]">
        <div class="grid h-full grid-cols-1 grid-rows-[4em_minmax(0px,1fr)] rounded-md bg-white shadow-md"
            x-data="{
                selected: 2,
                active: 'text-dark-blue cursor-pointer border-dark-blue flex items-center border-b-2 border-solid px-2 font-semibold'
            }">
            <div class="flex h-full items-stretch justify-center gap-1 border-b-[1px] border-solid border-gray-200">
                <x-nav-top-link @click="selected = 0" x-bind:class="selected == 0 ? active : ''">Photos</x-nav-top-link>
                <x-nav-top-link @click="selected = 1" x-bind:class="selected == 1 ? active : ''">Overview
                </x-nav-top-link>
                <x-nav-top-link @click="selected = 2" x-bind:class="selected == 2 ? active : ''">Preview
                </x-nav-top-link>
            </div>
            <!-- Photos -->
            <template x-if="selected == 0">
                @if ($room->images->count())
                    <div class="grid grid-cols-[25%_1fr] grid-rows-1">
                        <!-- List Image -->
                        <div class="flex flex-col gap-2 overflow-y-auto border-r-2 border-solid border-gray-200 p-2"
                            x-data="{ style: 'outline-dark-blue h-40 w-full rounded-sm outline-double outline-1', imageSelected: 'id-img-1' }">
                            @foreach ($room->images as $image)
                                <x-image-link src="{{ Vite::asset('storage/app/' . $image->src) }}" x-id="['id-img']"
                                    x-bind:id="$id('id-img')" x-bind:class="imageSelected == $el.id ? style : ''"
                                    @click="$refs.image.src = $el.src; imageSelected = $el.id"
                                    x-bind:alt="img_selected">
                                </x-image-link>
                            @endforeach
                        </div>
                        <!-- Zoom out Image -->
                        <div class="p-1">
                            <img class="h-full w-full rounded-md" id="image-content"
                                src="{{ Vite::asset('storage/app/' . $room->images[0]->src) }} " alt=""
                                x-ref="image">
                            <p x-ref="text"></p>
                        </div>
                    </div>
                @endif
            </template>
            <!-- Overview -->
            <template x-if="selected == 1">
                <div class="text-dark-blue flex flex-col gap-4 py-2 px-8">

                    <!-- Name -->
                    <div class="w-full pb-2 text-2xl font-semibold">
                        {{ $room->name }}
                    </div>
                    <!-- Rate -->
                    <div>
                        <div class="text-xl font-semibold">
                            Đánh giá
                        </div>
                        <div class="flex items-center gap-2">
                            <x-svg-icon class="fill-orange-500" name="star"></x-svg-icon>
                            <p class="text-xl">{{ $room->avgPoint() }}</p>
                        </div>
                    </div>
                    <!-- Phone -->
                    <div>
                        <div class="text-xl font-semibold">
                            Số điện thoại liên hệ
                        </div>
                        <div class="flex items-center gap-2">
                            <x-svg-icon class="fill-blue-500" name="phone"></x-svg-icon>
                            <p class="text-xl">{{ $room->user->phone }}</p>
                        </div>
                    </div>
                    <!-- Quantity-->
                    <div>
                        <div class="text-xl font-semibold">
                            Số lượng người ở
                        </div>
                        <div class="flex items-center gap-2">
                            <x-svg-icon class="fill-purple-500" name="user"></x-svg-icon>
                            <p class="text-xl">{{ $room->quantity }}</p>
                        </div>
                    </div>
                    <!-- Price-->
                    <div>
                        <div class="text-xl font-semibold">
                            Giá phòng mỗi tháng
                        </div>
                        <div class="flex items-center gap-2">
                            <x-svg-icon class="fill-green-400" name="money-bill"></x-svg-icon>
                            <p class="text-xl">{{ $room->price_text }} VND</p>
                        </div>
                    </div>
                    <!-- Description -->
                    <div>
                        <div class="text-xl font-semibold">
                            Mô tả
                        </div>
                        <div>
                            {{ $room->description }}
                        </div>
                    </div>
                    <!-- User -->
                    <div>
                        <div class="text-xl font-semibold">
                            Người đăng
                        </div>
                        <div class="mt-2 flex items-center">
                            <div class="text-dark-blue flex cursor-pointer items-center gap-2 text-xl">
                                @if ($room->user->avatar)
                                    <img class="h-8 w-8 rounded-full"
                                        src="{{ Vite::asset('storage/app/' . $room->user->avatar->src) }}"
                                        alt="avatar">
                                @else
                                    <img class="h-8 w-8 rounded-full"
                                        src="{{ Vite::asset('resources/images/user.png') }}" alt="avatar">
                                @endif
                                <p>{{ $room->user->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            <!-- Preview -->
            <template x-if="selected == 2">
                <div class="text-dark-blue scrollbar-hide overflow-x-auto p-4">
                    <!-- Graphic -->
                    <div>
                        <div>
                            Tổng {{ $room->rates->count() }} lượt chọn
                        </div>
                        <div class="mt-2 flex items-center gap-2">
                            <x-svg-icon class="fill-orange-500" name="star"></x-svg-icon>
                            <p>{{ $room->avgPoint() }}</p>
                        </div>
                        @php
                            $fiveStarsPercent = $room->starsRateCount(5) * 100 . '%';
                            $fourStarsPercent = $room->starsRateCount(4) * 100 . '%';
                            $threeStarsPercent = $room->starsRateCount(3) * 100 . '%';
                            $twoStarsPercent = $room->starsRateCount(2) * 100 . '%';
                            $oneStarsPercent = $room->starsRateCount(1) * 100 . '%';
                        @endphp
                        <div class="mt-4 flex items-center">
                            <x-rate-label>5 stars</x-rate-label>
                            <x-percent-rate-label percent="{{ $fiveStarsPercent }}"></x-percent-rate-label>
                            <x-rate-label>{{ $fiveStarsPercent }}</x-rate-label>
                        </div>
                        <div class="mt-4 flex items-center">
                            <x-rate-label>4 stars</x-rate-label>
                            <x-percent-rate-label percent="{{ $fourStarsPercent }}"></x-percent-rate-label>
                            <x-rate-label>{{ $fourStarsPercent }}</x-rate-label>
                        </div>
                        <div class="mt-4 flex items-center">
                            <x-rate-label>3 stars</x-rate-label>
                            <x-percent-rate-label percent="{{ $threeStarsPercent }}"></x-percent-rate-label>
                            <x-rate-label>{{ $threeStarsPercent }}</x-rate-label>
                        </div>
                        <div class="mt-4 flex items-center">
                            <x-rate-label>2 stars</x-rate-label>
                            <x-percent-rate-label percent="{{ $twoStarsPercent }}"></x-percent-rate-label>
                            <x-rate-label>{{ $twoStarsPercent }}</x-rate-label>
                        </div>
                        <div class="mt-4 flex items-center">
                            <x-rate-label>1 stars</x-rate-label>
                            <x-percent-rate-label percent="{{ $oneStarsPercent }}"></x-percent-rate-label>
                            <x-rate-label>{{ $oneStarsPercent }}</x-rate-label>
                        </div>
                    </div>

                    <!-- Danh sách đánh giá -->
                    <div class="mt-8">
                        @if (Auth::user()?->rate)
                            @php($rate = Auth::user()->rate)
                            <div x-data="{ canEdit: false }">
                                <!-- Chỉnh sửa đánh giá của bạn -->
                                <template x-if="canEdit">
                                    <form method="POST" action="{{ route('rates.update', $rate) }}">
                                        @csrf
                                        @method('patch')
                                        <div class="flex items-center gap-1" x-data="{ rate: {{ $rate->point }}, rateHover: 0 }">
                                            <template x-for="i in 5">
                                                <div x-data="{
                                                    get isActive() { return this.iactive <= rate },
                                                    get isHover() { return this.ihover <= rateHover },
                                                    iactive: i,
                                                    ihover: i
                                                }" @mouseenter="rateHover = ihover"
                                                    @mouseleave="rateHover = rate"
                                                    @click="rate = rate == iactive ? 0 : iactive; $refs.rateValue.value=rate">
                                                    <x-svg-icon name="star"
                                                        x-bind:class="(isHover ? true : null ?? isActive) ? 'fill-orange-500' :
                                                        'hidden'">
                                                    </x-svg-icon>
                                                    <x-svg-icon name="solid-star"
                                                        x-bind:class="(isHover ? true : null ?? isActive) ? 'hidden' :
                                                        'fill-orange-500'">
                                                    </x-svg-icon>
                                                </div>
                                            </template>
                                            <span class="ml-1 text-xl font-semibold" x-text="rate"></span>
                                            <input id="rate" name="rate" type="number" x-ref="rateValue"
                                                x-bind:value="rate" hidden>
                                            <x-input-error :messages="$errors->get('rate')"></x-input-error>
                                        </div>

                                        <div
                                            class="mt-2 mb-4 w-full rounded-lg border border-gray-200 bg-gray-50 dark:border-gray-600 dark:bg-gray-700">
                                            <div class="rounded-t-lg bg-white px-1 py-2 dark:bg-gray-800">
                                                <textarea class="text-dark-blue w-full border-0 bg-white px-1 text-sm outline-none focus:ring-0" id="comment"
                                                    name="comment" rows="4" placeholder="Write a comment..." required>{{ $rate->comment }}</textarea>
                                            </div>
                                            <div
                                                class="flex items-center justify-end gap-1 border-t px-3 py-2 dark:border-gray-600">
                                                <button
                                                    class="inline-flex items-center rounded-lg bg-blue-700 py-2.5 px-4 text-center text-xs font-medium text-white hover:bg-blue-800 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900"
                                                    type="submit">
                                                    Chỉnh sửa
                                                </button>
                                                <div class="inline-flex cursor-pointer items-center rounded-lg bg-red-400 py-2.5 px-4 text-center text-xs font-medium text-white hover:bg-red-500 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900"
                                                    @click="canEdit = false">
                                                    Huỷ
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </template>
                                <!-- Đánh giá của bạn -->
                                <div class="mb-2 text-xl font-semibold">Cảm ơn bạn đã đánh giá</div>
                                <x-preview :rate="$rate">
                                    <x-slot name="menu">
                                        <x-dropdown width="w-36">
                                            <x-slot name="trigger">
                                                <div class="flex cursor-pointer items-center hover:bg-gray-50">
                                                    <x-svg-icon class="fill-dark-blue" name="ellipsis-vertical">
                                                    </x-svg-icon>
                                                </div>
                                            </x-slot>
                                            <x-slot name="content">
                                                <x-dropdown-link class="cursor-pointer" @click="canEdit = true">Chỉnh
                                                    sửa</x-dropdown-link>
                                                <form action="{{ route('rates.destroy', $rate) }}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <x-dropdown-link class="cursor-pointer"
                                                        onclick="event.preventDefault();this.closest('form').submit()">
                                                        Xoá</x-dropdown-link>
                                                </form>
                                            </x-slot>
                                        </x-dropdown>
                                    </x-slot>
                                </x-preview>
                            </div>
                        @else
                            @can('createRate', $room)
                                <form class="mt-8" method="POST" action="{{ route('rates.store', $room) }}">
                                    @csrf
                                    <div class="flex items-center gap-1" x-data="{ rate: 0, rateHover: 0 }">
                                        <template x-for="i in 5">
                                            <div x-data="{
                                                get isActive() { return this.iactive <= rate },
                                                get isHover() { return this.ihover <= rateHover },
                                                iactive: i,
                                                ihover: i
                                            }" @mouseenter="rateHover = ihover"
                                                @mouseleave="rateHover = rate"
                                                @click="rate = rate == iactive ? 0 : iactive; $refs.rateValue.value=rate">
                                                <x-svg-icon name="star"
                                                    x-bind:class="(isHover ? true : null ?? isActive) ? 'fill-orange-500' : 'hidden'">
                                                </x-svg-icon>
                                                <x-svg-icon name="solid-star"
                                                    x-bind:class="(isHover ? true : null ?? isActive) ? 'hidden' : 'fill-orange-500'">
                                                </x-svg-icon>
                                            </div>
                                        </template>
                                        <span class="ml-1 text-xl font-semibold" x-text="rate"></span>
                                        <input id="rate" name="rate" type="number" x-ref="rateValue"
                                            x-bind:value="rate" hidden>
                                        <x-input-error :messages="$errors->get('rate')"></x-input-error>
                                    </div>

                                    <div
                                        class="mt-2 mb-4 w-full rounded-lg border border-gray-200 bg-gray-50 dark:border-gray-600 dark:bg-gray-700">
                                        <div class="rounded-t-lg bg-white px-1 py-2 dark:bg-gray-800">
                                            <textarea class="text-dark-blue w-full border-0 bg-white px-1 text-sm outline-none focus:ring-0" id="comment"
                                                name="comment" rows="4" placeholder="Write a comment..." required></textarea>
                                        </div>
                                        <div class="flex items-center justify-end border-t px-3 py-2 dark:border-gray-600">
                                            <button
                                                class="inline-flex items-center rounded-lg bg-blue-700 py-2.5 px-4 text-center text-xs font-medium text-white hover:bg-blue-800 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900"
                                                type="submit">
                                                Đánh giá
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            @endcan
                        @endif
                        <!-- Đánh giá khác -->
                        <div class="mt-6">
                            <div class="text-xl font-semibold">Danh sách đánh giá</div>
                            <div class="mb-2">{{ $rates->links() }}</div>
                            <div class="flex flex-col gap-2">
                                @foreach ($rates as $rate)
                                    @if ($rate->user_id != Auth::user()?->rate?->user_id)
                                        <x-preview :rate="$rate"></x-preview>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </template>
        </div>
    </div>
</x-app>
