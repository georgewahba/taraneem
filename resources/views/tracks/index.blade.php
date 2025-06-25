<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Muziekbeheer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if(session('success'))
                        <div class="bg-green-100 text-green-700 p-2 rounded mb-4 dark:bg-green-900 dark:text-green-200">
                            {{ session('success') }}
                        </div>
                    @endif

                    <a href="{{ route('tracks.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
                        Nieuwe track toevoegen
                    </a>

                    <table class="w-full border-collapse border border-gray-300 mt-4">
                        <thead>
                            <tr>
                                <th class="py-2 px-3 bg-gray-200 border">#</th>
                                <th class="py-2 px-3 bg-gray-200 border">Titel</th>
                                <th class="py-2 px-3 bg-gray-200 border">Artiest</th>
                                <th class="py-2 px-3 bg-gray-200 border">Audio</th>
                                <th class="py-2 px-3 bg-gray-200 border">Acties</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tracks as $index => $track)
                                <tr>
                                    <td class="py-2 px-3 border">{{ $index + 1 }}</td>
                                    <td class="py-2 px-3 border">{{ $track->title }}</td>
                                    <td class="py-2 px-3 border">{{ $track->artist }}</td>
                                    <td class="py-2 px-3 border">
                                        <audio controls class="w-48">
                                            <source src="{{ asset('storage/' . $track->file) }}" type="audio/mpeg">
                                            Je browser ondersteunt geen audio.
                                        </audio>
                                    </td>
                                    <td class="py-2 px-3 border">
                                        <a href="{{ route('tracks.edit', $track) }}" style="color: #eab308;">Bewerken</a>
                                        <form method="POST" action="{{ route('tracks.destroy', $track) }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <a href="javascript:void(0);" style="color: #ef4444; margin-left: 8px;" onclick="if(confirm('Weet je zeker dat je wilt verwijderen?')) this.closest('form').submit();">Verwijderen</a>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-4 px-3 border text-center text-gray-500 dark:text-gray-400">
                                        Geen tracks gevonden.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
