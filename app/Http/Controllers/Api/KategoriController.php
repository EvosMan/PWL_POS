<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KategoriModel;
use Illuminate\Http\Request;

class KategoriController extends Controller {
    public function index() {
        return KategoriModel::all();
    }

    public function show(KategoriModel $Kategori) {
        return $Kategori;
    }

    public function store(Request $request) {
        $Kategori = KategoriModel::create($request->all());
        return response()->json($Kategori, 201);
    }

    public function update(Request $request, KategoriModel $Kategori) {
        $Kategori->update($request->all());
        return KategoriModel::find($Kategori);
    }

    public function destroy(KategoriModel $Kategori) {
        $Kategori->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data terhapus'
        ]);
    }
}