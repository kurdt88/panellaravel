
@extends('adminlte::page')

@section('title', 'Panel de Inicio')

@section('content_header')
    <h1>Se agrego una nueva propiedad</h1>
@stop

@section('content')
    <p>Listando propiedades...</p>

@foreach ($properties as $property)
<p> {{$property->title}},
    {{$property->tags}},
    {{$property->rent}},
    {{$property->location}},
    {{$property->website}},
    {{$property->description}},
    {{$property->available}}</p>
@endforeach


@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop