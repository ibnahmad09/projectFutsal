@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <div class="hologram-form rounded-xl p-8">
            <!-- Header -->
            <div class="mb-8 border-b border-green-900 pb-4">
                <h1 class="text-3xl font-bold neon-text flex items-center">
                    <i class='bx bx-edit mr-2'></i>
                    Edit Lapangan: {{ $field->name }}
                </h1>
                <p class="text-green-400 mt-2">Update field details</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('admin.fields.update', $field->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Field Name -->
                <div class="mb-4">
                    <label for="name" class="block text-green-400 mb-2">Nama Lapangan *</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $field->name) }}"
                           class="w-full bg-gray-800 border border-gray-700 rounded-lg p-3 input-glow focus:outline-none"
                           required>
                    @error('name')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Field Type -->
                <div class="mb-4">
                    <label for="type" class="block text-green-400 mb-2">Field Type *</label>
                    <select id="type" name="type" class="w-full bg-gray-800 border border-gray-700 rounded-lg p-3 input-glow focus:outline-none" required>
                        <option value="indoor" {{ old('type', $field->type) == 'indoor' ? 'selected' : '' }}>Indoor</option>
                        <option value="outdoor" {{ old('type', $field->type) == 'outdoor' ? 'selected' : '' }}>Outdoor</option>
                    </select>
                    @error('type')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="block text-green-400 mb-2">Description *</label>
                    <textarea id="description" name="description"
                              class="w-full bg-gray-800 border border-gray-700 rounded-lg p-3 input-glow focus:outline-none h-32"
                              required>{{ old('description', $field->description) }}</textarea>
                    @error('description')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Price and Size -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label for="price_per_hour" class="block text-green-400 mb-2">Price/Hour (Rp) *</label>
                        <input type="number" id="price_per_hour" name="price_per_hour"
                               value="{{ old('price_per_hour', $field->price_per_hour) }}"
                               class="w-full bg-gray-800 border border-gray-700 rounded-lg p-3 input-glow focus:outline-none"
                               required>
                        @error('price_per_hour')
                            <span class="text-red-400 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="size" class="block text-green-400 mb-2">Field Size *</label>
                        <input type="text" id="size" name="size" value="{{ old('size', $field->size) }}"
                               class="w-full bg-gray-800 border border-gray-700 rounded-lg p-3 input-glow focus:outline-none"
                               placeholder="e.g., 20m x 40m" required>
                        @error('size')
                            <span class="text-red-400 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Operating Hours -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label for="open_time" class="block text-green-400 mb-2">Opening Time *</label>
                        <input type="time" id="open_time" name="open_time"
                               value="{{ old('open_time', date('H:i', strtotime($field->open_time))) }}"
                               class="w-full bg-gray-800 border border-gray-700 rounded-lg p-3 input-glow focus:outline-none"
                               required>
                        @error('open_time')
                            <span class="text-red-400 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="close_time" class="block text-green-400 mb-2">Closing Time *</label>
                        <input type="time" id="close_time" name="close_time"
                               value="{{ old('close_time', date('H:i', strtotime($field->close_time))) }}"
                               class="w-full bg-gray-800 border border-gray-700 rounded-lg p-3 input-glow focus:outline-none"
                               required>
                        @error('close_time')
                            <span class="text-red-400 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Facilities -->
                <div class="mb-4">
                    <label class="block text-green-400 mb-2">Facilities</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach(['shower', 'parking', 'locker', 'wifi', 'cafe', 'ac'] as $facility)
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="facilities[]" value="{{ $facility }}"
                                    {{ in_array($facility, old('facilities', (array) $field->facilities)) ? 'checked' : '' }}
                                    class="form-checkbox text-green-400">
                                <span class="capitalize">{{ $facility }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('facilities')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label for="status" class="block text-green-400 mb-2">Status *</label>
                    <select id="status" name="status" class="w-full bg-gray-800 border border-gray-700 rounded-lg p-3 input-glow focus:outline-none" required>
                        <option value="available" {{ old('status', $field->status) == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="maintenance" {{ old('status', $field->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    </select>
                    @error('status')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Existing Images -->
                <div class="mb-4">
                    <label class="block text-green-400 mb-2">Current Images</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($field->images ?? [] as $image)
                            <div class="relative group">
                                <img src="{{ asset('storage/'.$image->image_path) }}"
                                     class="w-full h-24 object-cover rounded-lg">
                                <div class="absolute inset-0 bg-black bg-opacity-50 hidden group-hover:flex items-center justify-center">
                                    <button type="button"
                                            class="p-2 bg-red-600 rounded-lg hover:bg-red-700"
                                            onclick="confirmDeleteImage('{{ $image->id }}')">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- New Images Upload -->
                <div class="mb-6">
                    <label class="block text-green-400 mb-2">Add New Images (Max 5)</label>
                    <input type="file" name="images[]" multiple
                           class="w-full bg-gray-800 border border-gray-700 rounded-lg p-3 input-glow focus:outline-none"
                           accept="image/*">
                    @error('images')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                    @error('images.*')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-4 mt-8">
                    <a href="{{ route('admin.fields.index') }}"
                       class="px-6 py-2 border border-gray-700 rounded-lg hover:bg-gray-800">
                        Cancel
                    </a>
                    <button type="submit"
                            class="bg-green-600 hover:bg-green-700 px-6 py-2 rounded-lg flex items-center">
                        <i class='bx bx-save mr-2'></i>
                        Update Field
                    </button>
                </div>
            </form>

            <!-- Delete Image Form -->
            <form id="deleteImageForm" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</div>

<script>
function confirmDeleteImage(imageId) {
    if(confirm('Are you sure you want to delete this image?')) {
        const form = document.getElementById('deleteImageForm');
        form.action = `/admin/field-images/${imageId}`;
        form.submit();
    }
}
</script>
@endsection
