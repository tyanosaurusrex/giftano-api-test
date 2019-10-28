<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Item;
use App\Category;
use Validator;

class ItemController extends Controller
{
    public $successStatus = 200;

    public function index(){
        $items = Item::all();
        return response()->json([
            'code' => $this->successStatus,
            'status' => true,
            'message' => 'Success',
            'data' => $items
        ], $this->successStatus);
    }

    public function show($id){
        $item = Item::find($id);
        if ($item == null){
            return response()->json([
                'code' => 204,
                'status' => false,
                'message' => 'Item not exist',
                'data' => []
            ], 204);
        }
        return response()->json([
            'code' => $this->successStatus,
            'status' => true,
            'message' => 'Success',
            'data' => $item
        ], $this->successStatus);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category_id' => 'required|numeric'
        ]);

        if ($validator->fails()){
            return response()->json([
                'code' => 400,
                'status' => false,
                'message' => $validator->errors()
            ], 400);
        }

        if (Category::find($request->category_id) == null){
            return response()->json([
                'code' => 400,
                'status' => false,
                'message' => 'Category not exist',
                'data' => []
            ], 400);
        }

        $input = $request->all();

        $item = Item::create($input);
        return response()->json([
            'code' => $this->successStatus,
            'status' => true,
            'message' => 'Success',
            'data' => $item
        ], $this->successStatus);
    }

    public function update(Request $request, $id){
        $item = Item::find($id);

        if ($item == null){
            return response()->json([
                'code' => 204,
                'status' => false,
                'message' => 'Item not exist',
                'data' => []
            ], 204);
        }

        if ($request['name'] != null) { $item['name'] = $request['name']; }
        if ($request['category_id'] != null && Category::find($request['category_id']) != null) { $item['category_id'] = $request['category_id']; }

        $item->save();
        return response()->json([
            'code' => $this->successStatus,
            'status' => true,
            'message' => 'Success',
            'data' => $item
        ], $this->successStatus);
    }

    public function destroy($id){
        $item = Item::find($id);

        if ($item == null){
            return response()->json([
                'code' => 400,
                'status' => false,
                'message' => 'Item not exist',
                'data' => []
            ], 204);
        }
        
        Item::destroy($id);
        return response()->json([
            'code' => $this->successStatus,
            'status' => true,
            'message' => 'Success'
        ], $this->successStatus);
    }
}
