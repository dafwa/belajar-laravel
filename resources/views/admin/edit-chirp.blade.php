<x-layout>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Edit Chirp</h1>
            <p class="mt-2 text-gray-600">Editing chirp by {{ $chirp->user->name }}</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('admin.chirps.update', $chirp) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                        Message
                    </label>
                    <textarea 
                        name="message" 
                        id="message" 
                        rows="3"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required
                    >{{ old('message', $chirp->message) }}</textarea>
                    @error('message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <a href="{{ route('admin.chirps') }}" class="text-gray-600 hover:text-gray-900">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Update Chirp
                    </button>
                </div>
            </form>
        </div>

        <div class="mt-6 bg-gray-50 rounded-lg p-4">
            <p class="text-sm text-gray-600">
                <strong>Original author:</strong> {{ $chirp->user->name }} ({{ $chirp->user->email }})
            </p>
            <p class="text-sm text-gray-600 mt-1">
                <strong>Created:</strong> {{ $chirp->created_at->format('M d, Y g:i A') }}
            </p>
            @if($chirp->created_at != $chirp->updated_at)
                <p class="text-sm text-gray-600 mt-1">
                    <strong>Last updated:</strong> {{ $chirp->updated_at->format('M d, Y g:i A') }}
                </p>
            @endif
        </div>
    </div>
</x-layout>