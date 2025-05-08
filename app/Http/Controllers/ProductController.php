<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function crear(){
        return view('products.crear');
    }
    public function leer(){
        $products = Product::all();
        return view('products.leer', compact('products'));
        //return view('products.leer', compact('products'));
    }
    public function update(Request $request, Product $product){
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|min:0',
        ]);
        // Aquí puedes actualizar el producto en la base de datos       
        $product->update($request->all());
        return redirect()->back()->with('success', 'Producto actualizado exitosamente.');
        
        
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|min:0',
        ]);

        // Aquí puedes guardar el producto en la base de datos
        // Product::create($request->all());
        $product = new Product();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->save();

        return redirect()->back()->with('success', 'Producto creado exitosamente.');

    }
    public function eliminar(Product $product)
    {
    $product->delete();
    return redirect()->route('products.leer')->with('success', 'Producto eliminado exitosamente.');
    }
}
