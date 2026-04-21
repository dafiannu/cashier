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
}
