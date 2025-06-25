<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Nieuwe track uploaden') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($errors->any())
                        <div class="bg-red-100 text-red-700 p-2 rounded mb-4 dark:bg-red-900 dark:text-red-200">
                            <ul class="list-disc pl-4">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('tracks.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <x-input-label for="title" :value="__('Titel')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" required />
                        </div>
                        <div>
                            <x-input-label for="artist" :value="__('Artiest (optioneel)')" />
                            <x-text-input id="artist" name="artist" type="text" class="mt-1 block w-full" />
                        </div>
                        <diav>
                            <x-input-label for="file" :value="__('MP3 bestand')" />
                            <input type="file" name="file" id="file" accept="audio/*" class="mt-1 block w-full border border-gray-300 dark:border-gray-700 rounded p-2 bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100" required />
                        </diav>
                        <div class="flex justify-end">
                            <x-primary-button>
                                {{ __('Uploaden') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
