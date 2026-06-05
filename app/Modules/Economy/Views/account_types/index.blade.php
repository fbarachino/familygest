@extends('adminlte::page')

@section('title', 'Tipi Conto')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Tipi Conto</h1>
        <a href="{{ route('economy.account-types.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuovo Tipo Conto
        </a>
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

    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Icona</th>
                        <th>Colore</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($accountTypes as $accountType)
                        <tr>
                            <td>
                                <a href="{{ route('economy.account-types.show', $accountType) }}">
                                    {{ $accountType->nome }}
                                </a>
                            </td>
                            <td><i class="{{ $accountType->icona ?? 'fas fa-piggy-bank' }}"></i></td>
                            <td>
                                @if($accountType->colore)
                                    <span class="badge" style="background-color: {{ $accountType->colore }}">&nbsp;&nbsp;&nbsp;</span>
                                    {{ $accountType->colore }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('economy.account-types.show', $accountType) }}" class="btn btn-sm btn-info" title="Visualizza">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('economy.account-types.edit', $accountType) }}" class="btn btn-sm btn-warning" title="Modifica">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('economy.account-types.destroy', $accountType) }}" method="POST" class="d-inline" onsubmit="return confirm('Eliminare {{ $accountType->nome }}?')">
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
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="fas fa-piggy-bank fa-3x mb-3 d-block"></i>
                                Nessun tipo conto presente.
                                <br>
                                <a href="{{ route('economy.account-types.create') }}" class="btn btn-sm btn-primary mt-2">Crea il primo tipo conto</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($accountTypes->hasPages())
            <div class="card-footer clearfix">
                {{ $accountTypes->links() }}
            </div>
        @endif
    </div>
@stop
