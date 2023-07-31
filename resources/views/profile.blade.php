<!DOCTYPE html>

<html lang="ru" data-bs-theme="dark">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
        <title>User profile {{ Auth::user()->name }}</title>
    </head>
    <body>
        <header class="bg-dark-subtle navbar navbar-expand-lg bd-navbar sticky-top">
            <nav class="container bd-gutter flex-wrap flex-lg-nowrap">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Input site
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Right Side Of Navbar -->
                    <div class="navbar-nav ms-auto">
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center justify-content-end" type="button" id="nav-link" data-bs-toggle="dropdown" aria-expanded="false">
                                <img class="profile-picture rounded mx-2"
                                    @if ($user->image)
                                        src="{{ Storage::url($user->image) }}" alt="User Image"
                                    @else
                                        src="{{ Storage::url('uploads/none.jpg') }}"
                                    @endif
                                >
                                {{ $user->email }}
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" type="button" href="{{ route('item.index') }}">
                                    Input Site
                                </a></li>

                                <li><a class="dropdown-item" type="button" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a></li>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <div class="container my-5">
            <div class="container w-25 align-items-center ratio ratio-1x1">
                <img class="img-fluid rounded"
                    @if ($user->image)
                        src="{{ Storage::url($user->image) }}" alt="User Image"
                    @else
                        src="{{ Storage::url('uploads/none.jpg') }}"
                    @endif
                >
                <form id="image-post-form" action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <button class="btn btn-secondary position-absolute bottom-0 end-0 m-2" type="button">
                        <i class="fa fa-plus-square"></i>
                    </button>
                    <input class="picture-input hide" type="file" accept="image/*" name="image">
                </form>
            </div>
            <form class="container input-group align-items-center w-75 my-4">
                <a href="https://t.me/InputSiteBot" class="btn btn-secondary m-4 rounded-pill">Telegram Bot</a>
                <input type="text" placeholder="Telegram token" autocomplete="off"
                    @if ($user->telegram)
                        class="rounded-start form-control is-valid"
                        value="{{ $user->telegram }}"
                    @else
                        class="rounded-start form-control is-valid"
                    @endif
                >
                <button class="btn btn-primary rounded-end" type="submit">Accept</button>
                <div
                    id="validationServerUsernameFeedback"
                    class="invalid-feedback"
                >
                    Please enter the correct token.
                </div>
            </form>
        </div>
    
        <script defer src="{{ asset('js/profile.js') }}"></script>
        <script src="https://kit.fontawesome.com/61ebb60581.js" crossorigin="anonymous"> </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    </body>
</html>
