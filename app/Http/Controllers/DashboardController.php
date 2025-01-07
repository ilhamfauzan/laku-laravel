<?php

namespace App\Http\Controllers;

use App\Models\Laundry;
use App\Models\Service;
use Illuminate\View\View;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the dashboard view.
     */
    public function index(Request $request): View
    {
        $services = Service::all();
        $laundries = Laundry::all();
        $finishedLaundries = Laundry::where('status', 'finished')->get();
        $unfinishedLaundries = Laundry::where('status', 'unfinished')->get();

        $incomeToday = Transaction::where('payment_status', 'completed')
            ->whereDate('payment_date', now()->toDateString())
            ->sum('total_price');
        
        $weeklyIncome = [
            'monday' => Transaction::where('payment_status', 'completed')
                ->whereDate('payment_date', now()->startOfWeek())
                ->sum('total_price'),
            'tuesday' => Transaction::where('payment_status', 'completed')
                ->whereDate('payment_date', now()->startOfWeek()->addDays(1))
                ->sum('total_price'),
            'wednesday' => Transaction::where('payment_status', 'completed')
                ->whereDate('payment_date', now()->startOfWeek()->addDays(2))
                ->sum('total_price'),
            'thursday' => Transaction::where('payment_status', 'completed')
                ->whereDate('payment_date', now()->startOfWeek()->addDays(3))
                ->sum('total_price'),
            'friday' => Transaction::where('payment_status', 'completed')
                ->whereDate('payment_date', now()->startOfWeek()->addDays(4))
                ->sum('total_price'),
            'saturday' => Transaction::where('payment_status', 'completed')
                ->whereDate('payment_date', now()->startOfWeek()->addDays(5))
                ->sum('total_price'),
            'sunday' => Transaction::where('payment_status', 'completed')
                ->whereDate('payment_date', now()->startOfWeek()->addDays(6))
                ->sum('total_price'),
        ];

        $incomeThisMonth = Transaction::where('payment_status', 'completed')
            ->whereMonth('payment_date', now()->month)
            ->sum('total_price');
        
        $transactions = Transaction::where('user_id', Auth::user()->id)->get();
        $transactionsThisMonth = Transaction::where('user_id', Auth::user()->id)
            ->whereMonth('payment_date', now()->month)
            ->get();
        $totalLaundriesToday = Laundry::where('user_id', Auth::user()->id)
            ->whereDate('laundry_date', now()->toDateString())
            ->count();

        return view('dashboard.index', 
        compact(
            'services', 'incomeThisMonth', 'unfinishedLaundries', 
            'transactions', 'transactionsThisMonth', 'totalLaundriesToday', 
            'incomeToday', 'weeklyIncome', 'finishedLaundries', 'unfinishedLaundries', 
            'laundries'));
    }
}
