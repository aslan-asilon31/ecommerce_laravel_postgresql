<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product\ProductImage;

class ProductImagesController extends Controller
{
    public function index(){
        $productimages = ProductImage::all();
        return $productimages;
    }
}
