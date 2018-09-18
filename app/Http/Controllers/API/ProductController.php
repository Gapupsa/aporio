<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Category;
use App\Unit;
use App\Supplier;
use Auth;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('code','ASC')->latest()->with(['category','unit'])->paginate(10);
        $categories = Category::all();
        $units = Unit::all();
        $suppliers = Supplier::all();
        $user = Auth::user();
        $response =[
            'data' => $products,
            'categories' => $categories,
            'units' => $units,
            'suppliers' => $suppliers,
            'user' => $user
        ];
        return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        //return $request->all();
        //dd($request->file('photo'));
        $this->validate($request,[
            //'code'         => 'required|max:8',
            'name'         => 'required|max:20',
            'category_id'      => 'required|numeric|exists:categories,id',
            'unit_id'      => 'required|numeric|exists:units,id',
            'stok'         => 'required|numeric',
            'minStok'         => 'required|numeric',
            'supplier_id'      => 'required|numeric|exists:suppliers,id',
            'harga_pokok'   => 'required|numeric',
            'harga_jual' => 'nullable|numeric',
        ]);
        
        if ($request->gambar) {
            $name = time().'.' . explode('/',explode(':',substr($request->gambar,0,strpos($request->gambar,';')))[1])[1];
            \Image::make($request->gambar)->save('img/products/'.$name);
            $request->merge(['gambar' => $name]);
        }

        //$request['batasDiskon'] = $request['batasDiskon']." 00:00:00";
        return Product::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //return $request->all();
        $this->validate($request,[
            //'code'         => 'required|max:8',
            'name'         => 'required|max:20',
            'category_id'      => 'required|numeric|exists:categories,id',
            'unit_id'      => 'required|numeric|exists:units,id',
            'stok'         => 'required|numeric',
            'minStok'         => 'required|numeric',
            'supplier_id'      => 'required|numeric|exists:suppliers,id',
            'harga_pokok'   => 'required|numeric',
            'harga_jual' => 'nullable|numeric',
        ]);
        
        //return $id;
        $name='';
        $product = Product::findOrFail($id);
        $currentPhoto = $product->gambar;
        if ($request->gambar != $currentPhoto) {
            $name = time().'.' . explode('/',explode(':',substr($request->gambar,0,strpos($request->gambar,';')))[1])[1];
            \Image::make($request->gambar)->save('img/products/'.$name);
            $request->merge(['gambar' => $name]);
        }

        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->unit_id = $request->unit_id;
        $product->stok = $request->stok;
        $product->minStok = $request->minStok;
        $product->supplier_id = $request->supplier_id;
        $product->resepdokter = $request->resepdokter;
        $product->narkotika = $request->narkotika;
        $product->kemasan = $request->kemasan;
        $product->komposisi = $request->komposisi;
        $product->produsen = $request->produsen;
        $product->expireDate = $request->expireDate;
        $product->deskripsi = $request->deskripsi;
        $product->penyajian = $request->penyajian;
        $product->indikasi = $request->indikasi;
        $product->perhatian = $request->perhatian;
        $product->dosis = $request->dosis;
        $product->efeksamping = $request->efeksamping;
        $product->harga_pokok = $request->harga_pokok;
        $product->perInPrice = $request->perInPrice;
        $product->harga_jual = $request->harga_jual;
        $product->isDiskon = $request->isDiskon;
        $product->diskonPer = $request->diskonPer;
        $product->diskonNom = $request->diskonNom;
        $product->diskonUnit = $request->diskonUnit;
        $product->batasDiskon = $request->batasDiskon;
        $product->gambar = $name == '' ? '' : $request->gambar;

        $product->update();

        return ['message'=>'Sukses'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return ['message'=>'Sukses'];
    }
}
