<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Expense;
use App\Models\User;

class ListController extends Controller
{
    public function index(){
        $expenses = Expense::where('user_id', Auth::id())->get();

        return view('layouts.base', ['expenses' => $expenses]);
    }

    public function store(Request $request)
    {
        $this->isValid($request);
        $data = $request->all();
        $expense = new Expense();
        $expense->user_id = Auth::id();
        $expense->fill($data);
        $expense->save();

        return redirect()->route('show.expenses');
    }

    public function delete(Expense $expense)
    {
        $expense->status='deleted';
        $expense->update();

        return redirect()->route('show.expenses');
    }

    protected function isValid($data)
    {
      $data->validate([
        'category' => 'required|max:255',
        'amount' => 'required',
        'description' => 'required|max:1024',
      ]);
    }
}
