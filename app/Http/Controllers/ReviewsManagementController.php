<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ReviewsManagementController extends Controller
{
    private $apiBase = 'http://localhost:8000/api';

    public function index(Request $request)
    {
        $token = Session::get('api_token');
        $filmId = $request->query('film_id');
        $reviews = Http::withToken($token)->get("{$this->apiBase}/reviews")->json();
        $users = Http::withToken($token)->get("{$this->apiBase}/users")->json();
        $films = Http::withToken($token)->get("{$this->apiBase}/films")->json();

        if ($filmId) {
            $reviews = array_filter($reviews, fn($review) => $review['film_id'] == $filmId);
        }

        $editingReview = null;
        if ($request->has('edit_id')) {
            $editId = $request->query('edit_id');
            $response = Http::withToken($token)->get("{$this->apiBase}/reviews/{$editId}");
            if ($response->successful()) {
                $editingReview = $response->json();
            }
        }

        return view('reviews', [
            'reviews' => $reviews,
            'users' => $users,
            'films' => $films,
            'editingReview' => $editingReview
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:10',
            'comment' => 'required|string',
            'is_critic' => 'required|boolean',
        ]);

        $token = Session::get('api_token');
        $response = Http::withToken($token)->put("{$this->apiBase}/reviews/{$id}", [
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
            'is_critic' => $request->input('is_critic'),
        ]);

        if ($response->successful()) {
            return redirect()->route('reviews.index')->with('message', 'Review berhasil diperbarui.');
        }

        return redirect()->route('reviews.index')->with('message', 'Gagal memperbarui review: ' . ($response->json('message') ?? 'Unknown error'));
    }

    public function destroy($id)
    {
        $token = Session::get('api_token');
        $response = Http::withToken($token)->delete("{$this->apiBase}/reviews/{$id}");

        if ($response->successful()) {
            return redirect()->route('reviews.index')->with('message', 'Review berhasil dihapus.');
        }

        return redirect()->route('reviews.index')->with('message', 'Gagal menghapus review: ' . ($response->json('message') ?? 'Unknown error'));
    }
}
