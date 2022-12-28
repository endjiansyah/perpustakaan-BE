<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    function index()
    {
        $kategori = Kategori::query()->get();

        return response()->json([
            "status" => true,
            "message" => "list kategori buku",
            "data" => $kategori
        ]);
    }

    function show($id)
    {
        $kategori = Kategori::query()->where("id", $id)->first();
        if (!isset($kategori)) {
            return response()->json([
                "status" => false,
                "message" => "luru nopo mas?",
                "data" => null
            ]);
        }
        return response()->json([
            "status" => true,
            "message" => "nyoh",
            "data" => $kategori
        ]);
    }

    function store(Request $request)
    {
        $payload = $request->all();
        if (!isset($payload['nama_kategori'])) {
            return response()->json([
                "status" => false,
                "message" => "kasih nama_kategori dong",
                "data" => null
            ]);
        }

        if ($request->file("logo")) {
            $file = $request->file("logo");
            $filename = $file->hashName();
            $file->move("foto", $filename);
            $path = $request->getSchemeAndHttpHost() . "/foto/" . $filename;
            $payload['logo'] =  $path;
        }
        $kategori = Kategori::query()->create($payload);
        return response()->json([
            "status" => true,
            "message" => "data tersimpan",
            "data" => $kategori
        ]);
    }

    function update(Request $request, $id)
    {
        $kategori = Kategori::query()->where("id", $id)->first();
        if (!isset($kategori)) {
            return response()->json([
                "status" => false,
                "message" => "luru nopo mas?",
                "data" => null
            ]);
        }

        $payload = $request->all();

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = $file->hashName();
            $file->move('foto', $filename);
            $path = $request->getSchemeAndHttpHost() . '/foto/' . $filename;
            $payload['logo'] = $path;

            //file lama
            $lokasilogo = str_replace($request->getSchemeAndHttpHost(), '', $kategori->logo);
            $logo = public_path($lokasilogo);
            unlink($logo);
        }

        $kategori->fill($payload);
        $kategori->save();

        return response()->json([
            "status" => true,
            "message" => "perubahan data tersimpan",
            "data" => $kategori
        ]);
    }

    function destroy(Request $request, $id)
    {
        $kategori = Kategori::query()->where("id", $id)->first();
        if (!isset($kategori)) {
            return response()->json([
                "status" => false,
                "message" => "luru nopo mas?",
                "data" => null
            ]);
        }

        if ($kategori->logo != '') {
            $lokasigambar = str_replace($request->getSchemeAndHttpHost(), '', $kategori->logo);
            $gambar = public_path($lokasigambar);
            unlink($gambar);
        }
        $kategori->delete();

        return response()->json([
            "status" => true,
            "message" => "Data Terhapus",
            "data" => $kategori
        ]);
    }
}
