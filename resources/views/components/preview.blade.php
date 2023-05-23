@props(['rate', 'menu'])

<div class="rounded-md border border-gray-200">
    <div class="border-b-2 border-solid border-gray-200 bg-gray-50 px-2 py-1">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="text-dark-blue flex cursor-pointer items-center gap-2">
                    @if ($rate->user->avatar)
                        <img class="h-10 w-10 rounded-full"
                            src="{{ Vite::asset('storage/app/' . $rate->user->avatar->src) }}" alt="avatar">
                    @else
                        <img class="h-10 w-10 rounded-full" src="{{ Vite::asset('resources/images/user.png') }}"
                            alt="avatar">
                    @endif
                    <div class="flex flex-col">
                        <div>
                            {{ $rate->user->email }}
                        </div>
                        <div>
                            {{ $rate->updated_at }}
                        </div>
                    </div>
                </div>
            </div>
            {{ $menu ?? null }}
        </div>
    </div>
    <div class="p-2">
        <div class="flex items-center gap-1" x-data="{ rate: {{ $rate->point }}, rateHover: 0 }">
            <template x-for="i in 5">
                <div x-data="{
                    get isActive() { return this.iactive <= rate },
                    get isHover() { return this.ihover <= rateHover },
                    iactive: i,
                    ihover: i
                }">
                    <x-svg-icon name="star"
                        x-bind:class="(isHover ? true : null ?? isActive) ? 'fill-orange-500' : 'hidden'">
                    </x-svg-icon>
                    <x-svg-icon name="solid-star"
                        x-bind:class="(isHover ? true : null ?? isActive) ? 'hidden' : 'fill-orange-500'">
                    </x-svg-icon>
                </div>
            </template>
            <span class="ml-1 text-xl font-semibold" x-text="rate"></span>
        </div>

        <div class="text-dark-blue">
            {{ $rate->comment }}
        </div>
    </div>
</div>
