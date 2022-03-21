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
        $expenses = Expense::where('user_id', Auth::id())->where('status', 'active')->get();
        $expenses = $expenses->all();

        $expensesByDate = $this->groupByDate($expenses);
        //$sortedByDate = $this->sortByDate($expensesByDate);
        return view('layouts.insertForm', [
            'expensesByDate' => $expensesByDate,
            'mode' => 'insert'
        ]);
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

    public function delete(Request $request)
    {
        $data = $request->all();
        $expense = Expense::where('id', $data['expense'])->first();
        $expense->status = 'deleted';
        $expense->update();

        return redirect()->route('show.expenses');
    }

    public function fillForm(Request $request){
        $data = $request->all();
        $expense = Expense::where('id', $data['expense'])->first();
        $expenses = Expense::where('user_id', Auth::id())->where('status', 'active')->get();
        $expensesByDate = $this->groupByDate($expenses);

        $date = new \DateTime;
        $date = $date->createFromFormat('Y-m-d H:i:s', $expense->expense_date)->format('Y-m-d');

        $expense->expense_date = $date;

        return view('layouts.updateForm', [
            'expense' => $expense,
            'expensesByDate' => $expensesByDate,
            'mode' => 'edit'
        ]);
    }

    public function edit(Request $request){

        $data = $request->all();
        $expense = Expense::where('id', $data['id'])->first();
        $expense->category = $data['category'];
        $expense->expense_date = $data['expense_date'];
        $expense->description = $data['description'];
        $expense->amount = $data['amount'];

        $expense->update();

        return redirect()->route('show.expenses');
    }

    public function groupByDate($expenses){
        $expensesByDate = [];
        foreach($expenses as $expense){
            if(!isset($expensesByDate[$expense['expense_date']])) {
                $expensesByDate[$expense['expense_date']] = [];
            }

            $expensesByDate[$expense['expense_date']][] = $expense;
        }

        return $expensesByDate;
    }

    public function sortByDate($expenses){
        $sortedByDate = [];

        $lowed = 9999999999;
        for($i = 0; $i < count($expenses); $i++){
            foreach($expenses as $key => $expense){
                $time1 = strtotime($key);
                if($time1 < $lowed){
                    $lowed = $time1;
                    $date = $key;
                    $currentExpense = $expense;
                    // var_dump($time1, $lowed);
                }
            }
            $sortedByDate[$date] = $currentExpense;
        }





        dd($sortedByDate);
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
