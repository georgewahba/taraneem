<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Hymn') }}: {{ $taraneem->titel }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Edit hymn') }}
                    </h2>
            
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Separate slides with # and lines with @.') }}
                    </p>
                    <form action="{{ route('taraneem.update', $taraneem) }}" method="POST">
                        @csrf
                        <x-input-label for="titel" value="Title"/>
                        <x-text-input id="titel" name="titel" type="text" class="mt-1 block w-full" :value="old('titel', $taraneem->titel)" maxlength="255" required />
                        <x-input-error :messages="$errors->get('titel')" class="mt-2" />

                        <x-input-label for="lyrics" value="Lyrics"/>
                        <textarea id="lyrics" name="lyrics" class="mt-1 block w-full h-40 resize-y p-2 rounded-md border-gray-300 dark:bg-gray-900 dark:text-gray-100" rows="12" required>{{ old('lyrics', $taraneem->lyrics) }}</textarea>
                        <x-input-error :messages="$errors->get('lyrics')" class="mt-2" />

                        <div class="flex justify-end mt-4">
                            <x-primary-button class="ms-3">
                                Save
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
