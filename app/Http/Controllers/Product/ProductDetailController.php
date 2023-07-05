<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product\ProductDetail;
use Alert;

/**
 * @OA\Get(
 *    path="/api/productdetail",
 *    summary="Get all productdetails",
 *    description="Retrieve a list of all productdetails",
 *    tags={"ProductDetail"},
 *    @OA\Response(
 *      response=200,
 *      description="Successful operation",
 *      @OA\JsonContent(
 *          type="array",
 *          @OA\Items(ref="#/components/schemas/ProductDetail")
 *      ),
 *    ),
 *    security={{"bearerAuth": {}}}
 * ),
 * @OA\Get(
 *    path="/api/productdetail/{id}",
 *    summary="Get a product by ID",
 *    description="Retrieve a specific product detail by its ID",
 *    tags={"ProductDetail"},
 *    @OA\Parameter(
 *      name="id",
 *      in="path",
 *      description="ID of the product detail",
 *      required=true,
 *      @OA\Schema(type="integer", format="int64")
 *    ),
 *    @OA\Response(
 *      response=200,
 *      description="Successful operation",
 *      @OA\JsonContent(ref="#/components/schemas/ProductDetail")
 *    ),
 *    security={{"bearerAuth": {}}}
 * ),
 * @OA\Post(
 *     path="/api/productdetail",
 *     summary="Create a new product detail",
 *     description="Create a new product detail in the online shop.",
 *     tags={"ProductDetail"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Product data",
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="id",
 *                     type="integer",
 *                     format="int64"
 *                 ),
 *                 @OA\Property(
 *                     property="name",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="image",
 *                     type="string",
 *                     format="binary"
 *                 ),
 *                 @OA\Property(
 *                     property="price",
 *                     type="number",
 *                     format="float"
 *                 ),
 *                 @OA\Property(
 *                     property="stock",
 *                     type="integer",
 *                     format="int32"
 *                 ),
 *                 @OA\Property(
 *                     property="discount",
 *                     type="integer",
 *                     format="int32"
 *                 ),
 *                 @OA\Property(
 *                     property="status",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="slug",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="description",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="sold",
 *                     type="integer",
 *                     format="int32"
 *                 ),
 *                 @OA\Property(
 *                     property="shipping",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="size",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="rating",
 *                     type="number",
 *                     format="float"
 *                 ),
 *                 @OA\Property(
 *                     property="wishlist",
 *                     type="integer",
 *                     format="int32"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Product Detail created successfully",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 ref="#/components/schemas/ProductDetail"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     )
 * ),
  * @OA\Put(
 *     path="/api/productdetail/{id}",
 *     summary="Update a product detail",
 *     description="Update an existing product detail by its ID",
 *     tags={"ProductDetail"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID of the product detail",
 *         required=true,
 *         @OA\Schema(type="integer", format="int64")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Product Detail data",
 *         @OA\JsonContent(ref="#/components/schemas/ProductDetailRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Product Detail updated successfully",
 *         @OA\JsonContent(ref="#/components/schemas/ProductDetail")
 *     ),
 *     security={{"bearerAuth": {}}}
 * ),
 * @OA\Delete(
 *    path="/api/productdetail/{id}",
 *    summary="Delete a product detail",
 *    description="Delete a product detail by its ID",
 *    tags={"ProductDetail"},
 *    @OA\Parameter(
 *      name="id",
 *      in="path",
 *      description="ID of the product",
 *      required=true,
 *      @OA\Schema(type="integer", format="int64")
 *    ),
 *    @OA\Response(
 *      response=200,
 *      description="Product deleted successfully"
 *    ),
 *    security={{"bearerAuth": {}}}
 * ),
 * @OA\Schema(
 *    schema="ProductDetail",
 *    type="object",
 *    @OA\Property(property="id", type="integer", format="int64"),
 *    @OA\Property(property="name", type="string"),
 *    @OA\Property(property="image", type="string"),
 *    @OA\Property(property="price", type="number", format="float"),
 *    @OA\Property(property="stock", type="integer", format="int32"),
 *    @OA\Property(property="discount", type="integer", format="int32"),
 *    @OA\Property(property="status", type="string"),
 *    @OA\Property(property="slug", type="string"),
 *    @OA\Property(property="description", type="string"),
 *    @OA\Property(property="sold", type="integer", format="int32"),
 *    @OA\Property(property="shipping", type="string"),
 *    @OA\Property(property="size", type="string"),
 *    @OA\Property(property="rating", type="number", format="float"),
 *    @OA\Property(property="wishlist", type="integer", format="int32")
 * ),
 * @OA\Schema(
 *    schema="ProductDetailRequest",
 *    type="object",
 *    @OA\Property(property="name", type="string"),
 *    @OA\Property(property="image", type="string"),
 *    @OA\Property(property="price", type="number", format="float"),
 *    @OA\Property(property="stock", type="integer", format="int32"),
 *    @OA\Property(property="discount", type="integer", format="int32"),
 *    @OA\Property(property="status", type="string"),
 *    @OA\Property(property="slug", type="string"),
 *    @OA\Property(property="description", type="string"),
 * ),
**/

class ProductDetailController extends Controller
{
    public function index()
    {
        $productdetails = ProductDetail::latest()->get();
        return response()->json(['productdetails' => $productdetails]);
        
    }

    public function store(Request $request)
    {
        // dd($request);

        //upload image
        $product = ProductDetail::create([
            'id'     => $request->id,
            'product_id'     => $request->product_id,
            'sold'     => $request->sold,
            'shipping'     => $request->shipping,
            'size'   => $request->size,
            'color'   => $request->color,
            'rating'   => $request->rating,
            'wishlist'   => $request->wishlist,
            'description'   => $request->description,
            'slug'   => $request->slug,
        ]);

    }

    public function show()
    {
        $productdetails = ProductDetail::all();
        $products = Product::all();

        if (!$products) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        return view('productdetail.detail', compact('products'));
    }


    public function edit(Product $product)
    {
        return view('product.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        //get data Product by ID
        $product = ProductDetail::findOrFail($product->id);


        $product->update([
            'id'     => $request->id,
            'sold'     => $request->sold,
            'shipping'     => $request->shipping,
            'size'   => $request->size,
            'color'   => $request->color,
            'rating'   => $request->rating,
            'wishlist'   => $request->wishlist,
            'description'   => $request->description,
            'slug'   => $request->slug,
        ]);


        if($product){
            //redirect dengan pesan sukses
            // Alert::success('Congrats', 'You\'ve Successfully Updated Product');
            return redirect()->route('products.index');
        }else{
            //redirect dengan pesan error
            // Alert::error('Error', 'You\'ve Data Product Error to Update');
            return redirect()->route('products.index');
        }
    }
}
