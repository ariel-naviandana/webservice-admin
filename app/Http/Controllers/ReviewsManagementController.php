<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ReviewsManagementController extends Controller
{
    private $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('API_BASE_URL');
    }

    public function index(Request $request)
    {
        $token = Session::get('api_token');
        $filmId = $request->query('film_id');
        try {
            $reviews = Http::withToken($token)->get("{$this->apiBaseUrl}/reviews")->json();
            $users = Http::withToken($token)->get("{$this->apiBaseUrl}/users")->json();
            $films = Http::withToken($token)->get("{$this->apiBaseUrl}/films")->json();

            if ($filmId) {
                $reviews = array_filter($reviews, fn($review) => $review['film_id'] == $filmId);
            }

            $editingReview = null;
            if ($request->has('edit_id')) {
                $editId = $request->query('edit_id');
                $response = Http::withToken($token)->get("{$this->apiBaseUrl}/reviews/{$editId}");
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
        } catch (ConnectionException $e) {
            return view('reviews')->with('error', 'Tidak dapat terhubung ke server API.');
        } catch (\Throwable $e) {
            return view('reviews')->with('error', 'Terjadi kesalahan internal.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:10',
            'comment' => 'required|string',
            'is_critic' => 'required|boolean',
        ]);

        $token = Session::get('api_token');
        try {
            $response = Http::withToken($token)->put("{$this->apiBaseUrl}/reviews/{$id}", [
                'rating' => $request->input('rating'),
                'comment' => $request->input('comment'),
                'is_critic' => $request->input('is_critic'),
            ]);

            if ($response->successful()) {
                return redirect()->route('reviews.index')->with('success', 'Review berhasil diperbarui.');
            }

            $msg = $response->json('message') ?? 'Gagal memperbarui review.';
            if ($response->json('errors')) {
                $msg .= ' '.collect($response->json('errors'))->flatten()->join(' ');
            }
            return redirect()->route('reviews.index')->with('error', $msg);
        } catch (ConnectionException $e) {
            return redirect()->route('reviews.index')->with('error', 'Tidak dapat terhubung ke server API.');
        } catch (\Throwable $e) {
            return redirect()->route('reviews.index')->with('error', 'Terjadi kesalahan internal.');
        }
    }

    public function destroy($id)
    {
        $token = Session::get('api_token');
        try {
            $response = Http::withToken($token)->delete("{$this->apiBaseUrl}/reviews/{$id}");

            if ($response->successful()) {
                return redirect()->route('reviews.index')->with('success', 'Review berhasil dihapus.');
            }

            $msg = $response->json('message') ?? 'Gagal menghapus review.';
            return redirect()->route('reviews.index')->with('error', $msg);
        } catch (ConnectionException $e) {
            return redirect()->route('reviews.index')->with('error', 'Tidak dapat terhubung ke server API.');
        } catch (\Throwable $e) {
            return redirect()->route('reviews.index')->with('error', 'Terjadi kesalahan internal.');
        }
    }
}
