<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - @yield('title', 'Administration')</title>

	<link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <div id="app">
		@php
			if (Auth::guard('admin')->check())
				$admin = Auth::guard('admin')->user();
		@endphp
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
            <a class="navbar-brand" href="{{ route('admin.home') }}">Administration</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar">
                @isset($admin)
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Accès Site</a>
                        </li>
                        <li class="nav-item {{ str_contains(request()->route()->getName(), 'home')? 'active': '' }}">
                            <a class="nav-link" href="{{ route('admin.home') }}">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Menu</a>
                        </li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="sous-menus" role="button" data-toggle="dropdown" aria-haspopup="true"
							aria-expanded="false">
								Sous-menus
							</a>
							<div class="dropdown-menu" aria-labelledby="sous-menus">
								<a class="dropdown-item" href="#">Sous-menu 1</a>
								<a class="dropdown-item" href="#">Sous-menu 2</a>
							</div>
						</li>
                    </ul>
                @endisset
                <ul class="ml-auto navbar-nav">
                    @isset($admin)
                        <li class="nav-item active dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                {{ $admin->email }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('admin.logout') }}" 
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                    Déconnexion
                                </a>
                                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </li>
                    @else
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('admin.login') }}">Connexion</a>
                        </li>
                    @endisset
                </ul>
            </div>
        </nav>
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
			<div class="my-2">
				@yield('content')
			</div>
		</div>
    </div>
    <script src="{{ asset('js/admin.js') }}"></script>
    @stack('scripts')
</body>
</html>