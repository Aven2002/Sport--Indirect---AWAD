<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Product;
use App\Models\ProductDetail;

class ProductController extends Controller
{
    /**
     * Retrieve all product records
     */
    public function index()
    {
        try{
            $products = Product::with('productDetail')->get();

            if($products->isEmpty())
            {
                return response()->json([
                    'message'=>'The table is empty'
                ],200);
            }

            return response()->json([
                'message'=>'All product records retrieved successfully',
                'products'=>$products
            ],200);

        }catch(\Exception $e)
        {
            return reponse()->json([
                'message'=>'Something went wrong',
                'error'=>$e->getMessage()
            ],500);
        }
    }

    /**
     * Retrieve specific product
     */
    public function show($id)
    {
        try{
            $product = Product::with(['productDetail', 'productStocks'])->find($id);

            if(!$product)
            {
                return response()->json([
                    'message'=>'Product record not found'
                ],200);
            }

            return response()->json([
                'message'=>'Product record with product detail retrieved successfully',
                'product'=>$product
            ],200);

        }catch(\Exception $e)
        {
            return response()->json([
                'message'=>'Something went wrong',
                'error'=>$e->getMessage()
            ],500);
        }
    }

    /**
     * Remove specific product
     */
    public function destroy($id)
    {
        try{

            $product = Product::find($id);

            if(!$product)
            {
                return response()->json([
                    'message'=>'Product record not found'
                ],404);
            }

            if ($product->detail) {
                $imgPath = $product->detail->imgPath;
    
                if ($imgPath && $imgPath !== 'img/Default/_product.png') {
                    $fullPath = public_path($imgPath);
                    if (file_exists($fullPath)) {
                        unlink($fullPath); 
                    }
                }
            }

            $product->delete();

            return response()->json([
                'message'=>'Product deleted successfully'
            ],200);

        }catch(\Exception $e)
        {
            return response()->json([
                'message'=>'Something went wrong',
                'error'=>$e->getMessage()
            ],500);
        }
    }

    /**
     * Store newly created product
     */
    public function store(Request $request)
    {
        try {
            // Step 1: Validate first
            $validatedData = $request->validate([
                'productName'=>'required|string|max:50',
                'sportCategory'=>'required|string|max:50',
                'productCategory'=>'required|string|max:50',
                'productBrand'=>'required|string|max:50',
                'description'=>'required|string',
                'stock'=>'required|integer',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'price'=>'required|numeric'
            ]);

            // Step 2: Process image (after validation)
            $imagePath = 'Default/_product.png';
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = Str::slug($validatedData['productName']) . '_' . time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('img', $filename, 'public');
                $imagePath = 'storage/img/' . $filename;
            }

            // Step 3: Create product
            $product = Product::create([
                'productName' => $validatedData['productName'],
                'sportCategory'=> $validatedData['sportCategory'],
                'productBrand' => $validatedData['productBrand'],
                'productCategory' => $validatedData['productCategory'],
            ]);

            // Step 4: Create product detail
            $product->productDetail()->create([
                'description' => $validatedData['description'],
                'stock' => $validatedData['stock'],
                'imgPath' => $imagePath,
                'price' => $validatedData['price'],
            ]);

            return response()->json([
                'message' => 'Product and details created successfully',
                'product' => $product->load('productDetail')
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message'=>'Validation error',
                'errors'=>$e->errors()
            ],422);

        } catch (\Exception $e) {
            return response()->json([
                'message'=>'Something went wrong',
                'error'=>$e->getMessage()
            ],500);
        }
    }

    /**
     * Update specific product record
     */
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'productName'=>'required|string|max:50',
                'sportCategory'=>'required|string|max:50',
                'productCategory'=>'required|string|max:50',
                'productBrand'=>'required|string|max:50',
                'description'=>'required|string',
                'stock'=>'required|integer',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'price'=>'required|numeric'
            ]);
    
            $product = Product::find($id);

            if(!$product)
            {
                return response()->json([
                    'message'=>'Product record not found'
                ],404);
            }
    
            // Default to the existing image
            $imagePath = $product->productDetail->imgPath; 
    
            if ($request->hasFile('image')) {
                // Delete the old image if it's not the default image
                $oldImagePath = public_path($imagePath);
                if (file_exists($oldImagePath) && $imagePath !== 'img/Default/_product.png') {
                    unlink($oldImagePath);
                }
    
                // Store the new image and update the image path
                $image = $request->file('image');
                $filename = Str::slug($validatedData['productName']) . '_' . time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('img', $filename, 'public');
                $imagePath = 'storage/img/' . $filename;
            }
    
            $product->update([
                'productName' => $validatedData['productName'],
                'sportCategory' => $validatedData['sportCategory'],
                'productBrand' => $validatedData['productBrand'],
                'productCategory' => $validatedData['productCategory'],
            ]);
    
            $product->productDetail()->update([
                'description' => $validatedData['description'],
                'stock' => $validatedData['stock'],
                'imgPath' => $imagePath,  
                'price' => $validatedData['price'],
            ]);
    
            return response()->json([
                'message' => 'Product and details updated successfully',
                'product' => $product->load('productDetail')
            ], 200);
    
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
    
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Retrieve all distinct of product brand
     */
    public function getProductBrand()
    {
        try {
        
            $brands = Product::select('productBrand')->distinct()->get();

            if ($brands->isEmpty()) {
                return response()->json([
                    'message' => 'Product brand not found'
                ], 200);
            }

            return response()->json([
                'message' => 'Product brands retrieved successfully',
                'productBrands' => $brands
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

     /**
      * Retrieve all distinct of product category
      */
      public function getProductCategory()
      {
        try{
            $productCategory = Product::select('productCategory')->distinct()->get();

            if($productCategory->isEmpty())
            {
                return response()->json([
                    'message'=>'Product category not found'
                ],200);
            }

            return response()->json([
                'message'=>'Product category retrieved successfully',
                'productCategory'=>$productCategory
            ],200);

        }catch(\Exception $e)
        {
            return response()->json([
                'message'=>'Something went wrong',
                'error'=>$e->getMessage()
            ],500);
        }
    }

    /**
     * Retrieve all distinct of sport category
    */
    public function getSportCategory()
    {
        try{
            $sportCategory = Product::select('sportCategory')->distinct()->get();

            if($sportCategory->isEmpty())
                {
                    return response()->json([
                        'message'=>'Sport category not found'
                    ],200);
                }

                return response()->json([
                    'message'=>'Sport Category retrieved successfully',
                    'sportCategory'=>$sportCategory
                ],200);

        }catch(\Exception $e)
        {
             return response()->json([
                 'message'=>'Something went wrong',
                  'error'=>$e->getMessage()
            ],500);
        }
    }  
    
    /**
     * Search engine
     */
    public function search(Request $request)
    {
        $searchTerm = $request->input('search');

        $products = Product::with('productDetail')->where('productName', 'like', '%' . $searchTerm . '%')->get();

        return response()->json($products);
    }

    /**
     * Retrieve trending now products
     */
    public function getTrendingProducts()
    {
        try {
            $products = Product::with('productDetail')->inRandomOrder()->limit(12)->get();

            return response()->json([
                'message' => 'Trending products retrieved successfully',
                'products' => $products
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Retrieve latest 12 trending products based on created_at
     */
    public function getNewArrivals()
    {
        try {
            $products = Product::with('productDetail')
                ->orderBy('created_at', 'desc')
                ->limit(12)
                ->get();

            return response()->json([
                'message' => 'Trending products retrieved successfully',
                'products' => $products
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
