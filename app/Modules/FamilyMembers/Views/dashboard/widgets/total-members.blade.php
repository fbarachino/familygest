<div class="text-center">
    <h3 class="mb-0">{{ $total ?? 0 }}</h3>
    <small class="text-muted">membri totali</small>
    @if(isset($new_this_month) && $new_this_month > 0)
        <div class="mt-2">
            <span class="badge badge-success">+{{ $new_this_month }} questo mese</span>
        </div>
    @endif
</div>
