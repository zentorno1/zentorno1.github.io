@extends('layouts.admin.app')

@section('title', translate('Subscribed List'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center mb-3">
                <div class="col-sm flex-between">
                    <h1 class="page-header-title">{{translate('Subscribed Customers')}}
                        <span class="badge badge-soft-dark ml-2">({{ $newsletters->total() }})</span>
                    </h1>
                    <h1 style="font-size: 1.5em;"><i class="tio-email-outlined"></i></h1>
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- End Page Header -->

        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="card-header flex-end">
                <div class="">
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
                        <th>{{translate('email')}}</th>
                    </tr>
                    </thead>

                    <tbody id="set-rows">
                    @foreach($newsletters as $key=>$newsletter)
                        <tr class="">
                            <td class="">
                                {{$newsletters->firstitem()+$key}}
                            </td>
                            <td>
                                <a href="mailto:{{$newsletter['email']}}?subject={{translate('Mail from '). \App\Model\BusinessSetting::where(['key' => 'restaurant_name'])->first()->value}}">{{$newsletter['email']}}</a>
                            </td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>
            </div>
            <!-- End Table -->

            <!-- Footer -->
            <div class="card-footer">
                <div class="row">
                    <div class="col-12" style="overflow-x: scroll;">
                        {!! $newsletters->links() !!}
                    </div>
                </div>
            </div>
            <!-- End Footer -->
        </div>
        <!-- End Card -->

        <div class="modal fade" id="add-point-modal" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content" id="modal-content"></div>
            </div>
        </div>
    </div>
@endsection

@push('script_2')

@endpush
