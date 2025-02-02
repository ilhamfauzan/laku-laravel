<?php

namespace App\Http\Controllers;

use App\Models\Laundry;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(Request $request)
    { 
        if ($request->keyword) {
            $transactions = Transaction::whereHas('laundry', function ($query) use ($request) {
                $query->where('customer_name', 'like', '%' . $request->keyword . '%')
                      ->orWhere('customer_phone_number', 'like', '%' . $request->keyword . '%');
            })->get();
            $laundries = Laundry::all();
        } else {
            $transactions = Transaction::where('payment_status', 'completed')->get();
            $laundries = Laundry::all();
        }
        // $laundries = Laundry::where('user_id', Auth::user()->id)->get();
        // dd($transactions);
        return view('transactions.index', compact('transactions', 'laundries'));
    }

    public function markAsPaid(Laundry $laundry)
    {
        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'laundry_id' => $laundry->id,
            'total_price' => $laundry->laundry_weight * $laundry->service->service_price,
            'payment_date' => now(),
            'payment_status' => 'completed',
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaction marked as paid.');
    }

    public function printReceipt(Transaction $transaction)
    {
        return view('transactions.receipt', compact('transaction'));
    }
}
