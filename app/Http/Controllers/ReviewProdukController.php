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
            return response()->json(['code' => 500,'success' => false, 'message' => 'Required or incorrect fields', 'errors' => $validator->errors()]);
        }

        $produk = Produk::find($request->input('id_produk'));
        $customer = Customer::find($request->input('id_customer'));

        if (!$produk) {
            return response()->json(['code' => 404,'success' => false, 'message' => 'Produk tidak ditemukan']);
        }
        if (!$customer) {
            return response()->json(['code' => 404,'success' => false, 'message' => 'ID Customer tidak ditemukan']);
        }

        $review = new ReviewProduk();

        $review->id_produk = $request->input('id_produk');
        $review->id_customer = $request->input('id_customer');
        $review->review = $request->input('review');
        $review->star = $request->input('star');
        $review->save();

        if ($review) {
            return response()->json([
                'code' => 200,
                'success' => true,
                'message' => 'Pemberian Ulasan berhasil',
                'data' => $review
            ]);
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
            return response()->json(['code' => 402,'success' => false,'error' => 'Review Produk Tidak Ditemukan']);
        }

        return response()->json(['code' => 200,'success' => true, 'message' => 'Menampilkan Review', 'Data' => $isireview]);
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
                'code' => 404,
                'success' => false, 
                'message' => 'Data tidak ditemukan',
                'data' => $review
            ]);
        }
        
        if (!$review) {
            return response()->json(['code' => 500,'success' => false, 'error' => 'unknown error']);
        }

         return response()->json([
             'code' => 200,
             'success' => true, 
            'message' => 'Review Produk update!'
        ]);
    }


    public function destroy($id)
    {
        $review = ReviewProduk::find($id);

        if (!$review) {
            return response()->json([
                'code' => 404,
                'success' => false, 
                'message' => 'Review tidak ditemukan',
                'data' => $review
            ]);
        }

        $review->delete();

        return response()->json([
            'code' => 200,
            'success' => true, 
            'message' => 'Review berhasil dihapus',
            'data' => $review
        ]);
    }

}
