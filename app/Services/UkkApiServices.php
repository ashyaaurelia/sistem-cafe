<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;
use Throwable;

class UkkApiServices
{
    /**
     * Create a new class instance.
     */
    public function getHargaBahan()
    {
        try {
            $response = Http::timeout(10)->withHeaders([
                'X-API-Key' => config('services.ukk_api.key'),
            ])->get(config('services.ukk_api.url') . '/harga-bahan');

            if($response->successful()){
                return $response->json();
            }
            return null;
        } catch (Throwable $e){
            return null;
        }
    }
}