<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Storage;
use App\Models\Product\Product;

/**
 * @OA\Info(
 *    title="APIs For Ecommerce Server by AslanAsilon",
 *    version="1.0.0",
 *    description = "API documentation for the Aradan Online Shop project. The API provides various endpoints to manage products, orders, customers, and more."
 * ),
 * @OA\Get(
 *    path="/api/product",
 *    summary="Get all products",
 *    description="Retrieve a list of all products",
 *    tags={"Product"},
 *    @OA\Response(
 *      response=200,
 *      description="Successful operation",
 *      @OA\JsonContent(
 *          type="array",
 *          @OA\Items(ref="#/components/schemas/Product")
 *      ),
 *    ),
 *    security={{"bearerAuth": {}}}
 * ),
 * @OA\Get(
 *    path="/api/product/{id}",
 *    summary="Get a product by ID",
 *    description="Retrieve a specific product by its ID",
 *    tags={"Product"},
 *    @OA\Parameter(
 *      name="id",
 *      in="path",
 *      description="ID of the product",
 *      required=true,
 *      @OA\Schema(type="integer", format="int64")
 *    ),
 *    @OA\Response(
 *      response=200,
 *      description="Successful operation",
 *      @OA\JsonContent(ref="#/components/schemas/Product")
 *    ),
 *    security={{"bearerAuth": {}}}
 * ),
 * @OA\Post(
 *     path="/api/product",
 *     summary="Create a new product",
 *     description="Create a new product in the online shop.",
 *     tags={"Product"},
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
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Product created successfully",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 ref="#/components/schemas/Product"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     )
 * ),
  * @OA\Put(
 *     path="/api/product/{id}",
 *     summary="Update a product",
 *     description="Update an existing product by its ID",
 *     tags={"Product"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID of the product",
 *         required=true,
 *         @OA\Schema(type="integer", format="int64")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Product data",
 *         @OA\JsonContent(ref="#/components/schemas/ProductRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Product updated successfully",
 *         @OA\JsonContent(ref="#/components/schemas/Product")
 *     ),
 *     security={{"bearerAuth": {}}}
 * ),
 * @OA\Delete(
 *    path="/api/product/{id}",
 *    summary="Delete a product",
 *    description="Delete a product by its ID",
 *    tags={"Product"},
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
 *    schema="Product",
 *    type="object",
 *    @OA\Property(property="id", type="integer", format="int64"),
 *    @OA\Property(property="name", type="string"),
 *    @OA\Property(property="description", type="string"),
 *    @OA\Property(property="price", type="number", format="float")
 * ),
 * @OA\Schema(
 *    schema="ProductRequest",
 *    type="object",
 *    @OA\Property(property="name", type="string"),
 *    @OA\Property(property="description", type="string"),
 *    @OA\Property(property="price", type="number", format="float")
 * ),
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
*/


class ProductController extends Controller
{
    
    public function index(Request $request)
    {
        $products = Product::all();
        return response()->json(['products' => $products]);
    }

    public function store(Request $request)
    {
        // $validatedData = $request->validated();

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/products', $image->hashName());

        $product = Product::create([
            'id'     => $request->id,
            'name'     => $request->name,
            'image'     => $image->hashName(),
            'price'   => $request->price,
            'stock'   => $request->stock,
            'discount'   => $request->discount,
            'status'   => $request->status,
            'slug'   => $request->slug,
            'description'   => $request->description,
        ]);

    }

    
    public function edit(Product $product)
    {
        return view('product.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {

        //get data Product by ID
        $product = Product::findOrFail($product->id);

        if($request->file('image') == "") {

            $product->update([
                'id'     => $request->id,
                'name'     => $request->name,
                'price'   => $request->price,
                'stock'   => $request->stock,
                'discount'   => $request->discount,
                'status'   => $request->status,
                'slug'   => $request->slug,
                'description'   => $request->description,
            ]);

        } else {

            //hapus old image
            Storage::disk('local')->delete('public/products/'.$product->image);

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/products', $image->hashName());

            $product->update([
                'id'     => $request->id,
                'name'     => $request->name,
                'image'     => $image->hashName(),
                'price'   => $request->price,
                'stock'   => $request->stock,
                'discount'   => $request->discount,
                'status'   => $request->status,
                'slug'   => $request->slug,
                'description'   => $request->description,
            ]);

        }
    }

    public function show($id)
    {
        $products = Product::find($id);

        return response()->json(['products' => $products]);
    }

    public function destroy($id, Request $request)
    {
        $product = Product::findOrFail($id);
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/products', $image->hashName());
        }
        
        Storage::disk('local')->delete('public/products/'.$product->image);
        $product->delete();
    
        return response()->json([
            'success' => true,
            'message' => 'Data Successfully deleted!',
        ]); 
    }


    public function getProductByCategory()
    {
        $product = DB::table('products')
                        ->join('categories', 'products.category_uuid', '=', 'categories.uuid')
                        ->select('products.*', 'categories.uuid as category_uuid')
                        ->get();
    
        return $product;
    }
        


}

