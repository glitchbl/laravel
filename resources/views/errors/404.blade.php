@extends('layouts.client', ['breadcrumb' => [
    'Accueil' => route('home'),
    'Oops !' => null,
]])
@section('title', 'Oops !')
@section('content')
    <h1>La page demandée n'existe plus.</h1>
@endsection