<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\Http;

class CastController extends Controller
{
    private $apiBaseUrl = 'http://localhost:8000/api';
    public function index(Request $request)
    {
        $response = Http::get("{$this->apiBaseUrl}/casts");

        if ($response->successful()) {
            $casts = $response->json();
            $editingCast = null;

            if ($request->has('edit_id')) {
                $castRes = Http::get("{$this->apiBaseUrl}/casts/{$request->edit_id}");
                if ($castRes->successful()) {
                    $editingCast = $castRes->json();
                }
            }

            return view('cast', compact('casts', 'editingCast'));
        }

        return view('cast')->with('message', 'Gagal memuat data.');
    }

    public function store(Request $request){

    }

    public function update(){

    }


    public function destroy($id){
        $response = Http::delete("{$this->apiBaseUrl}/casts/{$id}");

        if ($response->successful()) {
            return redirect()->route('casts.index')->with('message', 'berhasil dihapus.');
        }

        return redirect()->route('casts.index')->with('message', 'Gagal menghapus data yang dipilih.');
    }
}
