<?php

/**
 * izi-starter
 * Developed: Tushar ahmed
 */

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Base\BaseController;
use App\Http\Resources\Resource;
use App\Models\Product;
use App\Models\VariantProduct;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Product::with('category', 'brand')->latest();
        $query->whereLike($request->field_name, $request->value);

        $datas = $query->paginate($request->pagination);
        return new Resource($datas);
    }


    public function stockout(Request $request)
    {
        if ($request->format() == 'html') {
            return view('layouts.backend_app');
        } else {
            $query = Product::with('category', 'brand')->where('status', 'active')->where('quantity', '<', 1);
            $products = $query->paginate($request->pagination);
            return new Resource($products);
        }
    }

    public function bulkexport(Request $request)
    {
        if ($request->format() == 'html') {
            return view('layouts.backend_app');
        } else {
            $query = Product::with('category', 'brand')->where('status', 'active')->where('quantity', '<', 1);
            $products = $query->paginate($request->pagination);
            return new Resource($products);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('layouts.backend_app');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($this->validateCheck($request)) {
            try {
                $data = $request->except('variant_product');
                $data['product_code'] = Str::random(10);
                if (!empty($request->specifications)){
                    $data['specifications'] = json_encode($request->specifications);
                }else{
                    $data['specifications'] = [];
                }
                $image = $request->file('featured_image');
                if (!empty($image)) {
                    $data['featured_image'] = $this->upload($image, 'product/featured_image');
                }
                $galleryImage = [];
                if (!empty($request->product_gallery)) {
                    foreach ($request->product_gallery as $gImage) {
                        if (!empty($gImage)) {
                            $img = $this->upload($gImage, 'product/product_gallery');
                            array_push($galleryImage, $img);
                        }
                    }
                }
                $data['product_gallery'] = json_encode($galleryImage);
                $res = Product::create($data);
                if ($res && !empty($request->variant_product)){
                    foreach ($request->variant_product as $vprduct){
                        $vdata = $vprduct;
                        $vdata['product_id'] = $res->id;
                        $image  =  array_key_exists('image',$vprduct) ? $vprduct['image']: null ;
//                        $image  =  $vdata['image'];
                        if (!empty($image)){
                            $vdata['image'] = $this->upload($image,'product/variant');
                        }
                        VariantProduct::create($vdata);
                    }
                }
                return $this->responseReturn("create", $res);
            } catch (Exception $ex) {
                return response()->json(['exception' => $ex->errorInfo ?? $ex->getMessage()], 422);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Product $product)
    {
        if ($request->format() == 'html') {
            return view('layouts.backend_app');
        }
        return $product->load('variantProduct');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('layouts.backend_app');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        if ($this->validateCheck($request, $product->id)) {
            try {
                $data = $request->except('variant_product');
                $image = $request->file('featured_image');
                if (!empty($image)) {
                    $data['featured_image'] = $this->upload($image, 'product/featured_image', $product->featured_image);
                } else {
                    $data['featured_image'] = $this->oldFile($product->featured_image);
                }
                if (!empty($request->specifications)){
                    $data['specifications'] = json_encode($request->specifications);
                }else{
                    $data['specifications'] = [];
                }

                $oldGallery = $product->product_gallery;
                $galleryImage = [];
                if (!empty($request->product_gallery)) {
                    foreach ($request->product_gallery as $key => $gImage) {
                        if (!empty($gImage) && gettype($gImage) != 'string') {
                            $oldImage = !empty($oldGallery) ? $oldGallery[$key] : null;
                            $img = $this->upload($gImage, 'product/product_gallery', $oldImage );
                            array_push($galleryImage, $img);
                        } else {
                            $img = $this->oldFile($gImage);
                            array_push($galleryImage, $img);
                        }
                    }
                }
                $data['product_gallery'] = json_encode($galleryImage);
                $res = $product->fill($data)->save();
                if ($res && !empty($request->variant_product)){
                    VariantProduct::where('product_id',$product->id)->delete();
                    foreach ($request->variant_product as $key => $vprduct){
                        $vdata = $vprduct;
                        $vdata['product_id'] = $product->id;
                        $image  =  array_key_exists('image',$vprduct) ? $vprduct['image']: null ;
                        if (!empty($image)){
                            $oleImage  = !empty($product->variant_product) ? $product->variant_product[$key]['image'] : null;
                            $vdata['image'] = $this->upload($image,'product/variant',$oleImage);
                        }else if (!empty($product->variant_product)){
                            $vdata['image'] =  $this->oldFile($product->variant_product[$key]['image']);
                        }else{
                            $vdata['image'] = null;
                        }
                        VariantProduct::create($vdata);
                    }
                }
                return $this->responseReturn("update", $product);
            } catch (Exception $ex) {
                return response()->json(['exception' => $ex->errorInfo ?? $ex->getMessage()], 422);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $res = $product->delete();
        if ($res) {
            $this->deleteFile($product->featured_image);
            if (!empty($product->product_gallery)) {
                foreach ($product->product_gallery as $image) {
                    $this->deleteFile($this->oldFile($image));
                }
            }
            $variants = VariantProduct::where('product_id', $product->id)->get();
            if (!empty($variant)) {
                foreach ($variants as $variant) {
                    $this->deleteFile($this->oldFile($variant['image']));
                }
            }

        }
        return $this->responseReturn("delete", $res);
    }

    /**
     * Validate form field.
     *
     * @return \Illuminate\Http\Response
     */
    public function validateCheck($request, $id = null)
    {
        return $request->validate([
            'name' => 'required',
            'sku_code' => 'required',
            'barcode' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
            'vendor_id' => 'required',
            'status' => 'required',
            'sorting' => 'required',
        ]);
    }
}
