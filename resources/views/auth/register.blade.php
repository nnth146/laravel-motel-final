<x-guest>
    <div class="flex h-[80%] items-center justify-center">
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div
                class="border-b-blue-336B87 flex w-[90vw] flex-col gap-3 rounded-md border-2 border-solid bg-white p-8 shadow-md sm:w-[70vw] lg:w-[50vw] xl:w-[40vw] 2xl:w-[30vw]">
                <p class="border-blue-336B87 text-dark-blue border-b-2 border-solid pb-1 text-2xl font-semibold">
                    Đăng ký</p>
                <div>
                    <x-input-label for="name">Họ và tên</x-input-label>
                    <x-input-text id="name" name="name" placeholder="Nguyen Nhu Tuan Hung" :value="old('name')">
                    </x-input-text>
                    <x-input-error :messages="$errors->get('name')"></x-input-error>
                </div>
                <div>
                    <x-input-label for="phone">Số điện thoại</x-input-label>
                    <x-input-text id="phone" name="phone" placeholder="03xxxxxxxxx" :value="old('phone')">
                    </x-input-text>
                    <x-input-error :messages="$errors->get('phone')"></x-input-error>
                </div>
                <div>
                    <x-input-label for="email">Email</x-input-label>
                    <x-input-text id="email" name="email" placeholder="ictu@gmail.com" :value="old('email')">
                    </x-input-text>
                    <x-input-error :messages="$errors->get('email')"></x-input-error>
                </div>
                <div>
                    <div class="relative" x-data="{ toggle: false }">
                        <x-input-label for="password">Mật khẩu</x-input-label>
                        <x-input-text class="pr-12" id="password" name="password" placeholder="******************"
                            x-bind:type="toggle ? 'text' : 'password'"></x-input-text>

                        <label
                            class="bg-dark-blue absolute right-2 bottom-1.5 z-10 cursor-pointer rounded-md px-2 py-1 text-center shadow-sm"
                            for="toggle-password">
                            <x-svg-icon class="fill-white" name="eye"></x-svg-icon>
                        </label>
                        <input id="toggle-password" name="toggle-password" type="checkbox" x-model="toggle" hidden>
                    </div>
                    <x-input-error :messages="$errors->get('password')"></x-input-error>
                </div>

                <div class="relative" x-data="{ toggle: false }">
                    <x-input-label for="password_confirmation">Xác nhận mật khẩu</x-input-label>
                    <x-input-text class="pr-12" id="password_confirmation" name="password_confirmation"
                        placeholder="******************" x-bind:type="toggle ? 'text' : 'password'"></x-input-text>
                    <label
                        class="bg-dark-blue absolute right-2 bottom-1.5 z-10 cursor-pointer rounded-md px-2 py-1 text-center shadow-sm"
                        for="toggle-password_confirmation">
                        <x-svg-icon class="fill-white" name="eye"></x-svg-icon>
                    </label>
                    <input id="toggle-password_confirmation" name="toggle-password_confirmation" type="checkbox"
                        x-model="toggle" hidden>
                </div>
                <input class="bg-dark-blue mt-1 cursor-pointer rounded-md p-2 text-center text-xl text-white"
                    type="submit" value="Đăng ký"></a>
            </div>
        </form>
    </div>
</x-guest>
