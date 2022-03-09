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
                    <form action="{{ route('add.expense') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="mb-3">
                            <label for="category" class="form-label">Categoria</label>
                            <select id="category" class="form-control @error('category') is-invalid @enderror" name="category" value="{{ old('category') }}" required autocomplete="category" aria-label="Default select example">
                                <option>Seleziona una categoria</option>
                                <option value="Cibo e bevande">Cibo e Bevande</option>
                                <option value="Benzina">Benzina</option>
                                <option value="Spesa">Spesa</option>
                                <option value="Imprevvisti">Imprevisiti</option>
                              </select>
                            @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="expense_date" class="form-label">Categoria</label>
                            <input type="date" class="form-control  @error('expense_date') is-invalid @enderror" id="expense_date" name="expense_date"  value="{{ old('expense_date') }}" required>
                            @error('expense_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descrizione</label>
                            <textarea type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description" value="{{ old('description') }}" required></textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label">Amontare</label>
                            <input type="number" step="0.01" class="form-control  @error('amount') is-invalid @enderror" id="amount" name="amount"  value="{{ old('amount') }}" required>
                            @error('amount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                        <button type="submit" class="btn btn-secondary form-control">Submit</button>
                    </form>
                @endif

                @if($mode === "edit")
                    <form action="{{ route('edit.expense') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="mb-3">
                            <input type="number" class="form-control" id="id" name="id"  value="{{ $expense->id }}" required hidden>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Categoria</label>
                            <select id="category" class="form-control @error('category') is-invalid @enderror" name="category" value="{{ $expense->category }}" required autocomplete="category" aria-label="Default select example">
                                <option selected="{{$expense->category}}">{{$expense->category}}</option>
                                <option>Seleziona una categoria</option>
                                <option value="Cibo e bevande">Cibo e Bevande</option>
                                <option value="Benzina">Benzina</option>
                                <option value="Spesa">Spesa</option>
                                <option value="Imprevvisti">Imprevisiti</option>
                              </select>
                            @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="expense_date" class="form-label">Categoria</label>
                            <input type="date" class="form-control  @error('expense_date') is-invalid @enderror" id="expense_date" value="{{ $expense->expense_date }}" name="expense_date" required>
                            @error('expense_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descrizione</label>
                            <textarea type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description" required>{{ $expense->description }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label">Amontare</label>
                            <input type="number" step="0.01" class="form-control  @error('amount') is-invalid @enderror" id="amount" name="amount"  value="{{ $expense->amount }}" required>
                            @error('amount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                        <button type="submit" class="btn btn-secondary form-control">Submit</button>
                    </form>
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
                <table  class="table table-hover">
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
            </div>
        </div>

    </div>
@endsection
