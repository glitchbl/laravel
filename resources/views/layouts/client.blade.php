<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - @yield('title', 'Accueil')</title>

	<link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <link href="{{ asset('css/client.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <div id="app">
		@php
			if (Auth::guard('client')->check())
				$client = Auth::guard('client')->user();
		@endphp
		@isset($client)
			{{ $client->email }}
			<a href="{{ route('logout') }}"
				onclick="event.preventDefault();document.getElementById('logout-form').submit();">
				Déconnexion
			</a>
			<form id="logout-form" action="{{ route('logout') }}" method="post" style="display: none;">
				{{ csrf_field() }}
			</form>
		@endisset
		<div class="container">
			@isset($breadcrumb)
				@include('includes.breadcrumb')
			@endisset
			<noscript>
				<div class="alert alert-danger">
					Pour accéder aux fonctionnalités de ce site, vous devez activer JavaScript.
					Voici les <a href="http://www.enable-javascript.com/fr/" target="_blank">
					instructions pour activer JavaScript dans votre navigateur Web</a>.
				</div>
			</noscript>
			@includeWhen(!isset($hide_messages) || !$hide_messages, 'includes.messages')
			<div class="mt-2">
				@yield('content')
			</div>
		</div>
    </div>
    <script src="{{ asset('js/client.js') }}"></script>
    @stack('scripts')
</body>
</html>