<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use Sortable;

    public $sortable = [
        'id',
        'name',
        'name_ar',
        'sortOrder',
    ];
    protected $fillable = [
        'name',
        'name_ar',
        'description',
        'brand',
        'category',
        'type',
        'specifications',
        'sortOrder',
        'sku',
        'price',
        'quantity',
        'weight',
        'weight_class',
        'length',
        'width',
        'height',
        'length_class',
    ];
    public function typeObj()
    {
        return $this->hasOne(Type::class, 'id', 'type');
    }
    public function brandObj()
    {
        return $this->hasOne(Brand::class, 'id', 'brand');
    }
    public function categoryObj()
    {
        return $this->hasOne(Category::class, 'id', 'category');
    }
    public function getAllProducts($brands, $categories, $from, $to)
    {
        return DB::table('products')->leftJoin('product_images as pi', function ($q) {
            $q->on('pi.product', '=', 'products.id')
                ->on(
                    'pi.id',
                    '=',
                    DB::raw('(select min(id) from product_images where product = pi.product)')
                );
        })->when($categories !== null && !empty($categories), function ($query) use ($categories) {
            return $query->whereIn('category', $categories);
        })
            ->when($brands !== null && !empty($brands), function ($query) use ($brands) {
                return $query->whereIn('brand', $brands);
            })->when($from !== null, function ($query) use ($from) {
                return $query->where('price', '>=', $from);
            })->when($to !== null, function ($query) use ($to) {
                return $query->where('price', '<=', $to);
            })
            ->select('products.*', 'pi.image', 'pi.id as image_id')
            ->get();
    }
    public function searchProducts($search, $brands, $categories, $from, $to)
    {
        return DB::table('products')->leftJoin('product_images as pi', function ($q) {
            $q->on('pi.product', '=', 'products.id')
                ->on(
                    'pi.id',
                    '=',
                    DB::raw('(select min(id) from product_images where product = pi.product)')
                );
        })
            ->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search . '%');
                $query->orWhere('name_ar', 'LIKE', '%' . $search . '%');
                $query->orWhere('description', 'LIKE', '%' . $search . '%');
            })
            ->when($categories !== null && !empty($categories), function ($query) use ($categories) {
                return $query->whereIn('category', $categories);
            })
            ->when($brands !== null && !empty($brands), function ($query) use ($brands) {
                return $query->whereIn('brand', $brands);
            })->when($from !== null, function ($query) use ($from) {
                return $query->where('price', '>=', $from);
            })->when($to !== null, function ($query) use ($to) {
                return $query->where('price', '<=', $to);
            })
            ->select('products.*', 'pi.image', 'pi.id as image_id')->get();
    }
}
