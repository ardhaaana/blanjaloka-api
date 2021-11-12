<?php

namespace App\Http\Controllers;

use App\Models\ReviewProduk;
use App\Models\Produk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ReviewProdukController extends Controller
{
    
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function create(Request $request)
    {
        $this->validate($request, [
            
            'id_produk' => 'required',
            'nama_customer' => 'required|unique:review_produk',
            'review' => 'required',
            'star' => 'required'
        ]);

        
        $id_produk = $request->input('id_produk');
        $nama_customer = $request->input('nama_customer');
        $review = $request->input('review');
        $star = $request->input('star');
       

        $review = ReviewProduk::create([
            
            'id_produk' => $id_produk,
            'nama_customer' => $nama_customer,
            'review' => $review,
            'star' => $star
        ]);

        if ($review) {
            return response()->json([
                'message' => 'Pemberian Ulasan berhasil',
                'data' => $review
            ], 201);
        }
    }

    public function index()
    {
        $review = ReviewProduk::all();

        if (empty($review)) {
            return response()->json(['error' => 'Ulasan Tidak Ditemukan'], 402);
        }
        return response()->json($review);
    }

    public function show($id)
    {
        $review = ReviewProduk::find($id);

        if (empty($review)) {
            return response()->json(['error' => 'Ulasan Tidak Ditemukan'], 402);
        }

        return response()->json($review);
    }

    public function update(Request $request, $kode_review_produk)
    {
        $review = ReviewProduk::find($kode_review_produk);

        if (!$review) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'data' => $review
            ], 404);
        }

        $this->validate($request, [
            
            'id_produk' => 'required',
            'nama_customer' => 'required|unique:review_produk',
            'review' => 'required',
            'star' => 'required'
        ]);

        $datareview = $request->all();
        $review->fill($datareview);
        $review->save();

        
        if (!$review) {
            return response()->json(['error' => 'unknown error'], 500);
        }

         return response()->json([
            'message' => 'Ulasan update!',
            'code' => 200
        ]);
    }

    public function destroy($id)
    {
        $review = ReviewProduk::find($id);

        if (!$review) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'data' => $review
            ], 404);
        }

        $review->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus',
            'data' => $review
        ], 200);
    }

}
