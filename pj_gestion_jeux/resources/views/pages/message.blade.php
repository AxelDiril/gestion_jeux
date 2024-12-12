@extends('layouts/structure')

@section('titre')
    Message
@stop

@section('contenu')
    {{ $strMessage }}
    <a href="{{ $strLink }}">{{ $strLinkMessage }}</a>
@stop

