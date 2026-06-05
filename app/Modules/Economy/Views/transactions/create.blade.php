@extends('adminlte::page')

@section('title', 'Nuovo Movimento')

@section('content_header')
    <h1>Nuovo Movimento</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('economy.transactions.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="data">Data <span class="text-danger">*</span></label>
                            <input type="date" name="data" id="data" class="form-control @error('data') is-invalid @enderror" value="{{ old('data', date('Y-m-d')) }}" required>
                            @error('data') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="importo">Importo (&euro;) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0.01" name="importo" id="importo" class="form-control @error('importo') is-invalid @enderror" value="{{ old('importo') }}" required>
                            @error('importo') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="account_type_id">Tipo Conto</label>
                            <select name="account_type_id" id="account_type_id" class="form-control @error('account_type_id') is-invalid @enderror">
                                <option value="">Nessuno</option>
                                @foreach($accountTypes as $id => $nome)
                                    <option value="{{ $id }}" {{ old('account_type_id') == $id ? 'selected' : '' }}>{{ $nome }}</option>
                                @endforeach
                            </select>
                            @error('account_type_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="category_id">Categoria</label>
                            <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                <option value="">Nessuna</option>
                                @foreach($categories as $id => $nome)
                                    <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>{{ $nome }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="descrizione">Descrizione</label>
                            <input type="text" name="descrizione" id="descrizione" class="form-control @error('descrizione') is-invalid @enderror" value="{{ old('descrizione') }}" maxlength="500">
                            @error('descrizione') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="note">Note</label>
                    <textarea name="note" id="note" rows="3" class="form-control @error('note') is-invalid @enderror" maxlength="5000">{{ old('note') }}</textarea>
                    @error('note') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Salva
                    </button>
                    <a href="{{ route('economy.transactions.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Annulla
                    </a>
                </div>
            </form>
        </div>
    </div>
@stop
