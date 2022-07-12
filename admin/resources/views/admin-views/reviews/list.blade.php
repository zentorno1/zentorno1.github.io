@extends('layouts.admin.app')

@section('title', translate('Review List'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="flex-between">
                <h1 class="page-header-title"><i class="tio-filter-list"></i> {{translate('review list')}}</h1>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <!-- Card -->
                <div class="card">
                    <!-- Header -->
                    <div class="card-header flex-between">
                        <div class="flex-start">
                            <h5 class="card-header-title">{{translate('Review Table')}}</h5>
                            <h5 class="card-header-title text-primary mx-1">({{ $reviews->total() }})</h5>
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
                        <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light">
                            <tr>
                                <th>{{translate('#')}}</th>
                                <th style="width: 30%">{{translate('product')}}</th>
                                <th style="width: 25%">{{translate('customer')}}</th>
                                <th>{{translate('review')}}</th>
                                <th>{{translate('rating')}}</th>
                            </tr>
                            </thead>

                            <tbody id="set-rows">
                            @foreach($reviews as $key=>$review)
                                <tr>
                                    <td>{{$reviews->firstItem()+$key}}</td>
                                    <td>
                                        <span class="d-block font-size-sm text-body">
                                            @if($review->product)
                                                <a href="{{route('admin.product.view',[$review['product_id']])}}">
                                                    {{$review->product['name']}}
                                                </a>
                                            @else
                                                <span class="badge-pill badge-soft-dark text-muted text-sm small">
                                                        {{\App\CentralLogics\translate('Product unavailable')}}
                                                    </span>
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        @if(isset($review->customer))
                                            <a href="{{route('admin.customer.view',[$review->user_id])}}">
                                                {{$review->customer->f_name." ".$review->customer->l_name}}
                                            </a>
                                        @else
                                            <span class="badge-pill badge-soft-dark text-muted text-sm small">
                                                        {{\App\CentralLogics\translate('Customer unavailable')}}
                                                    </span>
                                        @endif
                                    </td>
                                    <td>
                                        {{$review->comment}}
                                    </td>
                                    <td>
                                        <label class="badge badge-soft-info">
                                            {{$review->rating}} <i class="tio-star"></i>
                                        </label>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <hr>
                        <div class="page-area">
                            <table>
                                <tfoot>
                                {!! $reviews->links() !!}
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- End Table -->
                </div>
                <!-- End Card -->
            </div>
        </div>
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
                url: '{{route('admin.reviews.search')}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#set-rows').html(data.view);
                    $('.page-area').hide();
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        });
    </script>
@endpush
