<x-app>
    <div class="mt-8 px-[5%] md:px-[10%] xl:px-[15%] 2xl:px-[30%]">
        <div class="mt-3 grid grid-cols-2 px-2">
            <div class="text-dark-blue flex items-center gap-2">
                <p class="text-xl font-semibold">Sắp xếp theo</p>
                <form action="{{ route('home') }}" method="GET">
                    <select class="rounded-sm px-2 py-1 shadow-sm" id="sort" name="sort"
                        onchange="this.form.submit()">
                        <option value="byName" @selected($sort === 'byName')>Tên Phòng</option>
                        <option value="byRate" @selected($sort === 'byRate')>Điểm số</option>
                        <option value="byPrice" @selected($sort === 'byPrice')>Giá thành</option>
                    </select>
                    @isset($search)
                        <input type="text" name="search" hidden value="{{ $search }}">
                    @endisset
                </form>
            </div>

            <form action="{{ route('home') }}" method="GET">
                <div class="flex h-full gap-1" x-data="liveSearch">
                    <div class="relative w-full">
                        <input class="text-dark-blue w-full rounded-md px-3 py-2 shadow-sm" id="search"
                            name="search" type="text" value="{{ $search ?? '' }}" x-ref="search"
                            @focus="searching = true" @click.outside="searching = false" @keyup="liveSearch()"
                            placeholder="Nhập tên phòng muốn tìm">
                        <input name="sort" type="hidden" value="{{ $sort }}">

                        <div class="absolute z-50 mt-2 max-h-48 overflow-y-auto w-full rounded-md bg-white shadow-md"
                            x-show="searching">
                            <template x-if="$refs.search.value != '' & rooms.length < 1">
                                <div class="p-2">
                                    Không tìm thấy kết quả
                                </div>
                            </template>
                            <template x-if="rooms.length > 0">
                                <template x-for="room in rooms">
                                    <div class="flex flex-col">
                                        <button
                                            class="text-dark-blue block cursor-pointer p-2 text-left hover:bg-gray-100"
                                            x-text="room.name" @click="$refs.search.value = room.name;"></button>
                                    </div>
                                </template>
                            </template>
                        </div>
                    </div>
                    <button
                        class="bg-dark-blue flex h-full w-28 items-center justify-center rounded-md px-2 text-white shadow-sm">Tìm
                        kiếm</button>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-3 px-[5%] md:px-[10%] xl:px-[15%] 2xl:px-[30%]">
        <div class="flex flex-col gap-2">
            @foreach ($rooms as $room)
                <x-card :room="$room"></x-card>
            @endforeach
            {{ $rooms->links() }}
        </div>
    </div>
</x-app>
