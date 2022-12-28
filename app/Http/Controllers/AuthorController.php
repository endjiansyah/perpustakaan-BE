<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    function index()
    {
        $author = Author::query()->get();

        return response()->json([
            "status" => true,
            "message" => "list author",
            "data" => $author
        ]);
    }

    function show($id)
    {
        $author = Author::query()->where("id", $id)->first();
        if (!isset($author)) {
            return response()->json([
                "status" => false,
                "message" => "luru nopo mas?",
                "data" => null
            ]);
        }

        return response()->json([
            "status" => true,
            "message" => "nyoh",
            "data" => $author
        ]);
    }

    function store(Request $request)
    {
        $payload = $request->all();
        if (!isset($payload['nama_author'])) {
            return response()->json([
                "status" => false,
                "message" => "siapa?",
                "data" => null
            ]);
        }

        if ($request->file("foto")) {
            $file = $request->file("foto");
            $filename = $file->hashName();
            $file->move("foto", $filename);
            $path = $request->getSchemeAndHttpHost() . "/foto/" . $filename;
            $payload['foto'] =  $path;
        }
        $author = Author::query()->create($payload);
        return response()->json([
            "status" => true,
            "message" => "data tersimpan",
            "data" => $author
        ]);
    }

    function update(Request $request, $id)
    {
        $author = Author::query()->where("id", $id)->first();
        if (!isset($author)) {
            return response()->json([
                "status" => false,
                "message" => "luru nopo mas?",
                "data" => null
            ]);
        }

        $payload = $request->all();

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = $file->hashName();
            $file->move('foto', $filename);
            $path = $request->getSchemeAndHttpHost() . '/foto/' . $filename;
            $payload['foto'] = $path;

            //file lama
            $lokasifoto = str_replace($request->getSchemeAndHttpHost(), '', $author->foto);
            $foto = public_path($lokasifoto);
            unlink($foto);
        }

        $author->fill($payload);
        $author->save();

        return response()->json([
            "status" => true,
            "message" => "perubahan data tersimpan",
            "data" => $author
        ]);
    }

    function destroy(Request $request, $id)
    {
        $author = Author::query()->where("id", $id)->first();
        if (!isset($author)) {
            return response()->json([
                "status" => false,
                "message" => "luru nopo mas?",
                "data" => null
            ]);
        }

        if ($author->foto != '') {
            $lokasigambar = str_replace($request->getSchemeAndHttpHost(), '', $author->foto);
            $gambar = public_path($lokasigambar);
            unlink($gambar);
        }
        $author->delete();

        return response()->json([
            "status" => true,
            "message" => "Data Terhapus",
            "data" => $author
        ]);
    }
}
