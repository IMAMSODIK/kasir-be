<?php

namespace App\Http\Controllers;

use App\Models\KategoriMenu;
use App\Http\Requests\StoreKategoriMenuRequest;
use App\Http\Requests\UpdateKategoriMenuRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class KategoriMenuController extends Controller
{
    public function index()
    {
        return view('kategori_menu.index', [
            'pageTitle' => 'Kategori Menu'
        ]);
    }

    public function data(Request $request)
    {
        try {
            $kat = KategoriMenu::latest()->where('status', $request->status)->get();

            return response()->json([
                'data' => $kat
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengambil data ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|unique:kategori_menus,nama_kategori',
            'icon'  => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nama_kategori.required'  => 'Nama kategori wajib diisi',
            'nama_kategori.unique'   => 'Email sudah digunakan',
            'icon.required'     => 'File wajib diupload',
            'icon.image'     => 'File harus berupa gambar',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            $fotoPath = null;
            if ($request->hasFile('icon')) {
                $fotoPath = $request->file('icon')->store('kategori_menu', 'public');
            }

            $kat = KategoriMenu::create([
                'nama_kategori' => $request->nama_kategori,
                'icon' => $fotoPath
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data'
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $kat = KategoriMenu::findOrFail($id);

            return response()->json($kat);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $kat = KategoriMenu::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'edit_nama_kategori' => 'required|unique:kategori_menus,nama_kategori,' . $id,
            'edit_icon'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'edit_nama_kategori.required'  => 'Nama kategori wajib diisi',
            'edit_nama_kategori.unique'   => 'Email sudah digunakan',
            'edit_icon.image'     => 'File harus berupa gambar',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            $iconPath = $kat->icon;

            if ($request->hasFile('edit_icon')) {
                if ($kat->icon && Storage::disk('public')->exists($kat->icon)) {
                    Storage::disk('public')->delete($kat->icon);
                }

                $iconPath = $request->file('edit_icon')->store('kategori_menu', 'public');
            }

            $kat->update([
                'nama_kategori' => $request->edit_nama_kategori,
                'icon' => $iconPath
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diupdate'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal update data'
            ], 500);
        }
    }

    public function deactivate($id)
    {
        try {
            $kat = KategoriMenu::findOrFail($id);
            $kat->status = false;
            $kat->save();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data'
            ], 500);
        }
    }

    public function restore($id)
    {
        try {
            $kat = KategoriMenu::findOrFail($id);
            $kat->status = true;
            $kat->save();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dikembalikan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengembalikan data'
            ], 500);
        }
    }
}
