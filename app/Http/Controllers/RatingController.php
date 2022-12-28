<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    function index()
    {
        $rating = Rating::query()->get();

        return response()->json([
            "status" => true,
            "message" => "list rating buku",
            "data" => $rating
        ]);
    }

    function show($id)
    {
        $rating = Rating::query()->where("id", $id)->first();
        if (!isset($rating)) {
            return response()->json([
                "status" => false,
                "message" => "luru nopo mas?",
                "data" => null
            ]);
        }
        return response()->json([
            "status" => true,
            "message" => "nyoh",
            "data" => $rating
        ]);
    }
}
