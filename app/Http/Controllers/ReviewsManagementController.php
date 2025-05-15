<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ReviewsManagementController extends Controller
{
    private $apiBase = 'http://localhost:8000/api';

    public function index(Request $request)
    {
        $reviews = Http::get("{$this->apiBase}/reviews")->json();
        $users = Http::get("{$this->apiBase}/users")->json();
        $films = Http::get("{$this->apiBase}/films")->json();

        $editingReview = null;
        if ($request->has('edit_id')) {
            $editId = $request->query('edit_id');
            $editingReview = Http::get("{$this->apiBase}/reviews/{$editId}")->json();
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
        $response = Http::put("{$this->apiBase}/reviews/{$id}", [
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
            'is_critic' => $request->input('is_critic'),
        ]);

        return redirect()->route('reviews.index')->with('message', 'Review berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Http::delete("{$this->apiBase}/reviews/{$id}");
        return redirect()->route('reviews.index')->with('message', 'Review berhasil dihapus.');
    }
}
