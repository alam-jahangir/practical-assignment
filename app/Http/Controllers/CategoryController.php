<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Http\Resources\Category as CategoryResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('created_at', 'desc')->paginate(5);
        return CategoryResource::collection($categories);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function autocomplete(Request $request)
    {
        $name = $request->input('name');
        $categories = Category::orderBy('created_at', 'desc')
            ->where('name', 'like', '%' . $name . '%')
            ->get();
        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = $request->isMethod('put') ? Category::findOrFail($request->id) : new Category();
        $category->id = $request->input('id');
        $category->name = $request->input('name');
        $parent_id = intval($request->input('parent_id'));
        $category->parent_id = $parent_id ? $parent_id : null;
        if ($category->save()) {
            return new CategoryResource($category);
        }

        return json_encode($category);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return new CategoryResource($category);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        if ($category->delete()) {
            return new CategoryResource($category);
        }
    }
}
