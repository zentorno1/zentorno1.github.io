@extends('layouts.admin.app')

@section('title', translate('Banner List'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="align-items-center">
                <div class="flex-between">
                    <h1 class="page-header-title"></i> {{translate('banner')}} {{translate('list')}}</h1>
                    <h1 style="font-size: 1.5em"><i class="tio-filter-list"></i></h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <!-- Card -->
                <div class="card">
                    <!-- Header -->
                    <div class="card-header">
                        <div class="col-md-4">
                            <h5>{{translate('Banner Table')}} <span class="text-primary">({{ $banners->total() }})</span></h5>
                        </div>
                        <a href="{{route('admin.banner.add-new')}}" class="btn btn-primary pull-right"><i
                                class="tio-add-circle"></i> {{translate('add')}} {{translate('new')}} {{translate('banner')}}</a>
                    </div>
                    <!-- End Header -->

                    <!-- Table -->
                    <div class="table-responsive datatable-custom">
                        <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light">
                            <tr>
                                <th>{{translate('#')}}</th>
                                <th style="width: 30%">{{translate('title')}}</th>
                                <th style="width: 25%">{{translate('image')}}</th>
                                <th>{{translate('status')}}</th>
                                <th style="width: 100px">{{translate('action')}}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($banners as $key=>$banner)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>
                                        <span class="d-block font-size-sm text-body text-trim-25">
                                            {{$banner['title']}}
                                        </span>
                                    </td>
                                    <td>
                                        <div style="height: 100px; width: 100px; overflow-x: hidden;overflow-y: hidden">
                                            <img src="{{asset('storage/app/public/banner')}}/{{$banner['image']}}" style="width: 100px"
                                                 onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'">
                                        </div>
                                    </td>
                                    <td>
                                        @if($banner['status']==1)
                                            <div style="padding: 10px;border: 1px solid;cursor: pointer"
                                                 onclick="location.href='{{route('admin.banner.status',[$banner['id'],0])}}'">
                                                <span class="legend-indicator bg-success"></span>{{ translate('Active') }}
                                            </div>
                                        @else
                                            <div style="padding: 10px;border: 1px solid;cursor: pointer"
                                                 onclick="location.href='{{route('admin.banner.status',[$banner['id'],1])}}'">
                                                <span class="legend-indicator bg-danger"></span>{{ translate('Disabled') }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <!-- Dropdown -->
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                <i class="tio-settings"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item"
                                                   href="{{route('admin.banner.edit',[$banner['id']])}}">{{translate('edit')}}</a>
                                                <a class="dropdown-item" href="javascript:"
                                                   onclick="form_alert('banner-{{$banner['id']}}','Want to delete this banner')">{{translate('delete')}}</a>
                                                <form action="{{route('admin.banner.delete',[$banner['id']])}}"
                                                      method="post" id="banner-{{$banner['id']}}">
                                                    @csrf @method('delete')
                                                </form>
                                            </div>
                                        </div>
                                        <!-- End Dropdown -->
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <hr>
                        <table>
                            <tfoot>
                            {!! $banners->links() !!}
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

@endpush
