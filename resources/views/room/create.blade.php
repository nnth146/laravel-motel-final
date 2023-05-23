<x-app>
    <div class="mt-3 px-[5%] md:px-[10%] xl:px-[15%] 2xl:px-[30%]">
        <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div>
                <div class="text-dark-blue text-center text-xl font-semibold">
                    Thêm phòng mới
                </div>
                <!-- Room Information -->
                <div class="m-auto mt-4 flex w-[60%] flex-col gap-2 rounded-md bg-white px-12 py-8 shadow-md" x-data>
                    <!-- Name -->
                    <div>
                        <x-input-label for="name">Tên Phòng</x-input-label>
                        <x-input-text id="name" name="name" placeholder="Phòng 302"></x-input-text>
                        <x-input-error :messages="$errors->get('name')"></x-input-error>
                    </div>
                    <!-- Quantity -->
                    <div>
                        <x-input-label for="quantity">Số lượng người ở</x-input-label>
                        <x-input-text id="quantity" name="quantity" type="number" min="1" max="99"
                            placeholder="1"></x-input-text>
                        <x-input-error :messages="$errors->get('quantity')"></x-input-error>
                    </div>
                    <!-- Price -->
                    <div>
                        <x-input-label for="price">Giá phòng mỗi tháng (VND)</x-input-label>
                        <x-input-text id="price" name="price" x-mask:dynamic="$money($input, ',')"
                            placeholder="1.000.000"></x-input-text>
                        <x-input-error :messages="$errors->get('price')"></x-input-error>
                    </div>
                    <!-- Description -->
                    <div>
                        <x-input-label for="description">Mô tả</x-input-label>
                        <textarea
                        
                            class="border-dark-blue text-dark-blue focus:outline-dark-blue w-full resize-none rounded-md border-[1px] border-solid px-3 py-2"
                            id="description" name="description" placeholder="Phòng sạch sẽ rộng rãi"></textarea>
                        <x-input-error :messages="$errors->get('description')"></x-input-error>
                    </div>
                    <div class="flex items-center justify-end">
                        <button class="bg-dark-blue h-fit w-fit rounded-md px-2 py-2 text-white"
                            type="submit">Thêm</button>
                    </div>
                </div>

                <!-- Image -->
                <div x-data="multiImgPreview" class="mt-4">
                    <label
                        class="bg-dark-blue m-auto flex h-full w-fit cursor-pointer items-center justify-center gap-2 rounded-md px-1 py-2"
                        for="photos">
                        <div class="text-white">
                            Thêm ảnh
                        </div>
                        <x-svg-icon class="h-10 w-10 fill-white" name="image"></x-svg-icon>
                    </label>
                    <input id="photos" name="photos[]" type="file" accept=".jpg, .jpeg, .png"
                        @change="previewMultiFile;" hidden multiple>

                    <template x-if="images.length > 0">
                        <div
                            class="m-auto mt-2 flex flex-wrap items-center justify-start rounded-md bg-white px-1 py-1 shadow-md">
                            <template x-for="i in images.length">
                                <div class="my-1 w-1/5 px-1">
                                    <img class="rounded-md" alt="image" x-bind:src="images[i - 1]"
                                        x-bind:class="src != null && 'hidden'">
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
        </form>
    </div>
</x-app>
