<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Music administration') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 overflow-x-auto">

                    <a href="{{ route('tracks.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
                        Add a track
                    </a>

                    <table class="w-full border-collapse border border-gray-300 mt-4">
                        <thead>
                            <tr>
                                <th class="py-2 px-3 bg-gray-200 border">#</th>
                                <th class="py-2 px-3 bg-gray-200 border">Title</th>
                                <th class="py-2 px-3 bg-gray-200 border">Artist</th>
                                <th class="py-2 px-3 bg-gray-200 border">Audio</th>
                                <th class="py-2 px-3 bg-gray-200 border">Actions</th>
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
                                            <source src="{{ asset('storage/' . $track->file) }}">
                                            Your browser does not support audio playback.
                                        </audio>
                                    </td>
                                    <td class="py-2 px-3 border">
                                        <a href="{{ route('tracks.edit', $track) }}" style="color: #eab308;">Edit</a>
                                        <form method="POST" action="{{ route('tracks.destroy', $track) }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="color: #ef4444; margin-left: 8px;" onclick="return confirm('Delete this track?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-4 px-3 border text-center text-gray-500 dark:text-gray-400">
                                        No tracks found.
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
