@extends('adminlte::page')

@section('title', 'Movimenti')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Movimenti</h1>
        <div>
            <a href="{{ route('economy.import.index') }}" class="btn btn-info mr-2">
                <i class="fas fa-file-csv"></i> Importa CSV
            </a>
            <a href="{{ route('economy.transactions.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nuovo Movimento
            </a>
        </div>
    </div>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('import_errors'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Errori di importazione:</strong>
            <ul class="mb-0 mt-1">
                @foreach(session('import_errors') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Importo</th>
                        <th>Tipo Conto</th>
                        <th>Categoria</th>
                        <th>Descrizione</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->data->format('d/m/Y') }}</td>
                            <td>
                                <strong>&euro; {{ number_format($transaction->importo, 2) }}</strong>
                            </td>
                            <td>{{ $transaction->accountType->nome ?? '-' }}</td>
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
                            <td>{{ Str::limit($transaction->descrizione, 50) ?? '-' }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('economy.transactions.show', $transaction) }}" class="btn btn-sm btn-info" title="Visualizza">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('economy.transactions.edit', $transaction) }}" class="btn btn-sm btn-warning" title="Modifica">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('economy.transactions.destroy', $transaction) }}" method="POST" class="d-inline" onsubmit="return confirm('Eliminare questo movimento?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Elimina">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fas fa-exchange-alt fa-3x mb-3 d-block"></i>
                                Nessun movimento presente.
                                <br>
                                <a href="{{ route('economy.transactions.create') }}" class="btn btn-sm btn-primary mt-2">Registra il primo movimento</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($transactions->hasPages())
            <div class="card-footer clearfix">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
@stop
