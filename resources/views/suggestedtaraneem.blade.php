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
                                <td class="py-2 px-3 border">{{ substr($taraneem->lyrics, 0, 50) }}{{ strlen($taraneem->lyrics) > 50 ? '...' : '' }}</td>
                                <td class="py-2 px-3 border">
                                    <a href="showsuggested/{{ $taraneem->id }}" style="color: blue;">show</a>
                                    <a href="javascript:void(0);" style="color: red;" onclick="confirmDelete({{ $taraneem->id }});">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- JavaScript for confirmation dialog -->
    <script>
        function confirmDelete(itemId) {
            if (confirm('Are you sure you want to delete this item?')) {
                // The user confirmed, perform the delete action here
                // You can redirect to a delete route or send an AJAX request, depending on your application's structure
                window.location.href = "deletesuggested/" + itemId;
            }
        }
    </script>
</x-app-layout>
