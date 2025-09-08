<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Customer;

class CustomerController extends Controller
{
    
    public function getTopCustomers()
    {
        $topCustomers = Customer::select('customers.customer_id', 'customers.name','customers.email', \DB::raw('SUM(orders.amount) as total_spent'))
        ->join('orders', 'customers.customer_id', '=', 'orders.customer_id')
        
        ->where('orders.order_date', '<=', now()->subYear())
        ->groupBy('customers.customer_id','customers.name','customers.email')
        ->orderByDesc('total_spent')
        ->limit(5)
        ->get();

        return response()->json([
            'status' => 'Success',
            'data' => $topCustomers,
        ]);

    }

}
