<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'product_name',
        'price',
        'stock',
        'company_id',
        'comment',
        'img_path',
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getCompany()
    {
        return $this->company;
    }
        

    public static function createProduct($requestData){

        $product = new Product();
        $product->product_name = $requestData['product_name'];
        $product->company_id = $requestData['company_id'];
        $product->price = $requestData['price'];
        $product->stock = $requestData['stock'];
        $product->comment = $requestData['comment'];

        // idフィールドは自動インクリメントなので、明示的に設定する必要はありません。

        if (isset($requestData['img_path'])) {
            $img_path = $requestData['img_path']->store('products', 'public');
            $product->img_path = 'storage/' . $img_path;
        }

        $product->save();
        return $product;
    }
    

   public function scopeSearch($query, $search, $company, $priceMin, $priceMax, $stockMin, $stockMax)
    {
        if ($search) {
        $query->where('product_name', 'LIKE', "%{$search}%");
        }

        if ($company) {
        $query->whereHas('company', function ($query) use ($company) {
            $query->where('company_id', $company);
        });
        }

        if ($priceMin) {
            $query->where('price', '>=', $priceMin);
        }
        
        if ($priceMax) {
            $query->where('price', '<=', $priceMax);
        }
        
        if ($stockMin) {
            $query->where('stock', '>=', $stockMin);
        }
        
        if ($stockMax) {
            $query->where('stock', '<=', $stockMax);
        }

        return $query;
    }

}
