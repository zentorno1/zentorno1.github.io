@extends('layouts.admin.app')

@section('title', translate('Review List'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0 flex-between">
                    <h1 class="page-header-title"><i class="tio-filter-list"></i> {{translate('Review List')}}</h1>
                </div>
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
                            <h5 class="card-header-title">{{translate('Review list Table')}}</h5>
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
                        <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                               data-hs-datatables-options='{
                                 "order": [],
                                 "orderCellsTop": true
                               }'>
                            <thead class="thead-light">
                            <tr>
                                <th>{{translate('#')}}</th>
                                <th style="width: 30%">{{translate('deliveryman')}}</th>
                                <th style="width: 25%">{{translate('customer')}}</th>
                                <th>{{translate('review')}}</th>
                                <th>{{translate('rating')}}</th>
                            </tr>
                            {{-- <tr>
                                <th></th>
                                <th>
                                    <input type="text" id="column1_search" class="form-control form-control-sm"
                                           placeholder="Search">
                                </th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr> --}}
                            </thead>

                            <tbody>
                            @foreach($reviews as $key=>$review)
                                <tr>
                                    <td>{{$reviews->firstItem()+$key}}</td>
                                    <td>
                                        <span class="d-block font-size-sm text-body">
                                            @if($review->delivery_man)
                                                <a href="{{route('admin.delivery-man.preview',[$review['delivery_man_id']])}}">
                                                    {{$review->delivery_man->f_name.' '.$review->delivery_man->l_name}}
                                                </a>
                                            @else
                                                <span class="badge-pill badge-soft-dark text-muted text-sm small">
                                                        {{\App\CentralLogics\translate('DeliveryMan unavailable')}}
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
                        <table>
                            <tfoot>
                            {!! $reviews->links() !!}
                            </tfoot>
                        </table>
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
        $(document).on('ready', function () {
            // INITIALIZATION OF DATATABLES
            // =======================================================
            var datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));

            $('#column1_search').on('keyup', function () {
                datatable
                    .columns(1)
                    .search(this.value)
                    .draw();
            });

            $('#column2_search').on('keyup', function () {
                datatable
                    .columns(2)
                    .search(this.value)
                    .draw();
            });

            $('#column3_search').on('change', function () {
                datatable
                    .columns(3)
                    .search(this.value)
                    .draw();
            });

            $('#column4_search').on('keyup', function () {
                datatable
                    .columns(4)
                    .search(this.value)
                    .draw();
            });


            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });
    </script>
@endpush
