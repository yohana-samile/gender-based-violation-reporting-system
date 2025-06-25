<div>
    <div class="mb-4 flex items-start space-x-8">
        <div class="w-1/2">
            <h2 class="text-xl font-bold mb-4 text-gray-800">{{ __('Update password') }}</h2>
            <p>{{ __('Update password desc') }}</p>

            @if ($success)
                <div class="mt-4 p-2 bg-green-100 text-green-800 rounded">
                    {{ __('Success update password') }}
                </div>
            @endif
        </div>

        <div class="w-1/2">
            <form wire:submit.prevent="updatePassword">
                <div class="mb-4">
                    <label for="current_password" class="block font-medium text-sm text-gray-700">Current Password</label>
                    <input type="password" id="current_password" wire:model.defer="current_password"
                           class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 bg-white text-black rounded-md shadow-sm">
                    @error('current_password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block font-medium text-sm text-gray-700">{{__('new password')}}</label>
                    <input type="password" id="password" wire:model.defer="password"
                           class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 bg-white text-black rounded-md shadow-sm">
                    @error('password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block font-medium text-sm text-gray-700">Confirm Password</label>
                    <input type="password" id="password_confirmation" wire:model.defer="password_confirmation"
                           class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 bg-white text-black rounded-md shadow-sm">
                    @error('password_confirmation') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded-md shadow hover:bg-indigo-600">
                        {{ __('action crud save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
