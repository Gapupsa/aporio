<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Category;
use App\Unit;
use App\Supplier;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest()->with(['category','unit'])->paginate(10);
        $categories = Category::all();
        $units = Unit::all();
        $suppliers = Supplier::all();
        $response =[
            'data' => $products,
            'categories' => $categories,
            'units' => $units,
            'suppliers' => $suppliers
        ];
        return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    protected function savePhoto(UploadedFile $photo){
        $fileName = str_random(40) . '.' . $photo->guessClientExtension();
        $destinationPath = public_path() . DIRECTORY_SEPARATOR . 'images';
        $photo->move($destinationPath, $fileName);
        return $fileName;
    }

    public function store(Request $request)
    {
        dd($request->file('photo'));
        $this->validate($request,[
            'code'         => 'required|max:8',
            'name'         => 'required|max:20',
            'category_id'      => 'required|numeric|exists:categories,id',
            'unit_id'      => 'required|numeric|exists:units,id',
            'stok'         => 'required|numeric',
            'minStok'         => 'required|numeric',
            'supplier_id'      => 'required|numeric|exists:suppliers,id',
            'harga_beli'   => 'required|numeric',
            'harga_jual' => 'nullable|numeric',
        ]);

        $data = $request->all();
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $this->savePhoto($request->file('photo'));
        }

        return Product::create($data);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
