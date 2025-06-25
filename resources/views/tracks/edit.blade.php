<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Track bewerken') }}
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

                    <form action="{{ route('tracks.update', $track) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('POST')
                        <div>
                            <x-input-label for="title" :value="__('Titel')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" value="{{ old('title', $track->title) }}" required />
                        </div>
                        <div>
                            <x-input-label for="artist" :value="__('Artiest (optioneel)')" />
                            <x-text-input id="artist" name="artist" type="text" class="mt-1 block w-full" value="{{ old('artist', $track->artist) }}" />
                        </div>
                        <div class="flex justify-between">
                            <a href="{{ route('tracks.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                                Annuleren
                            </a>
                            <x-primary-button>
                                {{ __('Opslaan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
