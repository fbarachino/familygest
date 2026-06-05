@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Dashboard</h1>
        <a href="{{ route('dashboard.settings') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-cog"></i> Personalizza
        </a>
    </div>
@stop

@section('content')
    @if($widgets->isEmpty())
        <div class="alert alert-info">
            Nessun widget attivo.
            <a href="{{ route('dashboard.settings') }}" class="alert-link">Personalizza la tua dashboard</a>
            per aggiungere widget.
        </div>
    @else
        <div class="row">
            @foreach($widgets as $widget)
                <div class="col-md-{{ $widget->width }} mb-4">
                    <x-adminlte-card :title="$widget->title" :icon="$widget->icon" theme="light" collapsible removable>
                        @include($widget->view, $widgetData[$widget->id] ?? [])
                    </x-adminlte-card>
                </div>
            @endforeach
        </div>
    @endif
@stop
