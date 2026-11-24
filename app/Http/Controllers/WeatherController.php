<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $data = $request->validate(['lat' => ['required', 'numeric', 'between:-90,90'], 'lon' => ['required', 'numeric', 'between:-180,180']]);
        $key = config('services.openweather.key');
        if (! $key) return response()->json(['message' => 'Weather service is not configured.'], 503);

        $response = Http::timeout(10)->get('https://api.openweathermap.org/data/2.5/weather', ['lat' => $data['lat'], 'lon' => $data['lon'], 'units' => 'metric', 'appid' => $key]);
        if ($response->failed()) return response()->json(['message' => 'Weather service is unavailable.'], $response->status());
        $weather = $response->json();
        return response()->json(['place' => $weather['name'] ?? 'Selected location', 'temperature' => $weather['main']['temp'] ?? null, 'description' => $weather['weather'][0]['description'] ?? null, 'humidity' => $weather['main']['humidity'] ?? null]);
    }
}
