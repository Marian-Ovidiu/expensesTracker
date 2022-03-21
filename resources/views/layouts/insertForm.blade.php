@extends('layouts.base')

@section('insertForm')
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
@endsection
