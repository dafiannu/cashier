<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function receipt(int $id): View
    {
        $transaction = Transaction::with(['user', 'transactionDetails.item'])->findOrFail($id);

        return view('transactions.receipt', compact('transaction'));
    }

    public function history(): View
    {
        $transactions = Transaction::with('user')->orderBy('created_at', 'desc')->get();

        return view('transactions.history', compact('transactions'));
    }

    public function show(int $id): View
    {
        $transaction = Transaction::with(['user', 'transactionDetails.item'])->findOrFail($id);

        return view('transactions.show', compact('transaction'));
    }
}
