<!DOCTYPE html>

<html lang="ru">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ"
            crossorigin="anonymous"
        />
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
        <title>Input site</title>
    </head>
    <body>
        <div id="app" v-cloak>
            <form class="input-group mx-auto w-50" action="{{ route('item.store', ['sorting' => $sorting]) }}" method="post">
                @csrf
                <input
                    type="text"
                    class="form-control"
                    placeholder="Enter a list item"
                    name="name"
                    v-model="inputValue"
                    @keypress="nonCorrectInput = false"
                    @keypress.Enter="checkInputValue($event, inputValue)"
                    :class="{'is-invalid' : nonCorrectInput }"
                />
                <button
                    type="submit"
                    class="btn btn-primary"
                    @click="checkInputValue($event, inputValue)"
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
                        @click="redirectToRoute('{{ route('item.show', ['sorting' => $i]) }}')"
                        @if($sorting == $i) checked @endif
                    >
                    <label class="form-check-label" v-text="sortings[{{$i}}]"></label>
                </div>
                @endfor
            </div>

            <div class="p-3">
                <h1 class="text-center">Items list</h1>
                <ol class="main-ol container w-50">
                    @foreach($items as $item)
                        <li
                            class="col text-center pb-1"
                            :data-id="{{ $item->data_id }}"
                        >
                            <form
                                action="{{ route('item.delete', ['item' => $item ,'sorting' => $sorting]) }}"
                                method="post"
                                v-show="editId !== {{ $item->data_id }}"
                            >
                                @csrf
                                @method('delete')
                                <label
                                    class="text-break text-start w-50"
                                    >{{ $item->name }}</label
                                >
                                <button
                                    class="btn btn-outline-secondary btn-sm p-1 me-1"
                                    type="button"
                                    @click="activeEditing($event, {{ $item }} )"
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
                                action="{{ route('item.update', ['item' => $item ,'sorting' => $sorting]) }}"
                                method="post"
                                v-show="editId === {{ $item->data_id }}"
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
                                    class="btn btn-outline-danger btn-sm p-1 me-1"
                                    type="button"
                                    @click="cancelRenaming"
                                >
                                    Cancel
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>

        <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
        <script defer src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
