@extends('adminlte::page')

@section('title', $accountType->nome)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>{{ $accountType->nome }}</h1>
        <div>
            <a href="{{ route('economy.account-types.edit', $accountType) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Modifica
            </a>
            <a href="{{ route('economy.account-types.index') }}" class="btn btn-secondary">
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
                    <i class="{{ $accountType->icona ?? 'fas fa-piggy-bank' }} fa-4x mb-3" @if($accountType->colore) style="color: {{ $accountType->colore }}" @endif></i>
                    <h4>{{ $accountType->nome }}</h4>
                    @if($accountType->colore)
                        <span class="badge" style="background-color: {{ $accountType->colore }}">{{ $accountType->colore }}</span>
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
                            @forelse($accountType->transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->data->format('d/m/Y') }}</td>
                                    <td>&euro; {{ number_format($transaction->importo, 2) }}</td>
                                    <td>{{ $transaction->descrizione ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-3">Nessun movimento per questo tipo conto.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
