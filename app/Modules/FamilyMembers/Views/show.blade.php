@extends('adminlte::page')

@section('title', $familyMember->nome . ' ' . $familyMember->cognome)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>{{ $familyMember->nome }} {{ $familyMember->cognome }}</h1>
        <div>
            <a href="{{ route('family-members.edit', $familyMember) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Modifica
            </a>
            <a href="{{ route('family-members.index') }}" class="btn btn-secondary">
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
                    @if($familyMember->foto_url)
                        <img src="{{ $familyMember->foto_url }}" alt="{{ $familyMember->nome }}" class="img-circle img-fluid" style="max-width: 200px;">
                    @else
                        <i class="fas fa-user-circle fa-6x text-muted"></i>
                    @endif
                    <h3 class="mt-3">{{ $familyMember->nome }} {{ $familyMember->cognome }}</h3>
                    <span class="badge badge-info badge-lg">{{ ucfirst($familyMember->relazione) }}</span>
                    <p class="text-muted mt-2">{{ $familyMember->eta }} anni</p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Dettagli</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 200px;">Nome Completo</th>
                            <td>{{ $familyMember->cognome }} {{ $familyMember->nome }}</td>
                        </tr>
                        <tr>
                            <th>Data di Nascita</th>
                            <td>{{ $familyMember->data_nascita->format('d/m/Y') }} ({{ $familyMember->eta }} anni)</td>
                        </tr>
                        <tr>
                            <th>Luogo di Nascita</th>
                            <td>{{ $familyMember->luogo_nascita ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Relazione</th>
                            <td><span class="badge badge-info">{{ ucfirst($familyMember->relazione) }}</span></td>
                        </tr>
                        <tr>
                            <th>Codice Fiscale</th>
                            <td><code>{{ $familyMember->codice_fiscale ?? '-' }}</code></td>
                        </tr>
                        <tr>
                            <th>Telefono</th>
                            <td>{{ $familyMember->telefono ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $familyMember->email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Indirizzo</th>
                            <td>{{ $familyMember->indirizzo ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Note</th>
                            <td>{{ $familyMember->note ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Creato il</th>
                            <td>{{ $familyMember->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Ultima modifica</th>
                            <td>{{ $familyMember->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
