<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MovieService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('omdb.api_key');
    }

    public function search($query, $page = 1)
    {
        try {
            $response = Http::withoutVerifying()->get('https://www.omdbapi.com/', [
                'apikey' => $this->apiKey,
                's'      => $query,
                'page'   => $page,
                'type'   => 'movie',
            ]);

            $data = $response->json();

            Log::info('OMDB search response', $data ?? []);

            if (isset($data['Response']) && $data['Response'] === 'True') {
                return [
                    'movies' => $data['Search'] ?? [],
                    'total'  => (int) ($data['totalResults'] ?? 0),
                    'error'  => null,
                ];
            }

            return [
                'movies' => [],
                'total'  => 0,
                'error'  => $data['Error'] ?? 'Film tidak ditemukan.',
            ];
        } catch (\Exception $e) {
            Log::error('OMDB search error: ' . $e->getMessage());

            return [
                'movies' => [],
                'total'  => 0,
                'error'  => 'Gagal menghubungi OMDb API.',
            ];
        }
    }

    public function detail($imdbId)
    {
        try {
            $response = Http::withoutVerifying()->get('https://www.omdbapi.com/', [
                'apikey' => $this->apiKey,
                'i'      => $imdbId,
                'plot'   => 'full',
            ]);

            $data = $response->json();

            Log::info('OMDB detail response', $data ?? []);

            if (isset($data['Response']) && $data['Response'] === 'True') {
                return $data;
            }

            return false;
        } catch (\Exception $e) {
            Log::error('OMDB detail error: ' . $e->getMessage());

            return false;
        }
    }
}