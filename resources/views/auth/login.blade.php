<x-guest>
    <div class="flex h-[80%] items-center justify-center">
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div
                class="text-dark-blue border-b-blue-336B87 flex w-[600px] flex-col gap-3 rounded-md border-2 border-solid bg-white p-8 shadow-md">
                <p class="border-blue-336B87 border-b-2 border-solid pb-1 text-2xl font-semibold">
                    Đăng nhập</p>
                <div>
                    <x-input-label for="email">Tài khoản</x-input-label>
                    <x-input-text id="email" name="email" placeholder="ictu@gmail.com" :value="old('email')"></x-input-text>
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
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <input class="h-5 w-5" id="remember" name="remember" type="checkbox">
                        <p class="font-semibold">Ghi nhớ đăng nhập</p>
                    </div>
                    <a class="font-semibold" href="#" hidden>Quên mật khẩu?</a>
                </div>
                <input class="bg-dark-blue mt-1 cursor-pointer rounded-md p-2 text-center text-xl text-white"
                    type="submit" value="Đăng nhập"></a>
            </div>
        </form>
    </div>
</x-guest>
