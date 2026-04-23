<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use ZipArchive;

class MejaController extends Controller
{
    public function index()
    {
        return view('meja.index', [
            'pageTitle' => 'Manajemen Meja'
        ]);
    }

    public function data(Request $request)
    {
        try {
            $mejas = Meja::latest()->where('status', $request->status)->get();

            return response()->json([
                'data' => $mejas
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengambil data'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_meja' => 'required|max:100|unique:mejas,nama_meja',
            'qrcode_base64' => 'required',
            'slug' => 'required|unique:mejas,slug'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            $image = $request->qrcode_base64;

            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);

            $fileName = 'qrcode_meja/' . $request->slug . '.png';

            Storage::disk('public')->put($fileName, base64_decode($image));

            $meja = Meja::create([
                'nama_meja' => $request->nama_meja,
                'qrcode'    => $fileName,
                'slug'      => $request->slug
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $meja = Meja::findOrFail($id);

            return response()->json($meja);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $meja = Meja::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'edit_nama_meja' => 'required|max:100|unique:mejas,nama_meja,' . $id,
            'edit_qrcode_base64' => 'required',
            'slug' => 'required|unique:mejas,slug,' . $id
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            $fotoPath = $meja->qrcode;

            if ($request->edit_qrcode_base64) {
                if ($meja->qrcode && Storage::disk('public')->exists($meja->qrcode)) {
                    Storage::disk('public')->delete($meja->qrcode);
                }

                $image = $request->edit_qrcode_base64;
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace(' ', '+', $image);

                $fileName = 'qrcode_meja/' . $request->slug . '.png';

                Storage::disk('public')->put($fileName, base64_decode($image));

                $fotoPath = $fileName;
            }

            $meja->update([
                'nama_meja' => $request->edit_nama_meja,
                'qrcode'    => $fotoPath,
                'slug'      => $request->slug
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
            $meja = Meja::findOrFail($id);
            $meja->status = false;
            $meja->save();

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
            $meja = Meja::findOrFail($id);
            $meja->status = true;
            $meja->save();

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

    public function destroy($id)
    {
        try {
            $meja = Meja::findOrFail($id);

            if ($meja->qrcode && Storage::disk('public')->exists($meja->qrcode)) {
                Storage::disk('public')->delete($meja->qrcode);
            }

            $meja->delete();

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

    public function download()
    {
        try {
            $mejas = Meja::whereNotNull('qrcode')->get();

            if ($mejas->isEmpty()) {
                return back()->with('error', 'Tidak ada QR Code untuk didownload');
            }

            $fileName = 'qrcode_meja_' . time() . '.zip';
            $zipPath = storage_path('app/public/' . $fileName);

            $zip = new ZipArchive;

            if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                throw new \Exception('Gagal membuat file ZIP');
            }

            foreach ($mejas as $meja) {
                $filePath = storage_path('app/public/' . $meja->qrcode);

                if (file_exists($filePath)) {
                    $zip->addFile($filePath, $meja->nama_meja . '.png');
                }
            }

            $zip->close();

            if (!file_exists($zipPath)) {
                throw new \Exception('ZIP tidak ditemukan');
            }
            
            return response()->download($zipPath)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal download QR Code: ' . $e->getMessage());
        }
    }
}
