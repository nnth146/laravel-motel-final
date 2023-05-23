<x-app>
    <div class="mt-3 px-[5%] md:px-[10%] xl:px-[15%] 2xl:px-[30%]">
        <div class="mx-auto mt-4 grid w-[90%] grid-cols-[30%_1fr] grid-rows-1 rounded-md bg-white shadow-md">
            <!-- Avatar and email -->
            <div class="flex flex-col items-center justify-center gap-2 border-r-2 border-solid border-gray-100 p-2"
                x-data="imgPreview">
                @csrf
                @method('patch')
                @php
                    $user = Auth::user();
                    if (!$user->avatar) {
                        $avatar = Vite::asset('resources/images/user.png');
                    } else {
                        $avatar = Vite::asset('storage/app/' . $user->avatar->src);
                    }
                @endphp
                <div class="flex flex-col items-center justify-center">
                    <x-dropdown width="w-32">
                        <x-slot name="trigger">
                            <div class="group relative h-28 w-28 rounded-full" for="avatar">
                                <img class="h-full w-full rounded-full" src="{{ $avatar }}" alt="image"
                                    x-bind:class="src != null && 'hidden'">
                                <img class="h-full w-full rounded-full" x-bind:src="src"
                                    x-bind:class="src != null || 'hidden'">
                                <div
                                    class="absolute top-0 left-0 hidden h-full w-full cursor-pointer items-center justify-center bg-gray-100 bg-opacity-20 group-hover:flex">
                                </div>
                            </div>
                        </x-slot>
                        <x-slot name="content">
                            <div class="flex flex-col gap-1">
                                <label class="text-dark-blue block cursor-pointer px-2 py-1 hover:bg-gray-50"
                                    for="avatar">
                                    Đổi avatar
                                </label>
                                <form action="{{ route('avatars.destroy', $user->avatar) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button
                                        class="text-dark-blue block w-full px-2 py-1 text-left hover:bg-gray-50 disabled:text-gray-200"
                                        @disabled(!$user->avatar)>Xoá avatar</button>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>

                    <form action="{{ route('avatars.update', $user->avatar) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <input id="avatar" name="avatar" type="file" x-ref="avatar" hidden @change="previewFile"
                            accept=".jpg, .jpeg, .png">
                        <template x-if="src != null">
                            <div class="mt-2">
                                <button class="bg-dark-blue rounded-md py-1 px-2 font-semibold text-white"
                                    type="submit">Lưu</button>
                                <button class="rounded-md bg-red-400 py-1 px-2 font-semibold text-white"
                                    @click="src = null">Huỷ</button>
                            </div>
                        </template>
                    </form>
                </div>
            </div>
            <!--  -->
            <form action="{{ route('users.update') }}" method="POST">
                @csrf
                @method('patch')
                <div class="flex flex-col gap-2 p-4" x-data="editProfile">
                    <!-- Email -->
                    <div>
                        <x-input-label for="email">Email</x-input-label>
                        <x-input-text id="email" name="email" :value="$user->email" readonly
                            x-effect="onCanEditChange" @dblclick="edit"></x-input-text>
                        <x-input-error :messages="$errors->get('email')"></x-input-error>
                    </div>
                    <!-- Name -->
                    <div>
                        <x-input-label for="name">Tên</x-input-label>
                        <x-input-text id="name" name="name" :value="$user->name" readonly
                            x-effect="onCanEditChange" @dblclick="edit"></x-input-text>
                        <x-input-error :messages="$errors->get('name')"></x-input-error>
                    </div>
                    <!-- Phone -->
                    <div>
                        <x-input-label for="phone">Số điện thoại</x-input-label>
                        <x-input-text id="phone" name="phone" value="0385328068" readonly
                            x-effect="onCanEditChange" @dblclick="edit" placeholder="0123456789">
                        </x-input-text>
                        <x-input-error :messages="$errors->get('phone')"></x-input-error>
                    </div>
                    <template x-if="canEdit">
                        <div class="flex items-center justify-end gap-2">
                            <button class="bg-dark-blue h-fit w-fit rounded-md px-2 py-2 text-white" type="submit">Lưu
                                thay
                                đổi</button>
                            <button class="h-fit w-fit rounded-md bg-red-400 px-2 py-2 text-white"
                                @click="cancelEdit">Huỷ</button>
                        </div>
                    </template>
                </div>
            </form>
        </div>

        <!-- Rooms -->
        <div class="mt-12" x-data>
            <div class="flex items-center justify-between rounded-md bg-white p-4 shadow-sm">
                <div class="text-dark-blue text-xl">
                    Danh sách phòng của bạn ({{ $user->rooms->count() }})
                </div>
                <div class="flex items-center">
                    <a class="bg-navy-blue block rounded-md px-2 py-2 text-white"
                        href="{{ route('rooms.create') }}">Thêm phòng</a>
                </div>
            </div>


            <div class="mt-3 grid grid-cols-2 px-2">
                <div class="text-dark-blue flex items-center gap-2">
                    <p class="text-xl font-semibold">Sắp xếp theo</p>
                    <form action="{{ route('users.edit') }}" method="GET">
                        <select class="rounded-sm px-2 py-1 shadow-sm" id="sort" name="sort"
                            onchange="this.form.submit()">
                            <option value="byName" @selected($sort === 'byName')>Tên Phòng</option>
                            <option value="byRate" @selected($sort === 'byRate')>Điểm số</option>
                            <option value="byPrice" @selected($sort === 'byPrice')>Giá thành</option>
                        </select>
                        @isset($search)
                            <input name="search" type="text" value="{{ $search }}" hidden>
                        @endisset
                    </form>
                </div>

                <form action="{{ route('users.edit') }}" method="GET">
                    <div class="flex h-full gap-1" x-data="liveSearchRooms">
                        <div class="relative w-full">
                            <input class="text-dark-blue w-full rounded-md px-3 py-2 shadow-sm" id="search"
                                name="search" type="text" value="{{ $search ?? '' }}" x-ref="search"
                                value="{{ $search ?? '' }}"
                                @focus="searching = true" @click.outside="searching = false" @keyup="liveSearch()"
                                placeholder="Nhập tên phòng muốn tìm">
                            <input name="sort" type="hidden" value="{{ $sort }}">

                            <div class="absolute z-50 mt-2 max-h-48 w-full overflow-y-auto rounded-md bg-white shadow-md"
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


            <div class="mt-2 mb-16 flex flex-col gap-2">
                @foreach ($rooms as $room)
                    <div
                        class="z-10 grid h-60 grid-cols-[30%_minmax(0px,1fr)_30%] grid-rows-1 overflow-hidden rounded-xl bg-white shadow-md">
                        <div class="relative">
                            @if ($room->images->count())
                                <img class="h-full w-full"
                                    src="{{ Vite::asset('storage/app/' . $room->images->first()->src) }}"
                                    alt="image">
                                <div
                                    class="absolute bottom-1 right-2 rounded-md bg-gray-500 bg-opacity-60 px-1 text-white">
                                    {{ $room->images->count() }}
                                </div>
                            @else
                                <div
                                    class="flex h-full w-full items-center justify-center border-r-2 border-solid border-gray-200">
                                    <x-svg-icon class="h-24 w-24" name="image"></x-svg-icon>
                                </div>
                                <div
                                    class="absolute bottom-1 right-2 rounded-md bg-gray-500 bg-opacity-60 px-1 text-white">
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
                                <p class="text-xl">{{ $user->phone }}</p>
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
                            <div
                                class="bg-dark-blue flex h-full flex-col items-center justify-center rounded-md text-center text-white">
                                <div class="text-2xl">
                                    {{ $room->price_text }} VNĐ
                                </div>
                                <div>
                                    1 tháng
                                </div>
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
                                    <a class="text-dark-blue mt-1 block rounded-md bg-white p-2 shadow-sm hover:bg-slate-100"
                                        href="{{ route('rooms.show', $room) }}">
                                        <x-svg-icon class="fill-dark-blue" name="eye"></x-svg-icon>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{ $rooms->links() }}
            </div>
        </div>
    </div>
</x-app>
