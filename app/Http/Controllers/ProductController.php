<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    
    public function index(Request $request)
    {   
        $query = Product::query();
        $company_lists = Product::all();

        if($search = $request->search){
            $query->where('product_name', 'LIKE', "%{$search}%");
        }

        if(!empty($company = $request->company_id)){
           $query->where('company_id', 'LIKE', $company);
        }
        
        $products = $query->paginate(10);

        $list = array(
            'products' => $products,
            'company_lists' => $company_lists,
            'company' => $company,
        );
        
        return view('products.index', compact('products','company_lists','company'));
    }

    public function create()
    {
        $companies = Company::all();
        return view('products.create', compact('companies'));
    }

    public function store(ProductRequest $request)
    {
        // $request->validate([
        //     'product_name' => 'required',
        //     'company_id' => 'required',
        //     'price' => 'required',
        //     'stock' => 'required',
        //     'comment' => 'nullable',
        //     'img_path' => 'nullable|image|max:2048',
        // ]);

        $product = $request->validated();

        $product = new Product([
            'product_name' => $request->get('product_name'),
            'company_id' => $request->get('company_id'),
            'price' => $request->get('price'),
            'stock' => $request->get('stock'),
            'comment' => $request->get('comment'),
        ]);

        if($request->hasFile('img_path')){ 
            $filename = $request->img_path->getClientOriginalName();
            $filePath = $request->img_path->storeAs('products', $filename, 'public');
            $product->img_path = '/storage/' . $filePath;
        }

        $product->save();
        return redirect('products');

    }

    public function show(Product $product)
    {
        return view('products.show', ['product' => $product]);
    }

    public function edit(Product $product)
    {
        $companies = Company::all();
        return view('products.edit', compact('product', 'companies'));
    }

    public function update(ProductRequest $request, Product $product)
    {

        $product->product_name = $request->product_name;
        $product->company_id = $request->company_id;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->comment = $request->comment;
       
        if(isset($product->img_path)){
            $filePath = $product->img_path;
            \Storage::disk('public')->delete($filePath);
        }
      
        if($request->hasFile('img_path')){
        $filename = $request->img_path->getClientOriginalName();
        $filePath = $request->img_path->storeAs('products', $filename, 'public');
        $product->img_path = '/storage/' . $filePath;    
        }
        
        $product->save();
        return redirect()->route('products.index');

    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect('/products');
    }
}
