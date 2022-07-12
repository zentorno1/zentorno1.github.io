@extends('layouts.admin.app')

@section('title', translate('Add new branch'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><i class="tio-add-circle-outlined"></i> {{translate('add New Branch')}}</h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <form action="{{route('admin.branch.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{translate('name')}}</label>
                                <input type="text" name="name" class="form-control" placeholder="{{ translate('New branch') }}" value="{{ old('name') }}" maxlength="255" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{translate('email')}}</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                                       maxlength="255" placeholder="{{ translate('EX : example@example.com') }}"
                                       required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-5">
                            <div class="form-group">
                                <label class="input-label" for="">{{translate('latitude')}}</label>
                                <input type="number" name="latitude" class="form-control" placeholder="{{ translate('Ex : -132.44442') }}"
                                       maxlength="255" value="{{ old('latitude') }}" step="any"
                                       required>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <label class="input-label" for="">{{translate('longitude')}}</label>
                                <input type="number" name="longitude" class="form-control" placeholder="{{ translate('Ex : 94.233') }}"
                                       maxlength="255" value="{{ old('longitude') }}" step="any"
                                       required>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label class="input-label" for="">
                                    <i class="tio-info-outined"
                                       data-toggle="tooltip"
                                       data-placement="top"
                                       title="{{ translate('This value is the radius from your restaurant location, and customer can order food inside  the circle calculated by this radius.') }}"></i>
                                    {{translate('coverage (km)')}}
                                </label>
                                <input type="number" name="coverage" min="1" max="1000" class="form-control"
                                       placeholder="{{ translate('Ex : 3') }}" value="{{ old('coverage') }}"
                                       required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="input-label" for="">{{translate('address')}}</label>
                                <input type="text" name="address" class="form-control" placeholder="" value="{{ old('address') }}" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{translate('password')}}</label>
                                <input type="text" name="password" class="form-control" placeholder="{{ translate('Password') }}" maxlength="255" value="{{ old('password') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>{{translate('Branch Image')}}</label><small style="color: red">* ( {{translate('ratio')}} 1:1 )</small>
                        <div class="custom-file">
                            <input type="file" name="image" id="customFileEg1" class="custom-file-input" value="{{ old('image') }}"
                                   accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" required>
                            <label class="custom-file-label" for="customFileEg1">{{translate('Choose File')}}</label>
                        </div>
                        <div class="text-center mt-2">
                            <img style="height: 200px;border: 1px solid; border-radius: 10px;" id="viewer"
                                 src="{{asset('public/assets/admin/img/400x400/img2.jpg')}}" alt="branch image"/>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">{{translate('submit')}}</button>
                </form>
            </div>

            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2 mt-2">
                <div class="card">
                    <div class="card-header flex-between">
                        <div class="flex-start">
                            <h5 class="card-header-title">{{translate('Branch Table')}}</h5>
                            <h5 class="card-header-title text-primary mx-1">({{ $branches->total() }})</h5>
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
                    <!-- Table -->
                    <div class="table-responsive datatable-custom">
                        <table id="columnSearchDatatable"
                               class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                               data-hs-datatables-options='{
                                 "order": [],
                                 "orderCellsTop": true
                               }'>
                            <thead class="thead-light">
                            <tr>
                                <th>{{translate('#')}}</th>
                                <th style="width: 50%">{{translate('image')}}</th>
                                <th style="width: 50%">{{translate('name')}}</th>
                                <th style="width: 50%">{{translate('email')}}</th>
                                <th style="width: 10%">{{translate('action')}}</th>
                            </tr>

                            </thead>

                            <tbody>
                            @foreach($branches as $key=>$branch)
                                <tr>
                                    <td>{{$branches->firstItem()+$key}}</td>
                                    <td>
                                        <img class="" height="60px" width="60px"
                                             onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'"
                                             src="{{asset('storage/app/public/branch')}}/{{$branch['image']}}">
                                    </td>
                                    <td>
                                    <span class="d-block font-size-sm text-body text-trim-50">
                                        {{$branch['name']}} @if($branch['id']==1)
                                            <label class="badge badge-danger">{{translate('main')}}</label>
                                        @else
                                            <label class="badge badge-info">{{translate('sub')}}</label>
                                        @endif
                                    </span>
                                    </td>
                                    <td>{{$branch['email']}}</td>
                                    <td>
                                        <!-- Dropdown -->
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown"
                                                    aria-haspopup="true"
                                                    aria-expanded="false">
                                                <i class="tio-settings"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item"
                                                   href="{{route('admin.branch.edit',[$branch['id']])}}">{{translate('edit')}}</a>
                                                @if($branch['id']!=1)
                                                    <a class="dropdown-item" href="javascript:"
                                                       onclick="form_alert('branch-{{$branch['id']}}','Want to delete this branch ?')">{{translate('delete')}}</a>
                                                    <form action="{{route('admin.branch.delete',[$branch['id']])}}"
                                                          method="post" id="branch-{{$branch['id']}}">
                                                        @csrf @method('delete')
                                                    </form>
                                                @endif
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
                            {!! $branches->links() !!}
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End Table -->
        </div>
    </div>

@endsection

@push('script_2')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function () {
            readURL(this);
        });
    </script>
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


            $('#column3_search').on('change', function () {
                datatable
                    .columns(2)
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
