<?php

namespace App\Http\Controllers\Admin;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Model\Review;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function list(Request $request){
        $query_param = [];
        $search = $request['search'];
        if($request->has('search'))
        {
            $key = explode(' ', $request['search']);
            $products=Product::where(function ($q) use ($key) {
                    foreach ($key as $value) {
                        $q->orWhere('name', 'like', "%{$value}%");
                    }
                })->pluck('id')->toArray();
        $reviews=Review::whereIn('product_id',$products);
        $query_param = ['search' => $request['search']];
        }else{
            $reviews=Review::with(['product','customer']);
        }
         $reviews = $reviews->latest()->paginate(Helpers::getPagination())->appends($query_param);
        return view('admin-views.reviews.list',compact('reviews','search'));
    }

    public function search(Request $request){
        $key = explode(' ', $request['search']);
        $products=Product::where(function ($q) use ($key) {
            foreach ($key as $value) {
                $q->orWhere('name', 'like', "%{$value}%");
            }
        })->pluck('id')->toArray();
        $reviews=Review::whereIn('product_id',$products)->get();
        return response()->json([
            'view'=>view('admin-views.reviews.partials._table',compact('reviews'))->render()
        ]);
    }
}
