<?php

namespace App\Http\Controllers;

use App\Models\ReviewProduk;
use App\Models\Customer;
use App\Models\Produk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ReviewProdukController extends Controller
{
    
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    
            # code...
   
    public function create(Request $request)
    {
        // $this->validate($request, [
            
        //     'id_produk' => 'required',
        //     'nama_customer' => 'required|unique:review_produk',
        //     'review' => 'required',
        //     'star' => 'required'
        // ]);

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

        // $review = ReviewProduk::create([
            
        //     'id_produk' => $id_produk,
        //     'nama_customer' => $nama_customer,
        //     'review' => $review,
        //     'star' => $star
        // ]);

        if ($review) {
            return response()->json([
                'message' => 'Pemberian Ulasan berhasil',
                'data' => $review
            ], 201);
        }
    }

    public function index()
    {
        $review = ReviewProduk::with('customer','produk')->get();

        if (!$review){
            return response()->json(['success' => 0, 'message' => 'Review tidak ditemukan']
             );
        }

        return response()->json([
            'success' => 1,
            'message' => 'Menampilkan Review Produk',
            'Review Produk' => $review
        ],200);
        
        // if (empty($review)) {
        //     return response()->json(['error' => 'Ulasan Tidak Ditemukan'], 402);
        // }
        // return response()->json($review);
    }

    public function show($id)
    {
        $review = ReviewProduk::with('customer', 'produk')->find($id);

        if (empty($review)) {
            return response()->json(['error' => 'Review Produk Tidak Ditemukan'], 402);
        }

        return response()->json($review);
    }

    public function show_produk(Produk $review)
    {
        return response()->json(['message'=>'','data'=>$review->produk],200);
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
                'message' => 'Data tidak ditemukan',
                'data' => $review
            ], 404);
        }
        
        if (!$review) {
            return response()->json(['error' => 'unknown error'], 500);
        }

         return response()->json([
            'message' => 'Review Produk update!',
            'code' => 200
        ]);
    }


    public function destroy($id)
    {
        $review = ReviewProduk::find($id);

        if (!$review) {
            return response()->json([
                'message' => 'Review tidak ditemukan',
                'data' => $review
            ], 404);
        }

        $review->delete();

        return response()->json([
            'message' => 'Review berhasil dihapus',
            'data' => $review
        ], 200);
    }

}
