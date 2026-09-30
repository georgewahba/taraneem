<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Suggestions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 overflow-x-auto">
                    <table class="w-full border-collapse border border-gray-300 mt-4">
                        <thead>
                            <tr>
                                <th class="py-2 px-3 bg-gray-200">Id</th>
                                <th class="py-2 px-3 bg-gray-200">Title</th>
                                <th class="py-2 px-3 bg-gray-200">Lyrics</th>
                                <th class="py-2 px-3 bg-gray-200">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach($suggestions as $index => $taraneem)
                            <tr>
                                <td class="py-2 px-3 border">{{ $index + 1 }}</td>
                                <td class="py-2 px-3 border">{{ $taraneem->titel }}</td>
                                <td class="py-2 px-3 border">{{ \Illuminate\Support\Str::limit($taraneem->lyrics, 50) }}</td>
                                <td class="py-2 px-3 border">
                                    <a href="{{ route('showsuggested', $taraneem) }}" style="color: blue;">Review</a>
                                    <form method="POST" action="{{ route('suggestion.destroy', $taraneem) }}" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="color: red; margin-left: 8px;" onclick="return confirm('Are you sure you want to delete this suggestion?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
