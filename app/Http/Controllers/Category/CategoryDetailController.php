<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Storage;
use App\Models\Category\CategoryDetail;

class CategoryDetailController extends Controller
{
    public function index(Request $request)
    {
        $categorydetails = CategoryDetail::all();
        return response()->json(['categorydetails' => $categorydetails]);
    }
}
