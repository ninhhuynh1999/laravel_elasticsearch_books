<?php

namespace App\Http\Controllers;

use App\Classes\RequestFilter\Models\ProductFilter;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Services\Contracts\ProductServiceInterface;
use Illuminate\Http\Request;
use ReflectionClass;

class ProductController extends Controller
{
    protected ProductServiceInterface $service;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->service = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $inputs = $request->all();
        /*
        // example filter
        $inputs['name']  = "last word";
        $inputs['category_id']  = "1";
        $inputs['created_at:gte']  = "2023-10-19 00:00:00";
        $inputs['created_at:lte']  = "2023-10-19 23:59:59.99";
        */

        return response()->json($this->service->getProductForIndex($request));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
