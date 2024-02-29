<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Suggestions</title>
    <link rel="icon" type="image/png" href="{{ asset('images/mini-logo.png') }}">
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-color: #121826
        }
    </style>    
</head> 
<body>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Doe hier een suggestie') }}
                    </h2>
                    <h3>!! Stuur de volledige tekst uitgetypt, geen linkjes AUB !!</h3>
                    <form action="/storesuggestion" method="POST">
                        @csrf
                        <x-input-label for="titel" value="Titel:"/>
                        <x-text-input id="titel" name="titel" type="text" class="mt-1 block w-full" />

                        <x-input-label for="lyrics" value="Text:"/>
                        <textarea id="lyrics" name="lyrics" class="mt-1 block w-full h-40 resize-y p-2" style="background-color: #121826; color: #FFFFFF; border: 1px solid #394150; border-radius: 5px;"
                        onfocus="this.style.borderColor = '#4d4adc'; this.style.borderWidth = '2px';"
                        onblur="this.style.borderColor = '#394150'; this.style.borderWidth = '1px';"  rows="12"></textarea>

                        <div class="flex justify-end mt-4">
                            <x-primary-button class="ms-3">
                                Versturen
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>