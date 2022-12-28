<?php

namespace Database\Seeders;

use App\Models\Rating;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rating::query()->create(
            [
                'rating' => 'G',
                'deskripsi_rating' => '(General) dapat dibaca oleh semua kalangan dan bersifat umum atau idak ada batasan usia khusus'
            ]
        );
        Rating::query()->create(
            [
                'rating' => 'PG',
                'deskripsi_rating' => '(Parents Guide Suggested) dapat dibaca oleh anak-anak di atas 7 tahun dan harus dalam pengawasan orang tua'
            ]
        );
        Rating::query()->create(
            [
                'rating' => 'PG-13',
                'deskripsi_rating' => 'harus berusia di atas 13 tahun atau tergolong dalam usia remaja.'
            ]
        );
        Rating::query()->create(
            [
                'rating' => 'T',
                'deskripsi_rating' => '(Teenager) untuk remaja yang sedang berada dalam masa transisi.'
            ]
        );
        Rating::query()->create(
            [
                'rating' => 'NC-17',
                'deskripsi_rating' => 'hanya boleh dibaca oleh orang yang sudah dewasa dengan umur di atas 17 tahun'
            ]
        );
        Rating::query()->create(
            [
                'rating' => 'R',
                'deskripsi_rating' => '(Restricted) untuk orang dewasa atau orang dengan umur di atas 17 tahun'
            ]

        );
    }
}
