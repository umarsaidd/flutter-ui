<?php

namespace App\Http\Controllers;

use App\Models\ApiFurniture;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index()
    {
        $datas = ApiFurniture::all();
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil ditampilkan',
            'status_code' => 200,
            'data' => $datas,
            'total' => count($datas)
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validatedData =  $request->validate([
                'title' => 'required',
                'harga' => 'required',
                'deskripsi' => 'required',
                'stock' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($request->image) {
                $validatedData['image'] = $request->image->store('images', 'public');
            }

            $api = ApiFurniture::create($validatedData);

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil ditambahkan',
                'status_code' => 200,
                'data' => $api,
                'next' => [
                    'pagination' => '',
                    'url' => ''
                ]
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'status_code' => 422,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Mengembalikan respons error umum untuk kesalahan lainnya
            return response()->json([
                'status' => 'error',
                'status_code' => 500,
                'message' => 'Internal server error',
                'errors' => $e->getMessage()
            ], 500);
        }
    }
}
