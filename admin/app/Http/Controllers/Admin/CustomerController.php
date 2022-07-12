<?php

namespace App\Http\Controllers\Admin;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Newsletter;
use App\Model\Order;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function customer_list(Request $request)
    {
        $query_param = [];
        $search = $request['search'];
        if($request->has('search'))
        {
            $key = explode(' ', $request['search']);
            $customers = User::with(['orders'])->
                    where(function ($q) use ($key) {
                        foreach ($key as $value) {
                            $q->orWhere('f_name', 'like', "%{$value}%")
                                ->orWhere('l_name', 'like', "%{$value}%")
                                ->orWhere('phone', 'like', "%{$value}%")
                                ->orWhere('email', 'like', "%{$value}%");
                        }
            });
            $query_param = ['search' => $request['search']];
        }else{
            $customers = User::with(['orders']);
        }
        $customers = $customers->latest()->paginate(Helpers::getPagination())->appends($query_param);

        return view('admin-views.customer.list', compact('customers','search'));
    }

    public function search(Request $request){
        $key = explode(' ', $request['search']);
        $customers=User::where(function ($q) use ($key) {
            foreach ($key as $value) {
                $q->orWhere('f_name', 'like', "%{$value}%")
                    ->orWhere('l_name', 'like', "%{$value}%")
                    ->orWhere('email', 'like', "%{$value}%")
                    ->orWhere('phone', 'like', "%{$value}%");
            }
        })->get();
        return response()->json([
            'view'=>view('admin-views.customer.partials._table',compact('customers'))->render()
        ]);
    }

    public function view($id)
    {
        $customer = User::find($id);
        if (isset($customer)) {
            $orders = Order::latest()->where(['user_id' => $id])->paginate(10);
            return view('admin-views.customer.customer-view', compact('customer', 'orders'));
        }
        Toastr::error('Customer not found!');
        return back();
    }

    public function subscribed_emails(Request $request)
    {
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $newsletters = Newsletter::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('email', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        } else {
            $newsletters = new Newsletter();
        }

        $newsletters = $newsletters->latest()->paginate(Helpers::getPagination())->appends($query_param);
        return view('admin-views.customer.subscribed-list', compact('newsletters', 'search'));
    }
}
