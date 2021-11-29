<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DetailPesananController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $detail = Pesanan::with('produk', 'pedagang', 'driver')->get();

        if($detail)
        {
            return response()->json([
                'success' => 1,
                'message' => 'Detail Pesanan',
                'Rincian' => $detail
            ], 200);
        }
    }
}

?>