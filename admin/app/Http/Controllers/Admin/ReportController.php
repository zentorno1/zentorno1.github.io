<?php

namespace App\Http\Controllers\Admin;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\OrderDetail;
use App\Model\Product;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function order_index()
    {
        if (session()->has('from_date') == false) {
            session()->put('from_date', date('Y-m-01'));
            session()->put('to_date', date('Y-m-30'));
        }
        return view('admin-views.report.order-index');
    }

    public function earning_index()
    {
        if (session()->has('from_date') == false) {
            session()->put('from_date', date('Y-m-01'));
            session()->put('to_date', date('Y-m-30'));
        }
        return view('admin-views.report.earning-index');
    }

    public function set_date(Request $request)
    {
        $fromDate = Carbon::parse($request['from'])->startOfDay();
        $toDate = Carbon::parse($request['to'])->endOfDay();

        session()->put('from_date', $fromDate);
        session()->put('to_date', $toDate);
        return back();
    }

    public function sale_report()
    {
        return view('admin-views.report.sale-report');
    }

    public function sale_filter(Request $request)
    {
        if ($request['branch_id'] == 'all') {
            $orders = Order::whereBetween('created_at', [$request->from, $request->to])->pluck('id')->toArray();
        } else {
            $orders = Order::where(['branch_id' => $request['branch_id']])
                ->whereBetween('created_at', [$request->from, $request->to])->pluck('id')->toArray();
        }

        $data = [];
        $total_sold = 0;
        $total_qty = 0;

        foreach (OrderDetail::whereIn('order_id', $orders)->get() as $detail) {
            $price = $detail['price'] - $detail['discount_on_product'];
            $ord_total = $price * $detail['quantity'];
            array_push($data, [
                'order_id' => $detail['order_id'],
                'date' => $detail['created_at'],
                'price' => $ord_total,
                'quantity' => $detail['quantity'],
            ]);
            $total_sold += $ord_total;
            $total_qty += $detail['quantity'];
        }

        return response()->json([
            'order_count' => count($data),
            'item_qty' => $total_qty,
            'order_sum' => \App\CentralLogics\Helpers::set_symbol($total_sold),
            'view' => view('admin-views.report.partials._table', compact('data'))->render(),
        ]);
    }

    public function export_sale_report()
    {
        $data = session('export_sale_data');
        $pdf = PDF::loadView('admin-views.report.partials._report', compact('data'));
        return $pdf->download('sale_report_'.rand(00001,99999) . '.pdf');
    }
}
