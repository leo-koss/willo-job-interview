@extends('layouts.company')

@section('title', '応募者一覧')

@section('content')
    <link rel="stylesheet" href="{{ asset('/assets/css/member-list/index.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Select2 CSS -->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2 {
            /* width: auto !important; */
            min-width: 200px;
            /* force fluid responsive */
        }

        .select2-container .select2-selection--single {
            height: 40px;
            border-radius: 20px;
            position: relative;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            line-height: 40px;
        }

        .select2-container .select2-selection--single .select2-selection__arrow {
            top: 8px;
            right: 8px;
        }

        .select2-container .select2-selection--single .select2-container--default .select2-results>.select2-results__options {
            -webkit-overflow-scrolling: touch;
        }

        .select2-button {
            /* color: red; */
            background-color: #337ab7;
            padding: 5px 10px;
            cursor: pointer;
        }

        .select2-dropdown {
            /* width: 200px!important; */
            /* border-radius: 1rem; */
            /* background-color: ; */
        }


        span a {
            font-size: 12px !important;
        }

        .select-cus button {
            font-size: 13px !important;
        }

        .cus-option:hover {
            background-color: #f2f2f2;
        }
    </style>

    <main class="pt-5">
        <div class="container px-4">
            <div class="row mb-3">
                <div class="col-auto">
                    <input type="text" class="form-control rounded-pill" placeholder="応募者氏名 " name=""
                        id="search_name" value="">
                </div>
            </div>
            <div class="row justify-content-between align-items-center mb-5">
                <div class="col-lg-2 mb-3 mb-lg-0 position-relative">
                    <input name="" id="search_company" class="form-select select2 w-100 rounded-pill"
                        placeholder="会社名">
                    <div class="select-cus position-absolute card p-3 shadow rounded-4">
                        <div class="cus-search">
                            <input type="text" name="search" class="form-control select-search" placeholder="検索...">
                        </div>
                        <div class="cus-options py-2">
                            <div class="cus-notfound"><span>見つかりません</span></div>
                            @foreach ($companies as $item)
                                <div class="cus-option"><span>{{ $item->name }}</span></div>
                            @endforeach
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-primary rounded-2 ok">申し込み</button>
                            <button class="btn btn-outline-primary ms-3 rounded-2 cancel">リセット </button>
                        </div>
                        <div class="cus-bg position-fixed">

                        </div>
                    </div>
                </div>
                <div class="col-lg-2 mb-3 mb-lg-0 position-relative">
                    <input name="" id="search_job" class="form-select select2 w-100 rounded-pill"
                        placeholder="募集タイトル">
                    <div class="select-cus position-absolute card p-3 shadow rounded-4">
                        <div class="cus-search">
                            <input type="text" name="search" class="form-control select-search" placeholder="検索...">
                        </div>
                        <div class="cus-options py-2">
                            <div class="cus-notfound"><span>見つかりません</span></div>
                            <div class="cus-option"><span>{{ $name }}</span></div>
                            @foreach ($jobs as $item)
                                <div class="cus-option"><span>{{ $item->title }}</span></div>
                            @endforeach
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-primary rounded-2 ok">申し込み</button>
                            <button class="btn btn-outline-primary ms-3 rounded-2 cancel">リセット </button>
                        </div>
                        <div class="cus-bg position-fixed">

                        </div>
                    </div>
                </div>
                <div class="col-lg-2 mb-3 mb-lg-0 position-relative">
                    <input name="" id="search_owner" class="form-select select2 w-100 rounded-pill"
                        placeholder="所有者名">
                    <div class="select-cus position-absolute card p-3 shadow rounded-4">
                        <div class="cus-search">
                            <input type="text" name="search" class="form-control select-search" placeholder="検索...">
                        </div>
                        <div class="cus-options py-2">
                            <div class="cus-notfound"><span>見つかりません</span></div>
                            <div class="cus-option"><span>{{ $name }}</span></div>
                            @foreach ($owners as $item)
                                <div class="cus-option"><span>{{ $item->name }}</span></div>
                            @endforeach
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-primary rounded-2 ok">申し込み</button>
                            <button class="btn btn-outline-primary ms-3 rounded-2 cancel">リセット </button>
                        </div>
                        <div class="cus-bg position-fixed">

                        </div>
                    </div>

                </div>
                <div class="col-lg-2 mb-3 mb-lg-0 position-relative">
                    <input name="" id="search_status" class="form-select rounded-pill select2" data-no="4"
                        placeholder="現在のステータス">
                    <div class="select-cus position-absolute card p-3 shadow rounded-4">
                        <div class="cus-search">
                            <input type="text" name="search-company" class="form-control select-search"
                                placeholder="検索…">
                        </div>
                        <div class="cus-options py-2">
                            <div class="cus-notfound"><span>見つかりません</span></div>
                            <div class="cus-option"><span>レビューする</span></div>
                            <div class="cus-option"><span>承諾しました</span></div>
                            <div class="cus-option"><span>拒否されました</span></div>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-primary rounded-2 ok">申し込み</button>
                            <button class="btn btn-outline-primary ms-3 rounded-2 cancel">リセット </button>
                        </div>
                        <div class="cus-bg position-fixed">

                        </div>
                    </div>
                </div>
                <div class="col-lg-2 mb-3 mb-lg-0 position-relative">
                    <input name="" id="search_rate" class="form-select rounded-pill select2" data-no="5"
                        placeholder="評価">
                    <div class="select-cus position-absolute card p-3 shadow rounded-4">
                        <div class="cus-search">
                            <input type="text" name="search-compayny" class="form-control select-search"
                                placeholder="検索...">
                        </div>
                        <div class="cus-options py-2">
                            <div class="cus-notfound"><span>見つかりません</span></div>
                            <div class="cus-option"><span>5</span></div>
                            <div class="cus-option"><span>4</span></div>
                            <div class="cus-option"><span>3</span></div>
                            <div class="cus-option"><span>2</span></div>
                            <div class="cus-option"><span>1</span></div>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-primary rounded-2 ok">申し込み</button>
                            <button class="btn btn-outline-primary ms-3 rounded-2 cancel">リセット </button>
                        </div>
                        <div class="cus-bg position-fixed">

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-auto d-flex align-items-center gap-3 mb-4 flex-wrap">
                    <p class="m-0"><span class="filter_count">0</span>個のフィルターが選択されました</p>|
                    <p class="m-0" id="filter_clear"><a href="javascript:;">すべてクリア</a></p>
                </div>
                <div class="col-12">
                    <div class="table-responsive border rounded" style="min-height: 500px; overflow-y: auto;">
                        <table class="table" style="min-width: 992px; overflow-x: auto;">
                            <thead>
                                <tr class="bg-secondary-grey">
                                    <th class="py-4 text-center">名前</th>
                                    <th class="py-4">募集タイトル</th>
                                    <th class="py-4">提出日</th>
                                    <th class="py-4">ステータス</th>
                                    <th class="py-4">評価点</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                @foreach ($candidates as $item)
                                    <tr class="align-middle">
                                        <td class="px-3">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="col-auto">
                                                    <img src="{{ asset('/assets/img/avatar/person.png') }}"
                                                        style="max-width: 50px;" alt="">
                                                </div>
                                                <div class="col-auto">
                                                    <a class="m-0"
                                                        href="{{ route('myjob.person', ['myjob' => $item->job_id, 'candidate_id' => $item->id]) }}">{{ $item->name }}</a><br>
                                                    <a class="text-secondary"
                                                        href="{{ route('myjob.person', ['myjob' => $item->job->id, 'candidate_id' => $item->id]) }}">{{ $item->email }}</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="">
                                                <p class="m-0">{{ $item->job_title }}</p>
                                                <p class="m-0 text-secondary">{{ $item->company_name }}</p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="">
                                                <p class="m-0">
                                                    @if ($item->response_at != null)
                                                        {{ $item->response_at }}
                                                    @endif
                                                </p>
                                                <p class="m-0">
                                                    @if (date('a', strtotime($item->time)) == 'pm')
                                                        午後
                                                    @else
                                                        午前
                                                    @endif
                                                    {{ date('h:i', strtotime($item->time)) }}
                                                </p>
                                            </div>
                                        </td>
                                        <td>
                                            <h5>
                                                @if ($item->status == 'responsed')
                                                    <span
                                                        class="badge rounded-pill bg-warning text-dark bg-light-warning py-1 px-3">レビュー中</span>
                                                @endif
                                                @if ($item->status == 'accepted')
                                                    <span
                                                        class="badge rounded-pill text-dark bg-light-success py-1 px-3">承認済み</span>
                                                @endif
                                                @if ($item->status == 'rejected')
                                                    <span
                                                        class="badge rounded-pill text-dark bg-danger-subtle py-1 px-3">却下</span>
                                                @endif
                                                </span>
                                            </h5>
                                        </td>
                                        <td>
                                            <div class="">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($item->review >= $i)
                                                        <i class="fa-solid fa-star text-warning"
                                                            data-val="{{ $i }}"></i>
                                                    @else
                                                        <i class="fa-regular fa-star text-warning"
                                                            data-val="{{ $i }}"></i>
                                                    @endif
                                                @endfor
                                                <span>({{ $item->review }})</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(".select2").focus(function(e) {
            $(".select2 + .select-cus").hide();
            $(this).next().show();
            $(this).blur();
            $(".cus-bg").show();
        })

        $(".select-cus .cus-option").click(function(e) {
            $(this).parent().parent().hide();
            $(this).parent().parent().prev().val(this.textContent);
            search_job();
        })

        $(".select-cus .ok").click(function(e) {
            $(this).parent().parent().hide();
            $(this).parent().parent().prev().val($(this).parent().parent().find('input').val());
            search_job();
        })

        $(".select-cus .cancel").click(function(e) {
            $(this).parent().parent().hide();
            $(this).parent().parent().prev().val("");
        })

        $(".cus-bg").click(function(e) {
            $(this).parent().hide();
        })

        $(".select-search").keyup(function(e) {

            let listDom = e.target.parentElement.nextElementSibling.getElementsByTagName("DIV");
            let val = e.target.value.trim();
            let listData = [];
            let len = listDom.length;
            let nooptionsdom = e.target.parentElement.nextElementSibling.firstElementChild;
            nooptionsdom.style.display = "block"

            for (let i = 1; i < len; i++) {
                if (val.length == 0) {
                    listDom[i].style.display = "block";
                    nooptionsdom.style.display = "none"
                } else {
                    if (listDom[i].textContent.indexOf(val) != -1) {
                        listDom[i].style.display = "block";
                        nooptionsdom.style.display = "none"
                    } else {
                        listDom[i].style.display = "none";
                    }
                }
            }

        });

        $("#search_name, #search_company, #search_job, #search_owner, #search_status, #search_rate").change(function() {
            search_job();
        });

        function search_job() {
            let filter_count = 0;
            const name = $("#search_name").val().trim();
            const company = $("#search_company").val().trim();
            const job = $("#search_job").val().trim();
            const owner = $("#search_owner").val().trim();
            const rate = $("#search_rate").val().trim();
            let status = $("#search_status").val().trim();
            if (name != "") {
                filter_count++;
            }
            if (company != "") {
                filter_count++;
            }
            if (job != "") {
                filter_count++;
            }
            if (owner != "") {
                filter_count++;
            }
            if (rate != "") {
                filter_count++;
            }
            if (status != "") {
                filter_count++;
            }

            $(".filter_count").html(filter_count);
            switch (status) {
                case 'レビューする':
                    status = 'responsed';
                    break;
                case '承諾しました':
                    status = 'accepted';
                    break;
                case '拒否されました':
                    status = 'rejected';
                    break;
                default:
                    status = '';
            }
            $.ajax({
                url: '/member/search',
                type: 'POST',
                data: {
                    _token: $("meta[name=csrf-token]").attr("content"),
                    name,
                    company,
                    job,
                    owner,
                    status,
                    rate,
                },
                success: function(response) {
                    let dis = "";
                    response.forEach(ele => {
                        let status = "";
                        switch (ele.status) {
                            case 'responsed':
                                status =
                                    `<span class="badge rounded-pill bg-warning text-dark bg-light-warning py-1 px-3">レビューする</span>`;
                                break;
                            case 'accepted':
                                status =
                                    `<span class="badge rounded-pill text-dark  bg-light-success py-1 px-3">承認済み</span>`;
                                break;
                            case 'rejected':
                                status =
                                    `<span class="badge rounded-pill text-dark bg-danger-subtle py-1 px-3">却下</span>`;
                                break;
                        }
                        let rate = "";
                        let review = Number(ele.review) || 0;
                        for (let i = 1; i <= 5; i++) {
                            if (i <= ele.review) {
                                rate += `<i class="fa-solid fa-star text-warning"></i>`;
                            } else {
                                rate += `<i class="fa-regular fa-star text-warning"></i>`;
                            }
                        }
                        const now = new Date();
                        const options = {
                            hour: 'numeric',
                            minute: 'numeric',
                            second: 'numeric',
                            hour12: true
                        };
                        const formattedTime = now.toLocaleTimeString('ja-JP', options);
                        dis += `
                        <tr class="align-middle">
                                        <td class="px-3">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="col-auto">
                                                    <img src="{{ asset('/assets/img/avatar/person.png') }}"
                                                        style="max-width: 50px;" alt="">
                                                </div>
                                                <div class="col-auto">
                                                    <a class="m-0"
                                                        href="/myjob/${ele.job_id}/${ele.id}/edit">${ele.name}</a><br>
                                                    <a class="text-secondary" href="/myjob/${ele.job_id}/${ele.id}/edit">${ele.name}</a>${ele.email}</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="">
                                                <p class="m-0">${ele.job_title}</p>
                                                <p class="m-0 text-secondary">${ele.company_name}</p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="">
                                                <p class="m-0">
                                                    ${ele.response_at}
                                                </p>
                                                <p class="m-0">
                                                    ${formattedTime}
                                                </p>
                                            </div>
                                        </td>
                                        <td>
                                            <h5>
                                                ${status}
                                            </h5>
                                        </td>
                                        <td>
                                            <div class="">
                                            ${rate}
                                                <span>(${ele.review})</span>
                                            </div>
                                        </td>
                                    </tr>
                        `
                    });
                    $("#tbody").html(dis);
                },
                error: function(xhr, status, error) {
                    if (xhr.responseJSON.message == "Unauthenticated") {
                        window.location.reload();
                    }
                    toastr.error(xhr.responseJSON.message);
                }
            });
        }

        $("#filter_clear").click(function() {
            window.location.reload();
        });
    </script>
@endsection
