<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    private $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('API_BASE_URL');
    }

    public function index()
    {
        $films = $users = $reviews = [];
        $totalFilm = $totalUser = $totalReview = 0;
        $token = Session::get('api_token');

        try {
            $responseFilm = Http::withToken($token)->get("{$this->apiBaseUrl}/films");
            if ($responseFilm->successful()) {
                $films = $responseFilm->json();
                $totalFilm = count($films);
            }

            $responseUser = Http::withToken($token)->get("{$this->apiBaseUrl}/users");
            if ($responseUser->successful()) {
                $users = $responseUser->json();
                $totalUser = count($users);
            }

            $responseReview = Http::withToken($token)->get("{$this->apiBaseUrl}/reviews");
            if ($responseReview->successful()) {
                $reviews = $responseReview->json();
                $totalReview = count($reviews);
            }

            return view('home', compact('films', 'totalFilm', 'totalUser', 'totalReview'));
        } catch (ConnectionException $e) {
            return view('home')->with('error', 'Tidak dapat terhubung ke server API.');
        } catch (\Throwable $e) {
            return view('home')->with('error', 'Terjadi kesalahan internal.');
        }
    }
}
