@extends('adminlte::page')

@section('title', 'Family Members')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Membri della Famiglia</h1>
        <a href="{{ route('family-members.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuovo Membro
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
                        <th>Foto</th>
                        <th>Nome e Cognome</th>
                        <th>Data di Nascita</th>
                        <th>Età</th>
                        <th>Relazione</th>
                        <th>Codice Fiscale</th>
                        <th>Telefono</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $member)
                        <tr>
                            <td>
                                @if($member->foto_url)
                                    <img src="{{ $member->foto_url }}" alt="{{ $member->nome }}" class="img-circle img-size-32">
                                @else
                                    <span class="fas fa-user-circle fa-2x text-muted"></span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('family-members.show', $member) }}">
                                    {{ $member->cognome }} {{ $member->nome }}
                                </a>
                            </td>
                            <td>{{ $member->data_nascita->format('d/m/Y') }}</td>
                            <td>{{ $member->eta }} anni</td>
                            <td><span class="badge badge-info">{{ ucfirst($member->relazione) }}</span></td>
                            <td><code>{{ $member->codice_fiscale ?? '-' }}</code></td>
                            <td>{{ $member->telefono ?? '-' }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('family-members.show', $member) }}" class="btn btn-sm btn-info" title="Visualizza">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('family-members.edit', $member) }}" class="btn btn-sm btn-warning" title="Modifica">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('family-members.destroy', $member) }}" method="POST" class="d-inline" onsubmit="return confirm('Sei sicuro di voler eliminare {{ $member->nome }} {{ $member->cognome }}?')">
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
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="fas fa-users fa-3x mb-3 d-block"></i>
                                Nessun membro della famiglia presente.
                                <br>
                                <a href="{{ route('family-members.create') }}" class="btn btn-sm btn-primary mt-2">Aggiungi il primo membro</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($members->hasPages())
            <div class="card-footer clearfix">
                {{ $members->links() }}
            </div>
        @endif
    </div>
@stop
