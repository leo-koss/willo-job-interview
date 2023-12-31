@extends('layouts.company')

@section('title', '会社一覧')

@section('content')
    <link rel="stylesheet" href="{{ asset('/assets/css/companyMana/list.css') }}">
    <script src="{{ asset('/assets/js/common/jquery.min.js') }}"></script>
    <main class="pt-5">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <div class="container">
            <div class="row">
                @foreach ($list as $item)
                    <div class="col-lg-4 mb-3 company-item">
                        <div class="w-100 bordered rounded shadow-sm py-4 px-3">
                            <div class="col-12 px-2 d-flex justify-content-between align-items-center mb-3">
                                <a class="m-0"
                                    href="{{ route('company.detail', ['id' => $item->id]) }}">{{ $item->name }}</a>
                                @if ($item->default == 'true')
                                    <p class="text-active m-0 company-default">デフォルト <i
                                            class="fa fa-solid fa-circle-check"></i></p>
                                @endif
                            </div>
                            <div class="col-12 px-2 d-flex justify-content-between align-items-center">
                                <p class="m-0">求人 {{ $item->candidates_count }}</p>
                                <div class="">
                                    <a href="{{ route('company.edit', ['id' => $item->id]) }}" class="me-2"><i
                                            class="fa fa-edit"></i></a>

                                    @if ($item->default != 'true')
                                        <a href="javascript:;" class="item-delete"
                                            data-url="{{ route('company.destroy', ['id' => $item->id]) }}" class="ms-2"><i
                                                class="fa fa-trash"></i></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="col-lg-4">
                    <a class="d-flex flex-column align-items-center w-100 bordered rounded shadow-sm py-4 px-3 text-active"
                        href="{{ route('company.create') }}">
                        <i class="fa fa-solid fa-plus fs-2 mb-2"></i>
                        <span>会社の作成</span>
                    </a>
                </div>
            </div>
        </div>
    </main>
    <script>
        $(".item-delete").click(function(e) {
            $(e.target).parents(".company-item");
            const url = $(e.currentTarget).attr("data-url");
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: $("meta[name=csrf-token]").attr("content"),
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr, status, error) {
                    if (xhr.responseJSON.message == "Unauthenticated") {
                        window.location.reload();
                    }
                    toastr.error(xhr.responseJSON.message);
                }
            });
        })
    </script>
@endsection
