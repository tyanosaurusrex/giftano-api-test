<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use Validator;

class CategoryController extends Controller
{
    public $successStatus = 200;

    public function uncategorizedId() {
        $uncategorized = Category::where('name', 'Uncategorized')->first();
        return $uncategorized->id;
    }

    public function getTree($category){
        $data = [];
        $children = Category::where('parent', $category->id)->get();

        if (count($children) == 0){
            return $data;
        }

        $data = $children->map(function($el){
            $el->children = [];
            $trees = $this->getTree($el);
            $el->children = $trees;
            return $el;
        });

        return $data;
    }

    public function index(){
        $allCategories = Category::all();

        $categories = $allCategories->map(function ($el){
            if ($el->parent == 0){
                $el->children = [];
                $trees = $this->getTree($el);
                $el->children = $trees;
                return $el;
            }
        })->reject(function ($el){
            return $el === null;
        })->values();

        return response()->json([
            'code' => $this->successStatus,
            'status' => true,
            'message' => 'Success',
            'data' => $categories
        ], $this->successStatus);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'parent' => 'required|numeric'
        ]);

        if ($validator->fails()){
            return response()->json([
                'code' => 400,
                'status' => false,
                'message' => $validator->errors()
            ], 400);
        }

        $input = $request->all();
        $input['parent'] = !$input['parent'] ? 0 : $input['parent'];

        $category = Category::create($input);
        return response()->json([
            'code' => $this->successStatus,
            'status' => true,
            'message' => 'Success',
            'data' => $category
        ], $this->successStatus);
    }

    public function update(Request $request, $id){
        $category = Category::find($id);

        if ($category == null){
            return response()->json([
                'code' => 204,
                'status' => false,
                'message' => 'Category not exist',
                'data' => []
            ], 204);
        }

        if ($request['name'] != null) { $category['name'] = $request['name']; }
        if ($request['parent'] != null) { $category['parent'] = $request['parent']; }

        $category->save();
        return response()->json([
            'code' => $this->successStatus,
            'status' => true,
            'message' => 'Success',
            'data' => $category
        ], $this->successStatus);
    }

    public function destroy($id){
        $category = Category::find($id);

        if ($category == null){
            return response()->json([
                'code' => 204,
                'status' => false,
                'message' => 'Category not exist',
                'data' => []
            ], 204);
        }

        $parent = $category->parent;
        $children = Category::where('parent', $id)->get();
        $children->map(function($el) use ($parent){
            $el->parent = $parent;
            $el->save();
            return;
        });
        
        Category::destroy($id);
        return response()->json([
            'code' => 204,
            'status' => true,
            'message' => 'Success'
        ], 204);
    }
}
