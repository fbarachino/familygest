<div class="text-center">
    @php
        $balanceClass = $balance >= 0 ? 'text-success' : 'text-danger';
    @endphp
    <h3 class="mb-0 {{ $balanceClass }}">
        € {{ number_format($balance ?? 0, 2, ',', '.') }}
    </h3>
    <small class="text-muted">bilancio mensile</small>
    <div class="mt-2 small">
        <span class="text-success">↑ € {{ number_format($income ?? 0, 2, ',', '.') }}</span>
        <span class="mx-1">/</span>
        <span class="text-danger">↓ € {{ number_format($expense ?? 0, 2, ',', '.') }}</span>
    </div>
</div>
