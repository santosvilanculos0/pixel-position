<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        $response = Http::asForm()->post(config('services.laravelpassport.host').'/oauth/token', [
            'grant_type' => 'client_credentials',
            'client_id' => config('services.laravelpassport.client_id'),
            'client_secret' => config('services.laravelpassport.client_secret'),
            'scope' => '',
        ]);

        $accessToken = $response->json()['access_token'];

        $r = $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$accessToken,
        ])->get(config('services.laravelpassport.host').'/api/jobs');

        return view('dashboard', ['data' => $r->json()]);
    }
}
