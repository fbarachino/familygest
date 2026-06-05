@extends('adminlte::page')

@section('title', 'Categorie')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Categorie</h1>
        <a href="{{ route('economy.categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuova Categoria
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
                        <th>Tipo</th>
                        <th>Nome</th>
                        <th>Icona</th>
                        <th>Colore</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>
                                @if($category->tipo === 'entrata')
                                    <span class="badge badge-success">Entrata</span>
                                @else
                                    <span class="badge badge-danger">Spesa</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('economy.categories.show', $category) }}">
                                    {{ $category->nome }}
                                </a>
                            </td>
                            <td><i class="{{ $category->icona ?? 'fas fa-tag' }}"></i></td>
                            <td>
                                @if($category->colore)
                                    <span class="badge" style="background-color: {{ $category->colore }}">&nbsp;&nbsp;&nbsp;</span>
                                    {{ $category->colore }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('economy.categories.show', $category) }}" class="btn btn-sm btn-info" title="Visualizza">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('economy.categories.edit', $category) }}" class="btn btn-sm btn-warning" title="Modifica">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('economy.categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Eliminare {{ $category->nome }}?')">
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
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="fas fa-tags fa-3x mb-3 d-block"></i>
                                Nessuna categoria presente.
                                <br>
                                <a href="{{ route('economy.categories.create') }}" class="btn btn-sm btn-primary mt-2">Crea la prima categoria</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($categories->hasPages())
            <div class="card-footer clearfix">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
@stop
