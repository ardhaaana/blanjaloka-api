<?php

namespace App\Http\Controllers;

use App\Models\ReviewProduk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ReviewProdukController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function create(Request $request)
    {
        $this->validate($request, [
            'nama_customer' => 'required|unique:review_produk',
            'review' => 'required',
            'star' => 'required'
        ]);

        $nama_customer = $request->input('nama_customer');
        $review = $request->input('review');
        $star = $request->input('star');
       

        $review = ReviewProduk::create([
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

    public function show($kode_review_produk)
    {
        $review = ReviewProduk::find($kode_review_produk);

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

    // public function search(Request $request)
    // {
    //     # code...
    //     $query = $request->query('query');

    //     if (empty($query)) {
    //         return response()->json(['error' => 'Query not specified!'], 400);
    //     }

    //     $fulltext = $request->query('fulltext', 'false');
    //     $sortBy = $request->query('sort_by', 'nama_customer.asc');
    //     $sorts = explode('.', $sortBy);


    //     if ($fulltext == 'true') {
    //         $data = Pesanan::query()
    //             ->whereRaw("MATCH(nama_customer) AGAINST(? IN BOOLEAN MODE)", array($query))
    //             ->orderBy($sorts[0], $sorts[1])
    //             ->get();
    //         return response()->json($data);
    //     }

    //     $data = Pesanan::query()
    //         ->where('nama_customer', 'like', '%' . $query . '%')
    //         ->orderBy($sorts[0], $sorts[1])
    //         ->get();

    //     return response()->json($data);
    // }

    public function destroy($kode_review_produk)
    {
        $review = ReviewProduk::find($kode_review_produk);

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
