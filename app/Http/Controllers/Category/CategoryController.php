<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Storage;
use App\Models\Category\Category;

/**
    * @OA\Get(
    *    path="/api/category",
    *    summary="Get all categories",
    *    description="Retrieve a list of all categories",
    *    tags={"Category"},
    *    @OA\Response(
    *      response=200,
    *      description="Successful operation",
    *      @OA\JsonContent(
    *          type="array",
    *          @OA\Items(ref="#/components/schemas/Category")
    *      ),
    *    ),
    *    security={{"bearerAuth": {}}}
    * ),

     * @OA\Get(
    *    path="/api/category/{id}",
    *    summary="Get a category by ID",
    *    description="Retrieve a specific category by its ID",
    *    tags={"Category"},
    *    @OA\Parameter(
    *      name="id",
    *      in="path",
    *      description="ID of the category",
    *      required=true,
    *      @OA\Schema(type="integer", format="int64")
    *    ),
    *    @OA\Response(
    *      response=200,
    *      description="Successful operation",
    *      @OA\JsonContent(ref="#/components/schemas/Category")
    *    ),
    *    security={{"bearerAuth": {}}}
    * ),
    * @OA\Post(
    *     path="/api/category",
    *     summary="Create a new category",
    *     description="Create a new category in the online shop.",
    *     tags={"Category"},
    *     @OA\RequestBody(
    *         required=true,
    *         description="Category data",
    *         @OA\MediaType(
    *             mediaType="multipart/form-data",
    *             @OA\Schema(
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
    *                     property="retro_model",
    *                     type="string"
    *                 ),
    *                 @OA\Property(
    *                     property="collaboration",
    *                     type="string"
    *                 ),
    *                 @OA\Property(
    *                     property="limited_edition",
    *                     type="string"
    *                 ),
    *                 @OA\Property(
    *                     property="slug",
    *                     type="string"
    *                 ),
    *             )
    *         )
    *     ),
    *     @OA\Response(
    *         response=201,
    *         description="Category created successfully",
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(
    *                 ref="#/components/schemas/Category"
    *             )
    *         )
    *     ),
    *     @OA\Response(
    *         response=400,
    *         description="Bad request"
    *     )
    * ),
    * @OA\Put(
    *     path="/api/category/{id}",
    *     summary="Update a category",
    *     description="Update an existing category by its ID",
    *     tags={"Category"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="ID of the category",
    *         required=true,
    *         @OA\Schema(type="integer", format="int64")
    *     ),
    *     @OA\RequestBody(
    *         required=true,
    *         description="Category data",
    *         @OA\JsonContent(ref="#/components/schemas/CategoryRequest")
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Category updated successfully",
    *         @OA\JsonContent(ref="#/components/schemas/Category")
    *     ),
    * ),

    * @OA\Delete(
    *    path="/api/category/{id}",
    *    summary="Delete a category",
    *    description="Delete a category by its ID",
    *    tags={"Category"},
    *    @OA\Parameter(
    *      name="id",
    *      in="path",
    *      description="ID of the category",
    *      required=true,
    *      @OA\Schema(type="integer", format="int64")
    *    ),
    *    @OA\Response(
    *      response=200,
    *      description="Category deleted successfully"
    *    ),
    *    security={{"bearerAuth": {}}}
    * ),

     * @OA\Schema(
    *    schema="Category",
    *    type="object",
    *    @OA\Property(property="id", type="integer", format="int64"),
    *    @OA\Property(property="name", type="string"),
    *    @OA\Property(property="image", type="string"),
    *    @OA\Property(property="retro_model", type="string"),
    *    @OA\Property(property="collaboration", type="string"),
    *    @OA\Property(property="limited_edition", type="string"),
    *    @OA\Property(property="slug", type="string"),
    * ),
    * @OA\Schema(
    *    schema="CategoryRequest",
    *    type="object",
    *    @OA\Property(property="name", type="string"),
    *    @OA\Property(property="image", type="string"),
    *    @OA\Property(property="retro_model", type="string"),
    *    @OA\Property(property="collaboration", type="string"),
    *    @OA\Property(property="limited_edition", type="string"),
    *    @OA\Property(property="slug", type="string"),
    * ),
**/



class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        return response()->json(['categories' => $categories]);
    }

    public function store(Request $request)
    {
        // Upload image
        $image = $request->file('image');
        $image->storeAs('public/products', $image->hashName());

        $category = Category::create([
            'name' => $request->name,
            'image' => $image->hashName(),
            'retro_model' => $request->retro_model,
            'collaboration' => $request->collaboration,
            'limited_edition' => $request->limited_edition,
            'slug' => $request->slug,
        ]);

        return response()->json([
            'category' => $category,
            'message' => 'Category created successfully',
        ]);
    }

    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        // Get data Category by ID
        $category = Category::findOrFail($category->id);

        if ($request->file('image') == "") {
            $category->update([
                'name' => $request->name,
                'retro_model' => $request->retro_model,
                'collaboration' => $request->collaboration,
                'limited_edition' => $request->limited_edition,
                'slug' => $request->slug,
            ]);
        } else {
            // Delete old image
            Storage::disk('local')->delete('public/products/' . $category->image);

            // Upload new image
            $image = $request->file('image');
            $image->storeAs('public/products', $image->hashName());

            $category->update([
                'name' => $request->name,
                'image' => $image->hashName(),
                'retro_model' => $request->retro_model,
                'collaboration' => $request->collaboration,
                'limited_edition' => $request->limited_edition,
                'slug' => $request->slug,
            ]);
        }

        return response()->json([
            'category' => $category,
            'message' => 'Category updated successfully',
        ]);
    }

    public function show($id)
    {
        $category = Category::find($id);

        return response()->json(['category' => $category]);
    }

    public function destroy($id, Request $request)
    {
        $category = Category::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/products', $image->hashName());
        }

        Storage::disk('local')->delete('public/products/' . $category->image);
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully',
        ]);
    }
}
