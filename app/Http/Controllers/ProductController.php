<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request){
        $query = Product::query();
        if($request->has('sort')){
            $query->orderBy($request->sort, $request->direction ?? 'asc');
        }
        if($request->has('search')){
            $query->where('product_id', 'like', "%{$request->search}%")->orWhere('description','like', "%{$request->search}%");
        }
        $products =$query->paginate(10);
        return view('index', compact('products'));

    }
    public function create() {
        return view('create');
    }
    public function store(Request $request) {
        $validated = $request->validate([
            'product_id' => 'required|unique:products',
            'name' => 'required',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $fileName = "null";
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $destinationPath = 'uploads';
            $file->move($destinationPath,$fileName);
        }
        Product::create([
            'product_id' => $request->product_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $fileName,
        ]);

        return redirect('/products')->with('success', 'Product created successfully.');
    }

    public function show($id) {
        $product = Product::findOrFail($id);
        return view('show', compact('product'));
    }
    public function edit($id) {
        $product = Product::findOrFail($id);
        return view('edit', compact('product'));
    }
    public function update(Request $request, $id) {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'product_id' => 'required|unique:products,product_id,' . $product->id,
            'name' => 'required',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $fileName = "null";
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $destinationPath = 'uploads';
            $file->move($destinationPath,$fileName);
        }
        $product->update([
            'product_id' => $request->product_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $fileName,
        ]);

        return redirect('/products')->with('success', 'Product updated successfully.');
    }

    public function destroy($id) {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect('/products')->with('success', 'Product deleted successfully.');
    }
}
