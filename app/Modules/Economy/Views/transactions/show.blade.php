@extends('adminlte::page')

@section('title', 'Dettaglio Movimento')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Dettaglio Movimento</h1>
        <div>
            <a href="{{ route('economy.transactions.edit', $transaction) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Modifica
            </a>
            <a href="{{ route('economy.transactions.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Indietro
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width: 200px;">Data</th>
                    <td>{{ $transaction->data->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th>Importo</th>
                    <td><strong>&euro; {{ number_format($transaction->importo, 2) }}</strong></td>
                </tr>
                <tr>
                    <th>Tipo Conto</th>
                    <td>{{ $transaction->accountType->nome ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Categoria</th>
                    <td>
                        @if($transaction->category)
                            @if($transaction->category->tipo === 'entrata')
                                <span class="badge badge-success">{{ $transaction->category->nome }}</span>
                            @else
                                <span class="badge badge-danger">{{ $transaction->category->nome }}</span>
                            @endif
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Descrizione</th>
                    <td>{{ $transaction->descrizione ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Note</th>
                    <td>{{ $transaction->note ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Registrato il</th>
                    <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            </table>
        </div>
    </div>
@stop
