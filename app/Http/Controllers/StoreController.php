<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Product;
use App\Sale;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class StoreController
 * @package App\Http\Controllers
 */
class StoreController extends Controller
{
    /**
     * Import JSON file to the database
     * @return Application|RedirectResponse|Redirector
     */
    public function import()
    {
        $jsonFile = Storage::get('DEV_Sales_full.json');
        $decodeJson = json_decode($jsonFile);

        foreach ($decodeJson as $record) {
            // populate products table
            $product = Product::firstOrCreate(
                [
                    'id' => $record->product_id
                ],
                [
                    'id' => $record->product_id,
                    'product_name' => property_exists($record, 'product_name') ? $record->product_name : $record->name
                ]
            );

            // populate customers table
            $customer = Customer::firstOrCreate(
                [
                    'customer_name' => $record->customer_name
                ],
                [
                    'customer_name' => $record->customer_name,
                    'email' => $record->customer_mail
                ]
            );

            // populate sales table
            Sale::firstOrCreate(
                [
                    'customer_id' => $customer->id,
                    'product_id' => $product->id,
                ],
                [
                    'sale_date' => $record->sale_date,
                    'version' => $record->version,
                    'price' => $record->product_price
                ]
            );
        }

        return redirect('/')->with('success', 'The JSON file has been loaded to the Database');
    }

    /**
     * Show all sales with its relations
     * @param Request $request
     * @return Application|Factory|View
     */
    public function bookSale(Request $request)
    {
        $salesQuery = Sale::query();

        if ($request->has('customer_id') && !is_null($request->input('customer_id'))) {
            $salesQuery->where('customer_id', $request->input('customer_id'));
        }
        if ($request->has('product_id') && !is_null($request->input('product_id'))) {
            $salesQuery->where('product_id', $request->input('product_id'));
        }
        if ($request->has('price_from') && !is_null($request->input('price_from'))) {
            $salesQuery->where('price', '>=', $request->input('price_from'));
        }
        if ($request->has('price_to') && !is_null($request->input('price_to'))) {
            $salesQuery->where('price', '<=', $request->input('price_to'));
        }

        $sales = $salesQuery->with(['product', 'customer'])->get();
        $salesSum = $sales->sum('price');
        $saleTotal = $sales->count();

        $customers = Customer::all();
        $products = Product::all();

        return view('sales',
            compact('sales', 'salesSum', 'customers', 'products', 'saleTotal'));
    }
}
