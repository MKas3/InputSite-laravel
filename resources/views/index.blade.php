<!DOCTYPE html>

<html lang="ru" data-bs-theme="dark">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
        <title>Input site</title>
    </head>
    <body>
        @php
            $user = Auth::user();
        @endphp
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
                                <li><a class="dropdown-item" type="button" href="{{ route('user.index') }}">
                                    Profile
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
        <form class="input-group mx-auto w-50 py-4" action="{{ route('item.store', ['sort_field' => $sort_field, 'sort_order' => $sort_order]) }}" method="post">
            @csrf
            <input
                type="text"
                class="form-control"
                placeholder="Enter a list item"
                name="name"
            />
            <button
                type="submit"
                class="btn btn-primary"
            >
                Add
            </button>
            <div
                id="validationServerUsernameFeedback"
                class="invalid-feedback"
            >
                Please enter the correct name.
            </div>
            
        </form>

        <div class="container w-50">
            @for ($i = 0; $i < 4; $i++)
            <div class="form-check text-center my-2">
                <input
                    class="form-check-input"
                    type="radio"
                    name="radio-button"
                    @if(($sort_field === "data_id" 
                            && ($sort_order === "asc" && $i === 0 || $sort_order === "desc" && $i === 1))
                        || $sort_field === "name" 
                            && ($sort_order === "asc" && $i === 2 || $sort_order === "desc" && $i === 3)) 
                            checked
                    @endif
                >
                <label class="form-check-label"></label>
            </div>
            @endfor
        </div>

        <div class="p-3">
            <h1 class="text-center">Items list</h1>
            <ol class="main-ol container w-50">
                @foreach($items as $item)
                    <li
                        class="col text-center pb-1"
                        data-id="{{ $item->data_id }}"
                    >
                        <form
                            class="nonEditMode"
                            action="{{ route('item.delete', ['item' => $item, 'sort_field' => $sort_field, 'sort_order' => $sort_order]) }}"
                            method="post"
                        >
                            @csrf
                            @method('delete')
                            <label
                                class="text-break text-start w-50"
                                >{{ $item->name }}</label
                            >
                            <button
                                class="edit-btn btn btn-outline-secondary btn-sm p-1 me-1"
                                type="button"
                                onclick="activeEditing(event, {{ $item }})"
                            >
                                Edit
                            </button>
                        
                            <button
                                class="btn btn-outline-danger btn-sm p-1 me-1"
                                type="submit"
                            >
                                X
                            </button>
                        </form>
                        <form
                            class="editMode hidden"
                            action="{{ route('item.update', ['item' => $item, 'sort_field' => $sort_field, 'sort_order' => $sort_order]) }}"
                            method="post"
                        >
                            @csrf
                            @method('patch')
                            <input
                                class="w-50 itemInput"
                                name="name"
                            />
                            <button
                                class="btn btn-outline-success btn-sm p-1 me-1"
                                type="submit"
                            >
                                OK
                            </button>
                            <button
                                class="cancel-btn btn btn-outline-danger btn-sm p-1 me-1"
                                type="button"
                                onclick="cancelRenaming(event)"
                            >
                                Cancel
                            </button>
                        </form>
                    </li>
                @endforeach
            </ol>
        </div>

        <script defer src="{{ asset('js/index.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    </body>
</html>
