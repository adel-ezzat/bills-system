<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Client;
use App\Models\Item;
use App\Models\Safe;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class BillsController extends Controller
{
    public function add()
    {
        $allClients = DB::table('clients')->select('id','client_name')->get();
        $allSafes = DB::table('safes')->select('id','name')->get();
        $allItems = DB::table('items')->select('id','item_name')->get();

        return view('bills.add')
            ->with('clients', $allClients)
            ->with('safes', $allSafes)
            ->with('items', $allItems);
    }

    public function getItemByid(Request $request)
    {
        $itemIds = $request->data;
        return DB::table('items')
            ->whereIn('id', $itemIds)
            ->get();
    }

    public function create(Request $request)
    {
        $client = $request->client;
        $safe = $request->safe;
        $items = $request->items;
        $total = $request->total;

        $billId = DB::table('bills')->insertGetId([
            'client_id' => $client,
            'total' => $total,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        foreach ($items as $item) {
            DB::table('bill_items')->insert([
                'bill_id' => $billId,
                'item_id' => $item['id'],
                'item_name' => $item['name'],
                'sale_price' => $item['salePrice'],
                'quantity' => $item['quantity'],
                'total' => $item['totalPrice'],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            // subtract stock quantity
            DB::table('items')
                ->where('id', $item['id'])
                ->decrement('quantity', $item['quantity']);
        }

        // add total money to the safe
        DB::table('safes')
            ->where('id', $safe)
            ->increment('money_amount', $total);

        return 'bill added successfully';
    }

    public function showBillsList()
    {
        $allBills = Bill::getAllBills();
        return view('bills.view')->with('bills', $allBills);
    }

    public function BillDetails($id)
    {
        $allBills = Bill::getBillById($id);
        return view('bills.view-id')->with('bills', $allBills);
    }
}
