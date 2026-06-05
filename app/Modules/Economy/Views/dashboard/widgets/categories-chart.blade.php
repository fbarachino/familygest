@if(isset($categories) && $categories->isNotEmpty())
    @php
        $total = $categories->sum('totale');
    @endphp
    <div class="table-responsive">
        <table class="table table-sm mb-0">
            <thead>
                <tr>
                    <th>Categoria</th>
                    <th class="text-right">Importo</th>
                    <th style="width: 120px;">%</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories->take(8) as $c)
                    @php
                        $pct = $total > 0 ? round(($c->totale / $total) * 100, 1) : 0;
                    @endphp
                    <tr>
                        <td>{{ $c->category?->nome ?? 'N/A' }}</td>
                        <td class="text-right">€ {{ number_format($c->totale, 2, ',', '.') }}</td>
                        <td>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-danger" style="width: {{ $pct }}%"></div>
                            </div>
                            <small class="text-muted">{{ $pct }}%</small>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <p class="text-muted text-center mb-0">Nessuna spesa registrata questo mese.</p>
@endif
