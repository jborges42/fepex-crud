<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;

use Illuminate\Http\Request;

use Session;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $categories = ProductCategory::all();
        $products = Product::paginate();

        return view('products.index', compact('categories', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ProductCategory::all();

        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:124',
            'description' => 'required|max:256',
            'price' => 'required',
            'category_id' => 'required'
        ]);

        $product = Product::create($request->all());

        if (!$product) { 
            Session::flash('success', "Não foi possível cadastrar produto. Consultar logs do sistema.");
            return redirect()->back();
        }

        Session::flash('alert-success', 'Produto criado com sucesso.');
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = ProductCategory::all();

        return view('products.edit', compact('categories', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {

        $product->update($request->all());

        if (!$product) { 
            Session::flash('success', "Não foi possível atualizar o produto. Consultar logs do sistema.");
            return redirect()->back();
        }

        Session::flash('alert-success', 'Produto atualizado com sucesso.');
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $deleted = $product->delete();

        if (!$deleted) { 
            Session::flash('success', "Não foi possível deletar o produto. Consultar logs do sistema.");
            return redirect()->back();
        }

        Session::flash('alert-success', 'Produto deletado.');
        return redirect()->route('products.index');
    }
}