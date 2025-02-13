@extends('layouts.admin')

@section('title', 'Admin Cyber Dashboard - FUTSALDESA')

@section('content')


<!-- Add Field Content -->
 <main class="p-6">
    <div class="max-w-4xl mx-auto">
        <div class="hologram-form rounded-xl p-8">
            <!-- Header -->
            <div class="mb-8 border-b border-green-900 pb-4">
                <h1 class="text-3xl font-bold neon-text flex items-center">
                    <i class='bx bx-plus-circle mr-2'></i>
                    Add New Field
                </h1>
                <p class="text-green-400 mt-2">Fill in the field details below</p>
            </div>

            <form method="POST" action="{{ route('admin.fields.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Field Name -->
                <div class="mb-4">
                    <label for="name" class="block text-green-400 mb-2">Field Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
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
                        <option value="">Select Type</option>
                        <option value="indoor" {{ old('type') == 'indoor' ? 'selected' : '' }}>Indoor</option>
                        <option value="outdoor" {{ old('type') == 'outdoor' ? 'selected' : '' }}>Outdoor</option>
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
                              required>{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Price and Size -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label for="price_per_hour" class="block text-green-400 mb-2">Price/Hour (Rp) *</label>
                        <input type="number" id="price_per_hour" name="price_per_hour" value="{{ old('price_per_hour') }}"
                               class="w-full bg-gray-800 border border-gray-700 rounded-lg p-3 input-glow focus:outline-none"
                               required>
                        @error('price_per_hour')
                            <span class="text-red-400 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="size" class="block text-green-400 mb-2">Field Size *</label>
                        <input type="text" id="size" name="size" value="{{ old('size') }}"
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
                        <input type="time" id="open_time" name="open_time" value="{{ old('open_time') }}"
                               class="w-full bg-gray-800 border border-gray-700 rounded-lg p-3 input-glow focus:outline-none"
                               required>
                        @error('open_time')
                            <span class="text-red-400 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="close_time" class="block text-green-400 mb-2">Closing Time *</label>
                        <input type="time" id="close_time" name="close_time" value="{{ old('close_time') }}"
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
                                       {{ in_array($facility, old('facilities', [])) ? 'checked' : '' }}
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
                        <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    </select>
                    @error('status')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Images Upload -->
                <div class="mb-6">
                    <label class="block text-green-400 mb-2">Field Images (Max 5)</label>
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

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.fields.index') }}"
                       class="px-6 py-2 border border-gray-700 rounded-lg hover:bg-gray-800">
                        Cancel
                    </a>
                    <button type="submit"
                            class="bg-green-600 hover:bg-green-700 px-6 py-2 rounded-lg flex items-center">
                        <i class='bx bx-save mr-2'></i>
                        Save Field
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>
</div>
</div>

@endsection
