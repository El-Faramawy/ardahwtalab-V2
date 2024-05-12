@extends('site.index')
@section('title') تعديل إعلان @stop
@section('page')
<style>
    .deleteImage {
        display: inline-block;
        text-align: center;
        width: 68px;
        height: 40px;
        border-radius: 3px;
        font-size: 15px;
        color: #ffffff !important;
        font-family: NeoSansArabic;
        background-color: #ff0000;
        font-weight: normal;
        padding-top: 9px;
        position: relative;
        bottom: 12px;
        left: -9px;
    }

    .AddButton {
        display: inline-block;
        float: left;
        text-align: center;
        width: 100%;
        height: 40px;
        border-radius: 3px;
        font-size: 15px;
        color: #ffffff;
        font-family: NeoSansArabic;
        background-color: #059123;
        font-weight: normal;
        padding-top: 9px;
    }

    .AddButton:hover {
        color: #ffffff;
    }

    .drf {
        width: 55px;
        height: 53px;
        margin-top: -14px;
        float: left;
    }

    .drf img {
        width: 100%;
        height: 100%;
    }

    .fontss {
        position: absolute;
        margin-top: 9px;
    }

    .text_image {
        white-space: nowrap;
        width: 270px;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<div class="addPost-content">
    <p class="addPost">تعديل الإعلان ({{ $info->title }})</p>
    @include('validate')
    <form novalidate id="addPost-form"  action="{{ route('advertise.update',$info->id) }}" method="post"
        enctype="multipart/form-data">
        {{ method_field('PUT') }}
        <div class="form-row">
            <div class="label-div">
                <label for="exampleInputEmail1">اختر القسم</label>
            </div>
            <div class="input-div add-post-categ-inp">
                <select required class="selectpicker advs_dept_id" name="dept">
                <option value="" style="background-image:url({{url('/')}}/assets/harag/pic/categ.png);" data-id="{{ $info->id }}"> جميع
                        الأقسام</option>
                    @foreach(layout_data()->depts as $dp)
                    <option {{ $info->super_dept->id == $dp->id ? 'selected' : '' }} value="{{ $dp->id }}"
                        style="background-image:url({{ $dp->image }});">{{ $dp->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="advs_details">
            @if(isset($advs_details))
            @foreach($advs_details as $adt)
            @foreach($adt as $key=>$ad)
            @if($key != 'others' && $key!= 'type')
            @if($adt['type']=='input')
            <div class="form-row">
                <div class="label-div">
                    <label class="">{{$key}}</label>
                </div>
                <div class="input-div">
                    <input required value="{{$ad}}" name="{{$key}}" type="text" class="form-control">
                </div>
            </div>
            @else
            <div class="form-row">
                <div class="label-div">
                    <label class="control-label col-lg-2">{{$key}}</label>
                </div>
                <div class="input-div add-post-categ-inp">
                    <select required class="selectpicker form-control _proptype" name="{{$key}}">
                        @foreach($adt['others'] as $ot)
                        <option @if($ot->name==$ad) selected @endif value="{{$ot->name}}">
                            {{ $ot->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            @endif
            @endif
            @endforeach
            @endforeach
            @endif
        </div>

        <div class="advs_proptypes"></div>


        <div class="form-row">
            <div class="label-div">
                <label for="exampleInputEmail1">اختر الدوله</label>
            </div>
            <div class="input-div add-post-categ-inp">
                <select required class="selectpicker countryfff" name="country" data-selected-area={{$info->area}}>
                    <option value=""> جميع الدول</option>
                    @foreach($country as $ar)
                    <option {{ $info->country == $ar->id ? 'selected' : '' }} value="{{ $ar->id }}">{{ $ar->name }}
                    </option>
                    @endforeach
                </select>

            </div>
        </div>


        <div class="form-row">
            <div class="label-div">
                <label for="exampleInputEmail1">اختر المدينة</label>
            </div>
            <div class="input-div add-post-categ-inp">
                <select required class="selectpicker areass" name="area">
                    <option value=""> جميع المدن</option>
                    @foreach(layout_data()->area as $ar)
                    <option {{ $info->area == $ar->id ? 'selected' : '' }} value="{{ $ar->id }}">{{ $ar->name }}
                    </option>
                    @endforeach
                </select>

            </div>
        </div>

        <div class="form-row">
            <div class="label-div">
                <label for="title-input">عنوان الإعلان</label>
            </div>
            <div class="input-div">
                <input value="{{ $info->title }}" required name="title" type="text" class="form-control"
                    id="title-input">
            </div>
        </div>

        <div class="form-row">
            <div class="label-div">
                <label for="title-input">السعر</label>
            </div>
            <div class="input-div">
                <input value="{{ $info->price }}" name="price" type="text" class="form-control" placeholder="السعر *">
            </div>
        </div>


        <div class="form-group">
            <div class="label-div">
                <label for="title-input">الصور</label>
            </div>
            <div class="input-div">
                <div class="inputSection postSelect-section">
                    <div id="images">
                        @foreach($info->images as $img)
                        <div class="imgTag imgIn col-md-3 col-sm-4 col-xs-6 remove_this_img">
                            <a data-href="{{ route('remove-image',$img->id) }}"><i title='{{ trans('Remove image') }}'
                                    class='fa fa-trash remove_img'></i></a>
                            <img src="{{ $img->image }}" />
                        </div>
                        @endforeach
                        <div id="input" class="col-md-3 col-sm-4 col-xs-6">
                            <input accept="image/*" type="file" id="uploadimages" multiple name="images[]"
                                class="form_control">
                            <input type="hidden" name="images_sort">
                            <i class="fa fa-image"></i> أضف صورة
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('site.advs.map')
        <div class="form-row">
            <div class="label-div">
                <label>تفاصيل الإعلان</label>
            </div>
            <div class="input-div">
                <textarea name="description">{{ $info->description }}</textarea>
            </div>
        </div>

        <div class="form-row check_rules" style="margin-top:10px;">
            <div class="form-group">
                <label class="radio-cont">
                    <input type="checkbox" name="show_phone" {{ $info->show_phone ? 'checked' : '' }} value="1">
                    <span class="checkmark"></span>
                    &nbsp;&nbsp;
                    إظهار رقم الجوال الخاص بك فى بيانات التواصل
                </label>
            </div>
        </div>

        <div class="text-center">
            <button class="submit-btn hvr-rectangle-in" type="submit">تعديل ونشر الإعلان</button>
        </div>
        {{ csrf_field() }}
    </form>
</div>
<input name="getDetails" type="hidden" data-action="{{route('getDetails')}}">

@push('scripts')
<script>
    get_dept_props("{{ $info->super_dept->id }}" , "{{ $info->id }}")
</script>

<script>
    $('#comment-box').keyup(function(){
        var tval = $(this).val()
        var tlength = tval.length;
        $(this).val((tval).substring(0, 9999));
        $('.currentLen span').html(tlength);
    });
    var images_count = parseInt("{{ 0 }}");
    var images = new Array;
        var last_sort = parseInt("{{ 0 }}");
        var imgsNum = parseInt("{{ 0 }}");
        $('.imgsNum').html(imgsNum);
        sort_images();
        $(document).ready(function(){
            $('.remove_item').click(function(){
                var btn = $(this);
                swal({
                    icon : 'warning',
                    text : "{{ trans('Are you sure ?') }}",
                    buttons: [
                        '{{ trans("No, cancel it!") }}',
                        '{{ trans("Yes, I am sure!") }}'
                    ],
                    dangerMode: true
                }).then(function(isConfirm){
                    if(isConfirm){
                        $.get(btn.attr('href') , function(result){
                            window.location = result;
                        });
                    }
                });
                return false;
            });

            // $( "#images").sortable({
            //     stop: function(event , ui){
            //         setTimeout(() => { sort_images(); }, 100);
            //     }
            // });

            $('.previewBtn').click(function(){
                $('.createItem').prepend("<input type='hidden' name='preview' value='1' />")
                $('.createItem').submit();
            });

            $('.inputButton').click(function(){
                $("[name='preview']").remove();
            });

            $('body').on('click' , '.remove_img' , function(){
                var btn = $(this);
                swal({
                    type : 'warning',
                    title : "{{ trans('هل أنت متأكد ؟') }}",
                    confirmButtonText : "موافق",
                    showCancelButton: true,
                    cancelButtonText : "إغلاق"
                    // buttons: [
                    //     "{{ trans('إغلاق') }}",
                    //     "{{ trans('نعم , احذفها') }}"
                    // ]
                }).then(function(isConfirm){
                    if(isConfirm.value == true){
                        if(btn.parent().parent().hasClass('remove_this_img')){
                            $.get(btn.parent().data('href'));
                            btn.parent().parent().remove();
                        }
                        var myfileid = btn.data('fileid');
                        if(myfileid){
                            images.forEach(function(image , index){
                                if(myfileid == image.id){
                                    delete images[index];
                                    images = images.filter(image => image.id);
                                    btn.parent().remove();
                                    sort_images();
                                }
                            });
                        }else if(imageId = btn.data('id')){

                        }
                        // console.log(imgsNum);
                        $('.imgsNum').html(images.length + imgsNum);
                    }
                });
            });

            $('#uploadimages').change(function(){
                var files = this.files;
                var length = files.length - 1;
                if(images.length > 0) last_sort = images.length;
                var allowed_count = parseInt("{{ 20 }}");
                if(images_count + images.length + length < allowed_count){
                    for ( var i = length ; i >= 0 ; i-- ) {
                        sort = last_sort + i;
                        createImgTag(files[i] , sort , i );
                    };

                    $('.imgsNum').html(images.length + imgsNum);
                    setTimeout(() => {
                        var imageChangeEvent = new CustomEvent('imageChangeEvent');
                        document.dispatchEvent(imageChangeEvent);
                        sort_images();
                    }, 100);
                }else{
                    swal({
                        type : 'warning',
                        title : '{{ trans("Maximum allowed number of uploaded files is ") }}'+allowed_count,
                        button : "{{ trans('OK') }}"
                    });
                }
            });

            $('.createItem').submit(function(e){
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                formData.delete('images[]');
                images.forEach(function (el) {
                    formData.append('images[]', el.file);
                });
                submit_form($(this) , formData);
            });

        });


        function createImgTag(file , sort , i) {
            var fileId = Date.now() + file.lastModified + file.size + i;
            images.push({
                id: fileId,
                file: file
            });
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#images').prepend("<div data-sort='"+ sort +"' class='imgTag imgIn col-md-3 col-sm-4 col-xs-6'><i title='{{ trans('Remove image') }}' class='fa fa-trash remove_img' data-fileid='"+fileId+"'></i><img src='"+e.target.result+"' /></div>");
            }
            reader.readAsDataURL(file);
        }

        function sort_images(){
            var sorts = $('.imgTag,.imgIn').map(function(){
                return $(this).data('sort');
            }).get();
            $("input[name='images_sort']").val(sorts.join(','));
        }

</script>
@endpush

@stop
