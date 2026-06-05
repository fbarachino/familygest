<div class="text-center">
    <h3 class="mb-0 text-{{ $tipo === 'entrata' ? 'success' : 'danger' }}">
        € {{ number_format($total ?? 0, 2, ',', '.') }}
    </h3>
    <small class="text-muted">{{ $tipo === 'entrata' ? 'entrate' : 'spese' }} del mese</small>
</div>
