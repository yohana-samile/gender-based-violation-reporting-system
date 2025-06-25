<div>
    <div class="mb-4 flex items-start space-x-8">
        <div class="w-1/2">
            <h2 class="text-xl font-bold mb-4 text-gray-800">{{ __('Profile information') }}</h2>
            <p>{{ __('Profile information note') }}</p>

            @if ($success)
                <div class="mt-4 p-2 bg-green-100 text-green-800 rounded">
                    {{ __('Profile information update success') }}
                </div>
            @endif
        </div>

        <div class="w-1/2">
            <form wire:submit.prevent="updateProfileInformation">
                <!-- Profile Photo -->
                <div x-data="{ photoName: null, photoPreview: null }" class="col-span-6 sm:col-span-4">
                    <input type="file" id="photo" class="hidden"
                           wire:model.live="photo"
                           x-ref="photo"
                           x-on:change="
                                photoName = $refs.photo.files[0].name;
                                const reader = new FileReader();
                                reader.onload = (e) => {
                                    photoPreview = e.target.result;
                                };
                                reader.readAsDataURL($refs.photo.files[0]);
                            " />

                    <label for="photo" class="block font-medium text-sm text-gray-700">{{__('Photo')}}</label>
                    <div class="mt-2" x-show="!photoPreview">
                        @if(user()->profile_photo_path)
                            <img src="{{ user()->profile_photo_url }}" alt="{{ user()->name }}" class="rounded-full w-20 h-20 object-cover">
                        @else
                            <div class="flex items-center justify-center w-8 h-8 bg-gray-500 text-white rounded-full overflow-hidden">
                                <span>{{ initials() }}</span>
                            </div>
                            <p class="text-yellow-500"> {{__('No photo uploaded')}}</p>
                        @endif
                    </div>

                    <div class="mt-2" x-show="photoPreview" style="display: none;">
                        <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                              x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                        </span>
                    </div>

                    <button type="button" class="mt-2 bg-gray-500 text-white px-4 py-2 rounded" x-on:click.prevent="$refs.photo.click()">
                        {{ __('Select new photo') }}
                    </button>

                    @if (user()->profile_photo_path)
                        <button type="button" class="mt-2 bg-red-600 text-white px-4 py-2 rounded" wire:click="deleteProfilePhoto">
                            {{ __('Remove photo') }}
                        </button>
                    @endif

                    <x-input-error for="photo" class="mt-2" />
                </div>

                <!-- Name -->
                <div class="col-span-6 sm:col-span-4">
                    <label for="name" class="block font-medium text-sm text-gray-700">{{__('Name')}}</label>
                    <input id="name" type="text" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 bg-white text-black rounded-md shadow-sm"
                           wire:model="state.name" required autocomplete="name" />
                    <x-input-error for="name" class="mt-2" />
                </div>

                <!-- Email -->
                <div class="col-span-6 sm:col-span-4">
                    <label for="email" class="block font-medium text-sm text-gray-700">{{__('Email')}}</label>
                    <input id="email" type="email" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 bg-white text-black rounded-md shadow-sm"
                           wire:model="state.email" required autocomplete="email" />
                    <x-input-error for="email" class="mt-2" />

                    @if (user()->email_verified_at === null)
                        <p class="text-sm mt-2">
                            {{ __('Email unverified') }}
                            <button type="button" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md" wire:click.prevent="sendEmailVerification">
                                {{ __('Resend verification email') }}
                            </button>
                        </p>

                        @if ($this->verificationLinkSent)
                            <p class="mt-2 font-medium text-sm text-green-600">
                                {{ __('New link sent') }}
                            </p>
                        @endif
                    @endif
                </div>

                <div class="flex justify-end mt-4">
                    <button type="submit" class="bg-indigo-500 text-white px-6 py-2 rounded-md shadow hover:bg-indigo-600">
                        {{ __('action crud save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
