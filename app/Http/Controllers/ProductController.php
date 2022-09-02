<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('/products');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'   => 'required|min:3|max:100',
            'price'  => 'nullable|numeric|max:10' ,
            'amount' =>  'nullable|numeric|max:10',
            'images' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048' ,
           ]);
        $data = [
            'name'     => $request['name'],
            'price'    => $request['price'],
            'amount'   => $request['amount'],
            'isActive' => 1,
        ];
        $imageLocation = [];
        if ($request->hasFile('images')){
            $files = $request->file('images');
            foreach ($files as $file){
                $fileName = rand(100, 1000).''. time(). '.' . $file->getClientOriginalExtension();
                $filePath = public_path('/images/uploads/');
                $file->move($filePath, $fileName);
                $imageLocation[] = $fileName;
            }
            $data['images'] = implode('|', $imageLocation);
        }
        $product = Product::create($data);
        if ($product) {
            return back()->with('success', 'Product successfully saved!');
        }else {
            return back()->with('error', 'something went to wrong!');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
