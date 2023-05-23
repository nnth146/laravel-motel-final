<div class="h-20 bg-white px-[10%] md:px-[20%]">
    <div class="flex h-full justify-between">
        <div class="flex items-center gap-6">
            <p class="text-dark-blue block text-3xl font-semibold">Laravel Motel</p>
            <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">Trang chủ</x-nav-link>
        </div>
        @if (Auth::user())
            @php
                $user = Auth::user();
                if (!$user->avatar) {
                    $avatar = Vite::asset('resources/images/user.png');
                } else {
                    $avatar = Vite::asset('storage/app/' . $user->avatar->src);
                }
            @endphp
            <div class="flex items-center">
                <x-dropdown>
                    <x-slot name="trigger">
                        <div class="text-dark-blue flex cursor-pointer items-center gap-2 text-xl">
                            <img class="h-8 w-8 rounded-full"
                                src="{{ $avatar }}" alt="avatar">
                            <p>{{ Auth::user()->email }}</p>
                        </div>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link href="{{ route('users.edit') }}">Thông tin cá nhân
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();">Đăng xuất
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        @else
            <div class="flex items-center">
                <a class="bg-navy-blue block rounded-md p-2 text-lg font-semibold text-white"
                    href="{{ route('login') }}">Đăng nhập</a>
                <a class="text-dark-blue block rounded-md p-2 text-lg font-semibold" href="{{ route('register') }}">Đăng
                    ký</a>
            </div>
        @endif
    </div>
</div>
