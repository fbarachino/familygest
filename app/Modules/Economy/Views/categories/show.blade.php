@extends('adminlte::page')

@section('title', $category->nome)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>{{ $category->nome }}</h1>
        <div>
            <a href="{{ route('economy.categories.edit', $category) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Modifica
            </a>
            <a href="{{ route('economy.categories.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Indietro
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="{{ $category->icona ?? 'fas fa-tag' }} fa-4x mb-3" @if($category->colore) style="color: {{ $category->colore }}" @endif></i>
                    <h4>{{ $category->nome }}</h4>
                    @if($category->tipo === 'entrata')
                        <span class="badge badge-success">Entrata</span>
                    @else
                        <span class="badge badge-danger">Spesa</span>
                    @endif
                    @if($category->colore)
                        <span class="badge" style="background-color: {{ $category->colore }}">{{ $category->colore }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Movimenti</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Importo</th>
                                <th>Descrizione</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($category->transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->data->format('d/m/Y') }}</td>
                                    <td>&euro; {{ number_format($transaction->importo, 2) }}</td>
                                    <td>{{ $transaction->descrizione ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-3">Nessun movimento per questa categoria.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
