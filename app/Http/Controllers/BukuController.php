<?php

namespace App\Http\Controllers;

use App\Models\Author; //gunakan / use Model Author
use App\Models\Buku; //gunakan / use Model Buku
use App\Models\Kategori; //gunakan / use Model Kategori
use App\Models\Rating; //gunakan / use Model Rating
use Illuminate\Http\Request; //agar bisa menjalankan Request

class BukuController extends Controller //class dari Controller (BukuController) dengan extends Controller utama
{
    function index()
    {
        $buku = Buku::query()->get(); // ambil semua data dari Model / table Buku (SELECT * FROM BUKU)

        return response()->json([
            "status" => true,
            "message" => "list buku",
            "data" => $buku
        ]);
    }

    function show($id)
    {
        $buku = Buku::query()->where("id", $id)->first(); //ambil data dari model Buku dimana id(dari model) = $id
        $author = Author::query()->where("id", $buku->author)->first(); // //ambil data dari model Author dimana id(dari model) = value dari $buku->author
        $kategori = Kategori::query()->where("id", $buku->kategori)->first(); // //ambil data dari model Kategori dimana id(dari model) = value dari $buku->kategori
        $rating = Rating::query()->where("id", $buku->rating_umur)->first(); // //ambil data dari model Rating dimana id(dari model) = value dari $buku->rating_umur
        if (!isset($buku)) { // jika tidak ada data yang ditemukan (jika kosong)
            return response()->json([ //return response dalam bentuk json
                "status" => false, //response.status
                "message" => "luru nopo mas?", // response.message
                "data" => null //response.data
            ]);
        }
        $buku->author = $author; // ubah value dari variable $buku->author dengan value dari $author (object)
        $buku->kategori = $kategori; // ubah value dari variable $buku->kategori dengan value dari $kategori (object)
        $buku->rating_umur = $rating; // ubah value dari variable $buku->rating_umur dengan value dari $rating (object)
        return response()->json([ //return response dalam bentuk json
            "status" => true, //response.status
            "message" => "nyoh", // response.message
            "data" => $buku //response.data berisi value dari $buku (object)
        ]);
    }

    function store(Request $request)
    {
        $payload = $request->all(); //tampung semua request ke $payload
        if (!isset($payload['judul'])) { // cek apakah tidak ada payload.judul?
            return response()->json([ // jika ya : return response dalam bentuk json
                "status" => false, // response.status = true
                "message" => "kasih judul dong", // response.message
                "data" => null //response.data
            ]);
        }

        if (!isset($payload['author'])) {
            return response()->json([
                "status" => false,
                "message" => "kasih author dong",
                "data" => null
            ]);
        }

        if (!isset($payload['kategori'])) {
            return response()->json([
                "status" => false,
                "message" => "kasih kategori dong",
                "data" => null
            ]);
        }

        if (!isset($payload['penerbit'])) {
            return response()->json([
                "status" => false,
                "message" => "kasih penerbit dong",
                "data" => null
            ]);
        }

        if (!isset($payload['tahun_terbit'])) {
            return response()->json([
                "status" => false,
                "message" => "kasih tahun terbit dong",
                "data" => null
            ]);
        }

        if (!isset($payload['kota_terbit'])) {
            return response()->json([
                "status" => false,
                "message" => "kasih tahun terbit dong",
                "data" => null
            ]);
        }

        if (!isset($payload['rating_umur'])) {
            return response()->json([
                "status" => false,
                "message" => "kasih rating umur dong",
                "data" => null
            ]);
        }

        if (!isset($payload['sampul'])) {
            return response()->json([
                "status" => false,
                "message" => "kasih sampul dong",
                "data" => null
            ]);
        }

        $file = $request->file("sampul"); // buat variable $file dengan value berisi file request.sampul
        $filename = $file->hashName(); // membuat variable $filename dengan value $file dalam bentuk hash (diubah menjadi hash)
        $file->move("foto", $filename); // move atau simpan file ke directory foto dengan nama file dari $filename
        $path = $request->getSchemeAndHttpHost() . "/foto/" . $filename; // buat variable $path yang berisi httphost + nama folder (/foto/) + nama file yang disimpan ===> ex: http://localhost:8000/foto/bwabwabwabwabwa.png
        $payload['sampul'] =  $path; // ubah value dari $payload['sampul'] menjadi value dari $path

        $buku = Buku::query()->create($payload); // simpan $payload ke database dengan jalankan query Create pada Model Buku (INSERT INTO buku VALUES $payload)
        return response()->json([ // return response dalam bentuk json
            "status" => true, // response.status
            "message" => "data tersimpan", // response.message
            "data" => $buku // response.data berisi value dari $buku
        ]);
    }

    function update(Request $request, $id)
    {
        $buku = Buku::query()->where("id", $id)->first(); // SELECT * FROM buku WHERE id = $id ===> dan ambil 1 data pertama
        if (!isset($buku)) { // jika tidak ada buku ($buku kosong)
            return response()->json([
                "status" => false,
                "message" => "luru nopo mas?",
                "data" => null
            ]);
        }

        $payload = $request->all();  //tampung semua request ke $payload

        if ($request->hasFile('sampul')) { // jika ada request sampul
            $file = $request->file('sampul');
            $filename = $file->hashName();
            $file->move('foto', $filename);
            $path = $request->getSchemeAndHttpHost() . '/foto/' . $filename;
            $payload['sampul'] = $path;

            //file lama
            $lokasisampul = str_replace($request->getSchemeAndHttpHost(), '', $buku->sampul);
            $sampul = public_path($lokasisampul);
            unlink($sampul); // file sampul
        }

        $buku->fill($payload);
        $buku->save();

        return response()->json([
            "status" => true,
            "message" => "perubahan data tersimpan",
            "data" => $buku
        ]);
    }

    function destroy(Request $request, $id)
    {
        $buku = Buku::query()->where("id", $id)->first();
        if (!isset($buku)) {
            return response()->json([
                "status" => false,
                "message" => "luru nopo mas?",
                "data" => null
            ]);
        }

        if ($buku->sampul != '') {
            $lokasigambar = str_replace($request->getSchemeAndHttpHost(), '', $buku->sampul);
            $gambar = public_path($lokasigambar);
            unlink($gambar);
        }
        $buku->delete();

        return response()->json([
            "status" => true,
            "message" => "Data Terhapus",
            "data" => $buku
        ]);
    }
}
