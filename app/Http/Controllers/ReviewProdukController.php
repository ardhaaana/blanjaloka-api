<?php

namespace App\Http\Controllers;

use App\Models\ReviewProduk;
use App\Models\Customer;
use App\Models\Produk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\Table;

class ReviewProdukController extends Controller
{
    
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function create(Request $request)
    {

        $validator = Validator::make($request->only('id_produk', 'id_customer'), [
            'id_produk' => "required",
            'id_customer' => "required"
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => 0, 'message' => 'Required or incorrect fields', 'errors' => $validator->errors()], 500);
        }

        $produk = Produk::find($request->input('id_produk'));
        $customer = Customer::find($request->input('id_customer'));

        if (!$produk) {
            return response()->json(['success' => 0, 'message' => 'Produk tidak ditemukan'], 404);
        }
        if (!$customer) {
            return response()->json(['success' => 0, 'message' => 'ID Customer tidak ditemukan'], 404);
        }

        $review = new ReviewProduk();

        $review->id_produk = $request->input('id_produk');
        $review->id_customer = $request->input('id_customer');
        $review->review = $request->input('review');
        $review->star = $request->input('star');
        $review->save();

        if ($review) {
            return response()->json([
                'success' => true,
                'message' => 'Pemberian Ulasan berhasil',
                'data' => $review
            ], 201);
        }
    }


    // Menampilkan Review produk
    public function show($id_produk)
    {
        $isireview = DB::table('review_produk')
                    ->select('review_produk.id', 'review_produk.id_produk', 'produk.nama_produk','produk.deskripsi','review_produk.id_customer','customer.nama_customer', 'review_produk.review', 'review_produk.star')
                    ->join('produk','review_produk.id_produk', '=', 'produk.id_produk')
                    ->join('customer','review_produk.id_customer', '=', 'customer.id_customer')
                    ->where('review_produk.id_produk', $id_produk)
                    ->get();

        if (empty($isireview)) {
            return response()->json(['success' => false,'error' => 'Review Produk Tidak Ditemukan'], 402);
        }

        return response()->json(['success' => true, 'message' => 'Menampilkan Review', 'Data' => $isireview],200);
    }

    public function update(Request $request, $id)
    {
        $review = ReviewProduk::find($id);

        $review = ReviewProduk::find($request->input('id_produk'));
        $review = ReviewProduk::find($request->input('id_customer'));
        $review->review = $request->input('review');
        $review->star = $request->input('star');

        $review->save();

        if (!$review) {
            return response()->json([
                'success' => false, 
                'message' => 'Data tidak ditemukan',
                'data' => $review
            ], 404);
        }
        
        if (!$review) {
            return response()->json(['success' => false, 'error' => 'unknown error'], 500);
        }

         return response()->json([
             'success' => true, 
            'message' => 'Review Produk update!'
        ],200);
    }


    public function destroy($id)
    {
        $review = ReviewProduk::find($id);

        if (!$review) {
            return response()->json([
                'success' => false, 
                'message' => 'Review tidak ditemukan',
                'data' => $review
            ], 404);
        }

        $review->delete();

        return response()->json([
            'success' => true, 
            'message' => 'Review berhasil dihapus',
            'data' => $review
        ], 200);
    }

}
