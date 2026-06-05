@extends('adminlte::page')

@section('title', 'Impostazioni Dashboard')

@section('content_header')
    <h1>Impostazioni Dashboard</h1>
@stop

@section('content')
    <form action="{{ route('dashboard.settings.update') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body">
                <p class="text-muted">Seleziona i widget da visualizzare nella dashboard e definisci il loro ordine.</p>

                <div id="widget-list">
                    @foreach($widgetPrefs as $id => $pref)
                        <div class="widget-item card mb-2 @if($pref['enabled']) border-primary @else border-light @endif"
                             data-widget-id="{{ $id }}">
                            <div class="card-body py-2">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <i class="{{ $pref['widget']->icon }} fa-fw text-muted"></i>
                                    </div>
                                    <div class="col">
                                        <strong>{{ $pref['widget']->title }}</strong>
                                        <small class="text-muted d-block">{{ $pref['widget']->description }}</small>
                                    </div>
                                    <div class="col-auto">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox"
                                                   class="custom-control-input widget-enabled"
                                                   id="switch-{{ $id }}"
                                                   name="widgets[{{ $loop->index }}][widget_id]"
                                                   value="{{ $id }}"
                                                   {{ $pref['enabled'] ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="switch-{{ $id }}">
                                                {{ $pref['enabled'] ? 'Attivo' : 'Disattivato' }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <input type="hidden"
                                               name="widgets[{{ $loop->index }}][enabled]"
                                               value="0">
                                        <input type="checkbox"
                                               name="widgets[{{ $loop->index }}][enabled]"
                                               value="1"
                                               {{ $pref['enabled'] ? 'checked' : '' }}>
                                    </div>
                                    <div class="col-auto">
                                        <select name="widgets[{{ $loop->index }}][column_width]"
                                                class="form-control form-control-sm"
                                                style="width: 80px;">
                                            <option value="">Auto</option>
                                            @foreach([3, 4, 6, 8, 12] as $w)
                                                <option value="{{ $w }}"
                                                    {{ ($pref['widget']->width == $w) ? 'selected' : '' }}>
                                                    {{ $w }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <button type="button"
                                                class="btn btn-sm btn-light move-up"
                                                {{ $loop->first ? 'disabled' : '' }}>
                                            <i class="fas fa-arrow-up"></i>
                                        </button>
                                        <button type="button"
                                                class="btn btn-sm btn-light move-down"
                                                {{ $loop->last ? 'disabled' : '' }}>
                                            <i class="fas fa-arrow-down"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ route('home') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Torna alla Dashboard
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Salva Impostazioni
                </button>
            </div>
        </div>
    </form>
@stop

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const list = document.getElementById('widget-list');

    document.querySelectorAll('.move-up').forEach(btn => {
        btn.addEventListener('click', function () {
            const item = this.closest('.widget-item');
            const prev = item.previousElementSibling;
            if (prev) {
                list.insertBefore(item, prev);
                reindex();
            }
        });
    });

    document.querySelectorAll('.move-down').forEach(btn => {
        btn.addEventListener('click', function () {
            const item = this.closest('.widget-item');
            const next = item.nextElementSibling;
            if (next) {
                list.insertBefore(next, item);
                reindex();
            }
        });
    });

    function reindex() {
        const items = list.querySelectorAll('.widget-item');
        items.forEach((item, i) => {
            const id = item.dataset.widgetId;
            const inputs = item.querySelectorAll('input, select');
            inputs.forEach(input => {
                input.name = input.name.replace(/\[\d+\]/, `[${i}]`);
            });
            item.querySelector('.move-up').disabled = (i === 0);
            item.querySelector('.move-down').disabled = (i === items.length - 1);
        });
    }
});
</script>
@stop
