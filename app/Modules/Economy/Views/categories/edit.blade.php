@extends('adminlte::page')

@section('title', 'Modifica Categoria')

@section('content_header')
    <h1>Modifica Categoria</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('economy.categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nome">Nome <span class="text-danger">*</span></label>
                            <input type="text" name="nome" id="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome', $category->nome) }}" required maxlength="255">
                            @error('nome') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tipo">Tipo <span class="text-danger">*</span></label>
                            <select name="tipo" id="tipo" class="form-control @error('tipo') is-invalid @enderror" required>
                                <option value="entrata" {{ old('tipo', $category->tipo) === 'entrata' ? 'selected' : '' }}>Entrata</option>
                                <option value="spesa" {{ old('tipo', $category->tipo) === 'spesa' ? 'selected' : '' }}>Spesa</option>
                            </select>
                            @error('tipo') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="icona">Icona (classe FontAwesome)</label>
                            <input type="text" name="icona" id="icona" class="form-control @error('icona') is-invalid @enderror" value="{{ old('icona', $category->icona) }}" placeholder="es: fas fa-utensils" maxlength="100">
                            @error('icona') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="colore">Colore (hex)</label>
                            <input type="color" name="colore" id="colore" class="form-control @error('colore') is-invalid @enderror" value="{{ old('colore', $category->colore) }}" style="height: 38px; padding: 2px;">
                            @error('colore') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Salva
                    </button>
                    <a href="{{ route('economy.categories.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Annulla
                    </a>
                </div>
            </form>
        </div>
    </div>
@stop
