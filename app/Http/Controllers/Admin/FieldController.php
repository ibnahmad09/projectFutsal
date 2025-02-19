<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Field;
use App\Models\FieldImage;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    public function index()
    {
     $fields = Field::with('images')->paginate(10); // Ganti 10 dengan jumlah item per halaman yang diinginkan

        // Ambil data untuk grafik
        $fieldPerformanceData = [
            'labels' => $fields->pluck('name')->toArray(), // Mengambil nama lapangan dari database
            'data' => $fields->pluck('price_per_hour')->toArray() // Mengambil harga per jam dari database
        ];

        $fieldTypeData = [
            'labels' => ['Indoor', 'Outdoor'],
            'data' => [
                Field::where('type', 'indoor')->count(), // Menghitung jumlah lapangan indoor
                Field::where('type', 'outdoor')->count() // Menghitung jumlah lapangan outdoor
            ]
        ];

        return view('admin.field', compact('fields', 'fieldPerformanceData', 'fieldTypeData'));
    }

    public function create()
    {
        return view('admin.create-field'); // Ganti dengan view untuk menambah lapangan
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:indoor,outdoor',
            'description' => 'required|string',
            'price_per_hour' => 'required|numeric|min:0',
            'size' => 'required|string|max:50',
            'open_time' => 'required|date_format:H:i',
            'close_time' => 'required|date_format:H:i|after:open_time',
            'facilities' => 'sometimes|array',
            'facilities.*' => 'string|max:50',
            'status' => 'required|in:available,maintenance',
            'images' => 'required|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Convert facilities to JSON
        $validated['facilities'] = json_encode($request->facilities ?? []);

        // Create field
        $field = Field::create($validated);

        // Handle image upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('field_images', 'public');

                FieldImage::create([
                    'field_id' => $field->id,
                    'image_path' => $path
                ]);
            }
        }

        return redirect()->route('admin.fields.index')
                         ->with('success', 'Field created successfully!');
    }

    public function edit(Field $field)
    {
        return view('admin.edit-field', compact('field')); // Ganti dengan view untuk mengedit lapangan
    }

    public function update(Request $request, Field $field)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:indoor,outdoor',
            'description' => 'required|string',
            'price_per_hour' => 'required|numeric|min:0',
            'size' => 'required|string|max:50',
            'open_time' => 'required|date_format:H:i',
            'close_time' => 'required|date_format:H:i|after:open_time',
            'facilities' => 'sometimes|array',
            'facilities.*' => 'string|max:50',
            'status' => 'required|in:available,maintenance',
            'images' => 'sometimes|array|max:5',
           'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Convert facilities to JSON
        $validated['facilities'] = json_encode($request->facilities ?? []);

        // Update data field
        $field->update($validated);
         // Handle new image upload
          if ($request->hasFile('images')) {
        // Delete existing images (optional)
        // $field->images()->delete();

            foreach ($request->file('images') as $image) {
                $path = $image->store('field_images', 'public');

                FieldImage::create([
                    'field_id' => $field->id,
                    'image_path' => $path
                ]);
            }
        }

        return redirect()->route('admin.fields.index')->with('success', 'Lapangan berhasil diperbarui.');
    }

    public function destroy(Field $field)
    {
        $field->delete(); // Hapus lapangan

        return redirect()->route('admin.fields.index')->with('success', 'Lapangan berhasil dihapus.');
    }
}
