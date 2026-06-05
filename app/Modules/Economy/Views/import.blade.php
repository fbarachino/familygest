@extends('adminlte::page')

@section('title', 'Importa CSV')

@section('content_header')
    <h1>Importa Movimenti da CSV</h1>
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

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(!isset($headers))
        {{-- Step 1: Carica file CSV --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Carica file CSV</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('economy.import.preview') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="csv_file">Seleziona file CSV</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="csv_file" id="csv_file" class="custom-file-input @error('csv_file') is-invalid @enderror" accept=".csv,.txt" required>
                                <label class="custom-file-label" for="csv_file">Scegli file...</label>
                            </div>
                        </div>
                        @error('csv_file') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                        <small class="form-text text-muted">Formato: CSV. Max 2MB. La prima riga deve contenere le intestazioni delle colonne.</small>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-eye"></i> Anteprima e mappatura
                    </button>
                    <a href="{{ route('economy.transactions.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Annulla
                    </a>
                </form>
            </div>
        </div>
    @else
        {{-- Step 2: Mappa colonne --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Mappa colonne CSV</h3>
            </div>
            <div class="card-body">
                <p class="text-muted">Abbina le colonne del CSV ai campi del database. Sono obbligatori <strong>Data</strong> e <strong>Importo</strong>.</p>

                <form action="{{ route('economy.import.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="path" value="{{ $path }}">

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Campo DB</th>
                                    <th>Colonna CSV</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dbFields as $field => $label)
                                    <tr>
                                        <td>
                                            <strong>{{ $label }}</strong>
                                            @if(in_array($field, ['data', 'importo']))
                                                <span class="text-danger">*</span>
                                            @endif
                                        </td>
                                        <td>
                                            <select name="mapping[{{ $field }}]" class="form-control">
                                                <option value="">-- Non importare --</option>
                                                @foreach($headers as $header)
                                                    <option value="{{ $header }}" @if(strtolower($header) === $field) selected @endif>{{ $header }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <h5 class="mt-4">Anteprima (prime {{ count($rows) }} righe)</h5>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    @foreach($headers as $header)
                                        <th>{{ $header }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rows as $row)
                                    <tr>
                                        @foreach($headers as $header)
                                            <td>{{ $row[$header] ?? '' }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-success" onclick="return confirm('Confermi l\'importazione di tutti i dati?')">
                            <i class="fas fa-file-import"></i> Importa
                        </button>
                        <a href="{{ route('economy.import.index') }}" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Ricarica
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Re-upload form hidden for re-submit --}}
        <form id="reupload-form" action="{{ route('economy.import.preview') }}" method="POST" enctype="multipart/form-data" class="d-none">
            @csrf
            <input type="file" name="csv_file" id="reupload-input" onchange="this.form.submit()">
        </form>
    @endif

    <div class="card mt-3">
        <div class="card-header">
            <h3 class="card-title">Formato CSV Consigliato</h3>
        </div>
        <div class="card-body">
            <pre class="mb-0">data;importo;descrizione;note
01/01/2026;150.50;Spesa supermercato;acquisti mensili
05/01/2026;2500.00;Stipendio;gennaio 2026</pre>
        </div>
    </div>
@stop

@push('js')
<script>
document.getElementById('csv_file')?.addEventListener('change', function(e) {
    var fileName = e.target.files[0]?.name || 'Scegli file...';
    e.target.nextElementSibling.textContent = fileName;
});
</script>
@endpush
