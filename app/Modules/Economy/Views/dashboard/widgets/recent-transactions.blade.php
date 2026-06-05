@if(isset($transactions) && $transactions->isNotEmpty())
    <table class="table table-sm table-hover mb-0">
        <thead>
            <tr>
                <th>Data</th>
                <th>Descrizione</th>
                <th>Categoria</th>
                <th>Conto</th>
                <th class="text-right">Importo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $t)
                <tr>
                    <td>{{ $t->data ? \Carbon\Carbon::parse($t->data)->format('d/m/Y') : '-' }}</td>
                    <td>{{ $t->descrizione ?? '-' }}</td>
                    <td>
                        @if($t->category)
                            <span class="badge badge-{{ $t->category->tipo === 'entrata' ? 'success' : 'danger' }}">
                                {{ $t->category->nome }}
                            </span>
                        @endif
                    </td>
                    <td>{{ $t->accountType?->nome ?? '-' }}</td>
                    <td class="text-right text-{{ $t->category?->tipo === 'entrata' ? 'success' : 'danger' }}">
                        {{ $t->category?->tipo === 'entrata' ? '+' : '-' }} € {{ number_format($t->importo, 2, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p class="text-muted text-center mb-0">Nessun movimento registrato.</p>
@endif
