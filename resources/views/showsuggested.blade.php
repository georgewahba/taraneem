<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Suggestion') }}: {{ $suggestion->titel }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <x-input-label for="titel" value="Title"/>
                <x-text-input id="titel" type="text" class="mt-1 block w-full" value="{{ $suggestion->titel }}" readonly />
                <x-input-label for="lyrics" value="Lyrics"/>
                <textarea id="lyrics" class="mt-1 block w-full resize-y rounded-md border-gray-300 dark:bg-gray-900 dark:text-gray-100" rows="12" readonly>{{ $suggestion->lyrics }}</textarea>
                <a href="{{ route('suggestedtaraneem') }}" class="inline-block mt-4 underline">Back to suggestions</a>
            </div>
        </div>
    </div>
</x-app-layout>
