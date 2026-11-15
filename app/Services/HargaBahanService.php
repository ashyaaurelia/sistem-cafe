<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;

class HargaBahanService
{
    public function ambilHargaBahan()
{
    try {
        $response = Http::withHeaders([
            'X-API-Key' => config('services.ukk_api.key'),
        ])->get(
            config('services.ukk_api.url') . '/kafe/harga-bahan'
        );

        return [
            'status' => $response->status(),
            'body' => $response->body(),
            'json' => $response->json(),
        ];

    } catch (\Exception $e) {
        return [
            'error' => $e->getMessage(),
        ];
    }
}
}