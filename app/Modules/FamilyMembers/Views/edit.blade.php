@extends('adminlte::page')

@section('title', 'Modifica Membro')

@section('content_header')
    <h1>Modifica Membro della Famiglia</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('family-members.update', $familyMember) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nome">Nome <span class="text-danger">*</span></label>
                            <input type="text" name="nome" id="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome', $familyMember->nome) }}" required maxlength="255">
                            @error('nome') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cognome">Cognome <span class="text-danger">*</span></label>
                            <input type="text" name="cognome" id="cognome" class="form-control @error('cognome') is-invalid @enderror" value="{{ old('cognome', $familyMember->cognome) }}" required maxlength="255">
                            @error('cognome') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="data_nascita">Data di Nascita <span class="text-danger">*</span></label>
                            <input type="date" name="data_nascita" id="data_nascita" class="form-control @error('data_nascita') is-invalid @enderror" value="{{ old('data_nascita', $familyMember->data_nascita->format('Y-m-d')) }}" required>
                            @error('data_nascita') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="luogo_nascita">Luogo di Nascita</label>
                            <input type="text" name="luogo_nascita" id="luogo_nascita" class="form-control @error('luogo_nascita') is-invalid @enderror" value="{{ old('luogo_nascita', $familyMember->luogo_nascita) }}" maxlength="255">
                            @error('luogo_nascita') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="relazione">Relazione <span class="text-danger">*</span></label>
                            <select name="relazione" id="relazione" class="form-control @error('relazione') is-invalid @enderror" required>
                                <option value="">Seleziona...</option>
                                @foreach($relazioni as $relazione)
                                    <option value="{{ $relazione }}" {{ old('relazione', $familyMember->relazione) == $relazione ? 'selected' : '' }}>{{ ucfirst($relazione) }}</option>
                                @endforeach
                            </select>
                            @error('relazione') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="codice_fiscale">Codice Fiscale</label>
                            <input type="text" name="codice_fiscale" id="codice_fiscale" class="form-control @error('codice_fiscale') is-invalid @enderror" value="{{ old('codice_fiscale', $familyMember->codice_fiscale) }}" maxlength="16" style="text-transform: uppercase">
                            @error('codice_fiscale') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="telefono">Telefono</label>
                            <input type="text" name="telefono" id="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono', $familyMember->telefono) }}" maxlength="20">
                            @error('telefono') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $familyMember->email) }}" maxlength="255">
                            @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="indirizzo">Indirizzo</label>
                            <input type="text" name="indirizzo" id="indirizzo" class="form-control @error('indirizzo') is-invalid @enderror" value="{{ old('indirizzo', $familyMember->indirizzo) }}" maxlength="255">
                            @error('indirizzo') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="foto">Foto</label>
                            @if($familyMember->foto_url)
                                <div class="mb-2">
                                    <img src="{{ $familyMember->foto_url }}" alt="{{ $familyMember->nome }}" class="img-circle img-size-64">
                                </div>
                            @endif
                            <input type="file" name="foto" id="foto" class="form-control-file @error('foto') is-invalid @enderror" accept="image/jpeg,image/png,image/webp">
                            @error('foto') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            <small class="form-text text-muted">Lascia vuoto per mantenere la foto attuale. Formati: jpg, jpeg, png, webp. Max 2MB.</small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="note">Note</label>
                    <textarea name="note" id="note" rows="3" class="form-control @error('note') is-invalid @enderror" maxlength="5000">{{ old('note', $familyMember->note) }}</textarea>
                    @error('note') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Aggiorna
                    </button>
                    <a href="{{ route('family-members.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Annulla
                    </a>
                </div>
            </form>
        </div>
    </div>
@stop
