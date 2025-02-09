<?php

namespace App\Http\Controllers;

use App\Models\Laundry;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // public function index(Request $request)
    // { 
    //     if ($request->keyword) {
    //         $transactions = Transaction::whereHas('laundry', function ($query) use ($request) {
    //             $query->where('customer_name', 'like', '%' . $request->keyword . '%')
    //                   ->orWhere('customer_phone_number', 'like', '%' . $request->keyword . '%');
    //         })->get();
    //         $laundries = Laundry::all();
    //     } else {
    //         $transactions = Transaction::where('payment_status', 'completed')->get();
    //         $laundries = Laundry::all();
    //         // Mengelompokkan transaksi berdasarkan bulan dan menghitung total pendapatan bulanan
    //         $transactionsByMonth = $transactions->groupBy(function ($transaction) {
    //             return \Carbon\Carbon::parse($transaction->payment_date)->format('Y-m'); // Format: 2024-02
    //         });

    //         $monthlyEarnings = $transactionsByMonth->map(function ($transactions) {
    //             return $transactions->sum('total_price');
    //         });
            
    //     }
    //     // $laundries = Laundry::where('user_id', Auth::user()->id)->get();
    //     // dd($transactions);
    //     return view('transactions.index', compact('transactions', 'laundries', 'transactionsByMonth', 'monthlyEarnings'));
    // }

    public function index(Request $request)
{ 
    if ($request->keyword) {
        // Jika ada pencarian, ambil transaksi yang sesuai
        $transactions = Transaction::whereHas('laundry', function ($query) use ($request) {
            $query->where('customer_name', 'like', '%' . $request->keyword . '%')
                  ->orWhere('customer_phone_number', 'like', '%' . $request->keyword . '%');
        })->get();
        $laundries = Laundry::all();

        // Hasil pencarian tidak dikelompokkan per bulan
        $transactionsByMonth = collect(['Search Results' => $transactions]);
        $monthlyEarnings = ['Search Results' => $transactions->sum('total_price')];
    } else {
        // Jika tidak ada pencarian, ambil transaksi berdasarkan bulan
        $transactions = Transaction::where('payment_status', 'completed')->get();
        $laundries = Laundry::all();

        // Mengelompokkan transaksi berdasarkan bulan
        $transactionsByMonth = $transactions->groupBy(function ($transaction) {
            return \Carbon\Carbon::parse($transaction->payment_date)->format('Y-m'); // Format: 2024-02
        });

        // Menghitung total pendapatan per bulan
        $monthlyEarnings = $transactionsByMonth->map(function ($transactions) {
            return $transactions->sum('total_price');
        });
    }

    return view('transactions.index', compact('transactionsByMonth', 'monthlyEarnings', 'laundries'));
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
