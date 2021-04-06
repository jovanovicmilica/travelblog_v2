@extends('layouts.layout')

@section('keywords') Author @endsection
@section('description') Author - Jovanovic Milica @endsection
@section('content')
<div id="naslov">
    <h1>Author</h1>
</div>
    <div id="auth">
        <img src="{{asset("assets/images/autor.jpg")}}">
        <h2>Jovanovic Milica</h2>
        <a href="https://github.com/jovanovicmilica" target="_blank">Github</a>
        <a href="https://www.linkedin.com/in/milica-jovanovic-313ab256/" target="_blank">Linkedin</a>
    </div>


@endsection
