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

        <div class="row mt-5">
            <div class="col-12 col-md-9 mx-auto">
                <div class="d-flex align-items-center p-3 my-3 bg-dark text-white rounded shadow">
                    <div class="lh-1">
                      <h1 class="h4 mb-0 lh-1">Listato</h1>
                    </div>
                </div>

                @foreach ($expensesByDate as $date => $expenses)
                <div class="form-text">{{$date}}</div>
                    <table class="table table-hover">
                        <thead>
                            <tr class="text-center">
                                <th class="col-2">Tipo</th>
                                <th class="col-6">Descrizione</th>
                                <th class="col-2">Prezzo</th>
                                <th class="col-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($expenses as $expense)
                                <tr class="text-center">
                                    <td class="align-middle">{{$expense->category}}</td>
                                    <td class="align-middle">{{$expense->description}}</td>
                                    <td class="align-middle">{{$expense->amount}}</td>
                                    <form action="{{route('delete.expense', ['expense' => $expense])}}" method="post">
                                        @csrf
                                        @method('POST')
                                        <td class="align-middle"><button type="submit" class="text-black text-decoration-none">Cancella</button></td>
                                    </form>
                                    <form action="{{route('fill.form', ['expense' => $expense])}}" method="post">
                                        @csrf
                                        @method('POST')
                                        <td class="align-middle"><button type="submit" class="text-black text-decoration-none">Modifica</button></td>
                                    </form>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            </div>
        </div>

    </div>
@endsection
