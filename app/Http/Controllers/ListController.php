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

        //$expensesByDate = $this->groupByDate($expenses);

        // krsort($expensesByDate, SORT_NATURAL | SORT_FLAG_CASE);



        // $yesterday = $this->totalOfYesterday($expensesByDate);
        // $lastWeek = $this->totalOfLastWeek($expensesByDate);

        return json_encode($expenses);

        // return view('layouts.insertForm', [
        //     'expensesByDate' => $expensesByDate,
        //     'mode' => 'insert',
        //     'totalOfYesterday' => $yesterday,
        //     'totalOfLastWeek' => $lastWeek
        // ]);
    }

    public function store(Request $request){
        $this->isValid($request);
        $data = $request->all();
        $expense = new Expense();
        $expense->user_id = Auth::id();
        $expense->fill($data);
        $expense->save();

        return redirect()->route('show.expenses');
    }

    public function delete(Request $request){
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
        krsort($expensesByDate, SORT_NATURAL | SORT_FLAG_CASE);
        $yesterday = $this->totalOfYesterday($expensesByDate);
        $lastWeek = $this->totalOfLastWeek($expensesByDate);

        return view('layouts.updateForm', [
            'expense' => $expense,
            'expensesByDate' => $expensesByDate,
            'mode' => 'edit',
            'totalOfYesterday' => $yesterday,
            'totalOfLastWeek' => $lastWeek
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
            $expense['expense_date'] = \DateTime::createFromFormat('Y-m-d H:i:s', $expense['expense_date'])->format('Y-m-d');
            if(!isset($expensesByDate[$expense['expense_date']])) {
                $expensesByDate[$expense['expense_date']] = [];
            }

            $expensesByDate[$expense['expense_date']][] = $expense;
        }

        return $expensesByDate;
    }

    public function totalOfYesterday($expenses){

        $yesterday = strtotime("-2 day");
        $total = ['amount' => 0];
        foreach($expenses as $expense){
            foreach ($expense as $amount) {
                if((strtotime($amount['expense_date']) - $yesterday) >= 0){
                    $total['amount'] += $amount['amount'];
                }
            }
        }

        return $total;
    }

    public function totalOfLastWeek($expenses){

        $lastWeek = strtotime("-1 week");

        $total = ['amount' => 0];
        foreach($expenses as $expense){
            foreach ($expense as $date) {
                if((strtotime($date['expense_date']) - $lastWeek) >= 0){
                    $total['amount'] += $date['amount'];
                }
            }
        }

        return $total;
    }

    protected function isValid($data){
      $data->validate([
        'category' => 'required|max:255',
        'amount' => 'required',
        'description' => 'required|max:1024',
      ]);
    }
}
