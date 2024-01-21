<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    public function index(Request $request){

        $products = Product::search($request->search, $request->company_id)->paginate(10);
        $company_lists = Company::pluck('company_name', 'id');
        $company = $request->company_id;
    
        return view('products.index', compact('products', 'company_lists', 'company'));
    }

    public function create(){

        $companies = Company::all();
        return view('products.create', compact('companies'));
    }

    public function store(ProductRequest $request){

        DB::beginTransaction();
        try {
            Product::createProduct($request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }
        return redirect('products');
    }
    

    public function show(Product $product){

        return view('products.show', ['product' => $product]);
    }

    public function edit(Product $product){

        $companies = Company::all();
        return view('products.edit', compact('product', 'companies'));
    }

    public function update(ProductRequest $request, Product $product){

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

    public function destroy(Product $product){

        $product->delete();
        return redirect('/products');
    }
}
