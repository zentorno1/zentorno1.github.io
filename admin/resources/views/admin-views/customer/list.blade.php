@extends('layouts.admin.app')

@section('title', translate('Customer List'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center mb-3">
                <div class="col-sm flex-between">
                    <h1 class="page-header-title">{{translate('customers')}}
                        <span class="badge badge-soft-dark ml-2">{{\App\User::count()}}</span>
                    </h1>
                    <h1 style="font-size: 2em"><i class="tio-poi-user"></i></h1>
                </div>
            </div>
            <!-- End Row -->

{{--            <!-- Nav Scroller -->--}}
{{--            <div class="js-nav-scroller hs-nav-scroller-horizontal">--}}
{{--            <span class="hs-nav-scroller-arrow-prev" style="display: none;">--}}
{{--              <a class="hs-nav-scroller-arrow-link" href="javascript:;">--}}
{{--                <i class="tio-chevron-left"></i>--}}
{{--              </a>--}}
{{--            </span>--}}

{{--                <span class="hs-nav-scroller-arrow-next" style="display: none;">--}}
{{--              <a class="hs-nav-scroller-arrow-link" href="javascript:;">--}}
{{--                <i class="tio-chevron-right"></i>--}}
{{--              </a>--}}
{{--            </span>--}}
{{--            </div>--}}
{{--            <!-- End Nav Scroller -->--}}
        </div>
        <!-- End Page Header -->

        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="card-header flex-between">
                <div class="flex-start">
                    <h5 class="card-header-title">{{translate('Customer Table')}}</h5>
                    <h5 class="card-header-title text-primary mx-1">({{ $customers->total() }})</h5>
                </div>
                <div>
                    <form action="{{url()->current()}}" method="GET">
                        <div class="input-group">
                            <input id="datatableSearch_" type="search" name="search"
                                   class="form-control"
                                   placeholder="{{translate('Search')}}" aria-label="Search"
                                   value="{{$search}}" required autocomplete="off">
                            <div class="input-group-append">
                                <button type="submit" class="input-group-text"><i class="tio-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- End Header -->

            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                       style="width: 100%">
                    <thead class="thead-light">
                    <tr>
                        <th class="">
                            {{translate('#')}}
                        </th>
                        <th class="table-column-pl-0">{{translate('name')}}</th>
                        <th>{{translate('email')}}</th>
                        <th>{{translate('phone')}}</th>
                        <th>{{translate('total')}} {{translate('order')}}</th>
                    </tr>
                    </thead>

                    <tbody id="set-rows">
                    @foreach($customers as $key=>$customer)
                        <tr class="">
                            <td class="">
                                {{$customers->firstItem()+$key}}
                            </td>
                            <td class="table-column-pl-0">
                                <a href="{{route('admin.customer.view',[$customer['id']])}}">
                                    {{$customer['f_name']." ".$customer['l_name']}}
                                </a>
                            </td>
                            <td>
                                {{$customer['email']}}
                            </td>
                            <td>
                               {{$customer['phone']}}
                            </td>
                            <td>
                                <label class="badge badge-soft-info">
                                    {{$customer->orders->count()}}
                                </label>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- End Table -->

            <!-- Footer -->
            <div class="card-footer">
                <!-- Pagination -->
                <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
                    <div class="col-sm-auto">
                        <div class="d-flex justify-content-center justify-content-sm-end">
                            <!-- Pagination -->
                            {!! $customers->links() !!}
                            {{--<nav id="datatablePagination" aria-label="Activity pagination"></nav>--}}
                        </div>
                    </div>
                </div>
                <!-- End Pagination -->
            </div>
            <!-- End Footer -->
        </div>
        <!-- End Card -->
    </div>
@endsection

@push('script_2')
    <script>
        $('#search-form').on('submit', function () {
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.customer.search')}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#set-rows').html(data.view);
                    $('.card-footer').hide();
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        });
    </script>
@endpush
