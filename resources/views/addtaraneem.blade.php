<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Taraneem') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('voeg taraneem toe') }}
                    </h2>
            
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __("Zet voor elke alinia een # en zet een @ achter elke regel") }}
                    </p>
                    <form action="/storetaraneem" method="POST">
                        @csrf
                        <x-input-label for="titel" value="Titel:"/>
                        <x-text-input id="titel" name="titel" type="text" class="mt-1 block w-full" />

                        <x-input-label for="lyrics" value="Text:"/>
                        <textarea id="lyrics" name="lyrics" class="mt-1 block w-full h-40 resize-y p-2" style="background-color: #121826; color: #FFFFFF; border: 1px solid #394150; border-radius: 5px;"
                        onfocus="this.style.borderColor = '#4d4adc'; this.style.borderWidth = '2px';"
                        onblur="this.style.borderColor = '#394150'; this.style.borderWidth = '1px';"  rows="12"></textarea>

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
