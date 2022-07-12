@extends('layouts.admin.app')

@section('title', translate('Add new product'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{asset('public/assets/admin/css/tags-input.min.css')}}" rel="stylesheet">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><i
                            class="tio-add-circle-outlined"></i> {{translate('add New Product')}}
                    </h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <form action="javascript:" method="post" id="product_form"
                      enctype="multipart/form-data">
                    @csrf
                    @php($language=\App\Model\BusinessSetting::where('key','language')->first())
                    @php($language = $language->value ?? null)
                    @php($default_lang = 'bn')
                    @if($language)
                        @php($default_lang = json_decode($language)[0])
                        <ul class="nav nav-tabs mb-4">

                            @foreach(json_decode($language) as $lang)
                                <li class="nav-item">
                                    <a class="nav-link lang_link {{$lang == $default_lang? 'active':''}}" href="#" id="{{$lang}}-link">{{\App\CentralLogics\Helpers::get_language_name($lang).'('.strtoupper($lang).')'}}</a>
                                </li>
                            @endforeach

                        </ul>
                        @foreach(json_decode($language) as $lang)
                            <div class="card p-4 {{$lang != $default_lang ? 'd-none':''}} lang_form" id="{{$lang}}-form">
                                <div class="form-group">
                                    <label class="input-label" for="{{$lang}}_name">{{translate('name')}} ({{strtoupper($lang)}})</label>
                                    <input type="text" {{$lang == $default_lang? 'required':''}} name="name[]" id="{{$lang}}_name" class="form-control" placeholder="{{ translate('New Product') }}" maxlength="255" oninvalid=" document.getElementById('en-link').click()">
                                </div>
                                <input type="hidden" name="lang[]" value="{{$lang}}">
                                 <div class="form-group pt-4">
                                    <label class="input-label"
                                           for="{{$lang}}_description">{{translate('short')}} {{translate('description')}}  ({{strtoupper($lang)}})</label>
                                    <div id="{{$lang}}_editor" style="min-height: 15rem;"></div>
                                    <textarea name="description[]" style="display:none" id="{{$lang}}_hiddenArea"></textarea>
                                </div>
                                {{--<div class="form-group pt-4">
                                    <label class="input-label"
                                           for="{{$lang}}_description">{{translate('short')}} {{translate('description')}}  ({{strtoupper($lang)}})</label>
                                    <textarea name="description[]" style="min-height: 15rem;width:100%" id="{{$lang}}_hiddenArea"></textarea>
                                </div>--}}
                            </div>
                        @endforeach
                    @else
                        <div class="card p-4" id="{{$default_lang}}-form">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{translate('name')}} (EN)</label>
                                <input type="text" name="name[]" class="form-control" placeholder="{{ translate('New Product') }}" required>
                            </div>
                            <input type="hidden" name="lang[]" value="en">
                             <div class="form-group pt-4">
                                <label class="input-label"
                                       for="exampleFormControlInput1">{{translate('short')}} {{translate('description')}} (EN)</label>
                                <div id="editor" style="min-height: 15rem;"></div>
                                <textarea name="description[]" style="display:none" id="hiddenArea"></textarea>
                            </div>
                            {{--<div class="form-group pt-4">
                                <label class="input-label"
                                       for="exampleFormControlInput1">{{translate('short')}} {{translate('description')}} (EN)</label>

                                <textarea name="description[]" style="min-height: 15rem;width:100%" id="hiddenArea"></textarea>
                            </div>--}}
                        </div>
                    @endif
                    <div id="from_part_2">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="input-label"
                                           for="exampleFormControlInput1">{{translate('price')}}</label>
                                    <input type="number" min="1" max="100000000" step="0.01" value="1" name="price"
                                           class="form-control"
                                           placeholder="{{ translate('Ex : 100') }}" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="input-label"
                                           for="exampleFormControlInput1">{{translate('unit')}}</label>
                                    <select name="unit" class="form-control js-select2-custom">
                                        <option value="kg">{{translate('kg')}}</option>
                                        <option value="gm">{{translate('gm')}}</option>
                                        <option value="ltr">{{translate('ltr')}}</option>
                                        <option value="pc">{{translate('pc')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="input-label"
                                           for="exampleFormControlInput1">{{translate('tax')}}</label>
                                    <input type="number" min="0" value="0" step="0.01" max="100000" name="tax"
                                           class="form-control"
                                           placeholder="{{ translate('Ex : 7') }}" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="input-label"
                                           for="exampleFormControlInput1">{{translate('tax')}} {{translate('type')}}</label>
                                    <select name="tax_type" class="form-control js-select2-custom">
                                        <option value="percent">{{translate('percent')}}</option>
                                        <option value="amount">{{translate('amount')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="ol-md-4 col-4">
                                <div class="form-group">
                                    <label class="input-label"
                                           for="exampleFormControlInput1">{{translate('capacity')}}</label>
                                    <input type="number" min="0" step="0.01" value="1" name="capacity"
                                           class="form-control"
                                           placeholder="{{ translate('Ex : 5') }}" required>
                                </div>
                            </div>
                            <div class="col-md-4 col-4">
                                <div class="form-group">
                                    <label class="input-label"
                                           for="exampleFormControlInput1">{{translate('discount')}}</label>
                                    <input type="number" min="0" max="100000" value="0" name="discount" class="form-control"
                                           placeholder="{{ translate('Ex : 100') }}" required>
                                </div>
                            </div>
                            <div class="col-md-4 col-4">
                                <div class="form-group">
                                    <label class="input-label"
                                           for="exampleFormControlInput1">{{translate('discount')}} {{translate('type')}}</label>
                                    <select name="discount_type" class="form-control js-select2-custom">
                                        <option value="percent">{{translate('percent')}}</option>
                                        <option value="amount">{{translate('amount')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="input-label"
                                           for="exampleFormControlInput1">{{translate('stock')}}</label>
                                    <input type="number" min="0" max="100000000" value="0" name="total_stock" class="form-control"
                                           placeholder="{{ translate('Ex : 100') }}">
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="input-label"
                                           for="exampleFormControlSelect1">{{translate('category')}}<span
                                            class="input-label-secondary">*</span></label>
                                    <select name="category_id" class="form-control js-select2-custom"
                                            onchange="getRequest('{{url('/')}}/admin/product/get-categories?parent_id='+this.value,'sub-categories')">
                                        <option value="">---{{translate('select')}}---</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category['id']}}">{{$category['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="input-label"
                                           for="exampleFormControlSelect1">{{translate('sub_category')}}<span
                                            class="input-label-secondary"></span></label>
                                    <select name="sub_category_id" id="sub-categories"
                                            class="form-control js-select2-custom"
                                            onchange="getRequest('{{url('/')}}/admin/product/get-categories?parent_id='+this.value,'sub-sub-categories')">

                                    </select>
                                </div>
                            </div>
                            {{--<div class="col-md-4 col-6">
                                <div class="form-group">
                                    <label class="input-label" for="exampleFormControlSelect1">Sub Sub Category<span
                                            class="input-label-secondary"></span></label>
                                    <select name="sub_sub_category_id" id="sub-sub-categories"
                                            class="form-control js-select2-custom">

                                    </select>
                                </div>
                            </div>--}}
                        </div>

                        <div class="row"
                             style="border: 1px solid #80808045; border-radius: 10px;padding-top: 10px;margin: 1px">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="input-label"
                                           for="exampleFormControlSelect1">{{translate('attribute')}}<span
                                            class="input-label-secondary"></span></label>
                                    <select name="attribute_id[]" id="choice_attributes"
                                            class="form-control js-select2-custom"
                                            multiple="multiple">
                                        @foreach(\App\Model\Attribute::orderBy('name')->get() as $attribute)
                                            <option value="{{$attribute['id']}}">{{$attribute['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 mt-2 mb-2">
                                <div class="customer_choice_options" id="customer_choice_options">

                                </div>
                            </div>
                            <div class="col-md-12 mt-2 mb-2">
                                <div class="variant_combination" id="variant_combination">

                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>{{translate('product')}} {{translate('image')}}</label><small
                                style="color: red">* ( {{translate('ratio')}} 1:1 )</small>
                            <div>
                                <div class="row" id="coba"></div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary">{{translate('submit')}}</button>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('script')

@endpush

@push('script_2')
    <script src="{{asset('public/assets/admin/js/spartan-multi-image-picker.js')}}"></script>
    <script>
        $(".lang_link").click(function(e){
            e.preventDefault();
            $(".lang_link").removeClass('active');
            $(".lang_form").addClass('d-none');
            $(this).addClass('active');

            let form_id = this.id;
            let lang = form_id.split("-")[0];
            console.log(lang);
            $("#"+lang+"-form").removeClass('d-none');
            if(lang == '{{$default_lang}}')
            {
                $("#from_part_2").removeClass('d-none');
            }
            else
            {
                $("#from_part_2").addClass('d-none');
            }


        })
    </script>

    <script>
        @if($language)
        @foreach(json_decode($language) as $lang)
        var en_quill = new Quill('#{{$lang}}_editor', {
            theme: 'snow'
        });
        @endforeach
        @else
        var bn_quill = new Quill('#editor', {
            theme: 'snow'
        });
        @endif

        $('#product_form').on('submit', function () {
            @if($language)
            @foreach(json_decode($language) as $lang)
            var {{$lang}}_myEditor = document.querySelector('#{{$lang}}_editor')
            $("#{{$lang}}_hiddenArea").val({{$lang}}_myEditor.children[0].innerHTML);
            @endforeach
            @else
            var myEditor = document.querySelector('#editor')
            $("#hiddenArea").val(myEditor.children[0].innerHTML);
            @endif

            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.product.store')}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.errors) {
                        for (var i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                        toastr.success('{{ translate("product uploaded successfully!") }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        setTimeout(function () {
                            location.href = '{{route('admin.product.list')}}';
                        }, 2000);
                    }
                }
            });
        });
    </script>

    <script type="text/javascript">
        $(function () {
            $("#coba").spartanMultiImagePicker({
                fieldName: 'images[]',
                maxCount: 4,
                rowHeight: '215px',
                groupClassName: 'col-3',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{asset('public/assets/admin/img/400x400/img2.jpg')}}',
                    width: '100%'
                },
                dropFileLabel: "Drop Here",
                onAddRow: function (index, file) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    toastr.error('{{ translate("Please only input png or jpg type file") }}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function (index, file) {
                    toastr.error('{{ translate("File size too big") }}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });
    </script>

    <script>
        function getRequest(route, id) {
            $.get({
                url: route,
                dataType: 'json',
                success: function (data) {
                    $('#' + id).empty().append(data.options);
                },
            });
        }
    </script>

    <script>
        $(document).on('ready', function () {
            $('.js-select2-custom').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });
    </script>

    <script src="{{asset('public/assets/admin')}}/js/tags-input.min.js"></script>

    <script>
        $('#choice_attributes').on('change', function () {
            $('#customer_choice_options').html(null);
            $.each($("#choice_attributes option:selected"), function () {
                add_more_customer_choice_option($(this).val(), $(this).text());
            });
        });

        function add_more_customer_choice_option(i, name) {
            let n = name.split(' ').join('');
            $('#customer_choice_options').append('<div class="row"><div class="col-md-3"><input type="hidden" name="choice_no[]" value="' + i + '"><input type="text" class="form-control" name="choice[]" value="' + n + '" placeholder="Choice Title" readonly></div><div class="col-lg-9"><input type="text" class="form-control" name="choice_options_' + i + '[]" placeholder="Enter choice values" data-role="tagsinput" onchange="combination_update()"></div></div>');
            $("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput();
        }

        function combination_update() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: '{{route('admin.product.variant-combination')}}',
                data: $('#product_form').serialize(),
                success: function (data) {
                    $('#variant_combination').html(data.view);
                    if (data.length > 1) {
                        $('#quantity').hide();
                    } else {
                        $('#quantity').show();
                    }
                }
            });
        }
    </script>

    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script>
        var quill = new Quill('#editor', {
            theme: 'snow'
        });

        $('#product_form').on('submit', function () {

            var myEditor = document.querySelector('#editor')
            $("#hiddenArea").val(myEditor.children[0].innerHTML);

            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.product.store')}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.errors) {
                        for (var i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                        toastr.success('{{ translate("product uploaded successfully!") }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        setTimeout(function () {
                            location.href = '{{route('admin.product.list')}}';
                        }, 2000);
                    }
                }
            });
        });
    </script>

    <script>
        function update_qty() {
            var total_qty = 0;
            var qty_elements = $('input[name^="stock_"]');
            for(var i=0; i<qty_elements.length; i++)
            {
                total_qty += parseInt(qty_elements.eq(i).val());
            }
            if(qty_elements.length > 0)
            {
                $('input[name="total_stock"]').attr("readonly", true);
                $('input[name="total_stock"]').val(total_qty);
                console.log(total_qty)
            }
            else{
                $('input[name="total_stock"]').attr("readonly", false);
            }
        }
    </script>
@endpush


