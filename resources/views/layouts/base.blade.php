@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-12 col-md-9 mx-auto">
                <div class="d-flex align-items-center p-3 my-3 bg-dark text-white rounded shadow">
                    <div class="lh-1">
                      <h1 class="h4 mb-0 lh-1">Inserisci una spesa</h1>
                    </div>
                </div>
                @if($mode === "insert")
                    @yield('insertForm')
                @endif

                @if($mode === "edit")
                    @yield('updateForm')
                @endif
            </div>
        </div>

        <div class="row mt-5 totals-row">
            <div class="col-12 col-md-9 mx-auto totals-col">
                <div class="row totals-partition-row">
                    <button id="yesterday" style="border:none" class="col-4 totals-partition-col text-center">
                       Ieri
                    </button>
                    <button id="lastweek" style="border:none" class="col-4 totals-partition-col text-center">
                        Ultimi 7 giorni
                    </button>
                    <button style="border:none" class="col-4 totals-partition-col text-center">
                        Ultimo mese
                    </button>
                </div>
            </div>
        </div>

        <div class="row mt-3 totals-row">
            <input type="hidden" id="totalYesterday" value="{{ $totalOfYesterday['amount'] }}">
            <input type="hidden" id="totalLastWeek" value="{{ $totalOfLastWeek['amount'] }}">

            <div class="col-12 col-md-9 mx-auto text-center totals-col">
                <span id="total">{{ $totalOfYesterday['amount'] }}</span> &euro;
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12 col-md-9 mx-auto">

                <div class="row p-3 shadow my-3 bg-dark text-white text-center shadow">
                    <h1 class="h4 col-12">Listato</h1>
                </div>

                <div class="row my-3 bg-dark text-white shadow">
                    <div class="col-3 text-center">
                        Tipo
                    </div>
                    <div class="col-3 text-center">
                        Descrizione
                    </div>
                    <div class="col-3 text-center">
                        Prezzo
                    </div>
                    <div class="col-3 text-center">
                        Azioni
                    </div>
                </div>

                @foreach ($expensesByDate as $date => $expenses)
                    <div class="row my-3">
                        <div class="col-12 text-center bg-secondary shadow bg-opacity-50">
                            {{$date}}
                        </div>
                    </div>
                    @foreach ($expenses as $expense)
                        <div class="row my-2">
                            <div class="col-3 text-center">
                                {{$expense->category}}
                            </div>
                            <div class="col-3 text-center">
                                {{$expense->description}}
                            </div>
                            <div class="col-3 text-center">
                                {{$expense->amount}}
                            </div>
                            <div class="col-3 text-center d-flex justify-content-around">
                                <form action="{{route('delete.expense', ['expense' => $expense])}}" method="post">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" style="border:none" class="text-black text-decoration-none">Cancella</button>
                                </form>
                                <form action="{{route('fill.form', ['expense' => $expense])}}" method="post">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" style="border:none" class="text-black text-decoration-none">Modifica</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>

    </div>
@endsection
