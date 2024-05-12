@extends('site.index')
    @section('title') اضافة اعلان @stop
@section('page')
<div class="addPost-content">


    @if(isset($Message->message) and !empty($Message->message) )
      <div style="display: block; height: 250px; overflow: auto; direction: ltr; width: 100%; padding: 20px; margin-top: 20px;" class="ViewTeXt">  @php echo $Message->message @endphp </div>
    @endif

    <hr/>


    @include('validate')
    <form novalidate id="addPost-form" class="add_item_form" action="{{ route('advertise.store') }}" method="post" enctype="multipart/form-data">
        <div class="form-row">
            <div class="label-div">
                <label for="exampleInputEmail1">اختر القسم</label>
            </div>
            <div class="input-div add-post-categ-inp">
                <select required class="selectpicker advs_dept_id" name="dept"
                    title="اختر القسم">
                    @foreach(layout_data()->depts as $dp)
                    <option value="{{ $dp->id }}" style="background-image:url({{ $dp->image }});">{{ $dp->name }}
                    </option>
                    @endforeach
                </select>

            </div>
        </div>

        <div class="advs_details"></div>

        <div class="advs_proptypes"></div>

        <div class="form-row">
            <div class="label-div">
                <label for="exampleInputEmail1">اختر الدوله</label>
            </div>
            <div class="input-div add-post-categ-inp">
                <select required class="selectpicker" id="country" name="country" title="اختر الدولة">
                    @foreach($country as $ar)
                    <option value="{{ $ar->id }}">{{ $ar->name }}</option>
                    @endforeach
                </select>

            </div>
        </div>


        <div class="form-row">
            <div class="label-div">
                <label for="exampleInputEmail1">اختر المدينة</label>
            </div>
            <div class="input-div add-post-categ-inp">
                <div class="area_content">
                    <select required class="selectpicker areass" name="area">
                        <option value="">اختر المدينة</option>
                    </select>
                </div>

            </div>
        </div>


        <div class="form-row">
            <div class="label-div">
                <label for="title-input">عنوان الإعلان</label>
            </div>
            <div class="input-div">
                <input required name="title" type="text" class="form-control" maxlength="21" id="title-input">
            </div>
        </div>

        <div class="form-group">
            <div class="label-div">
                <label for="title-input">الصور</label>
            </div>
            <div class="input-div">
                <div class="inputSection postSelect-section">
                    <div id="images">
                        <div id="input" class="col-md-3 col-sm-4 col-xs-6">
                            <input accept="image/*" type="file" id="uploadimages" multiple name="images[]" max="3"
                                class="form_control">
                            <input type="hidden" name="images_sort">
                            <i class="fa fa-image"></i> أضف صورة
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="label-div">

            </div>
            <div class="input-div preview-img-div">
                {{-- <img id="preview-img" src="" /> --}}
            </div>
        </div>
        @include('site.advs.map')
        <div class="form-row">
            <div class="label-div">
                <label>تفاصيل الإعلان</label>
            </div>
            <div class="input-div">
                <textarea name="description"></textarea>
            </div>
        </div>
        <div class="form-row check_rules" style="margin-top:10px;">
            <div class="form-group">
                <label class="radio-cont">
                    <input type="checkbox" name="show_phone" checked value="1">
                    <span class="checkmark"></span>
                    إظهار رقم الجوال الخاص بك فى بيانات التواصل
                </label>
            </div>
        </div>
        <div class="form-row check_rules" style="margin-top:10px;">
            <?php
                $page = App\Models\Pages::where('type' , 'policy')->first();
            ?>
            <div class="form-group">
                <label class="radio-cont">
                    <input type="checkbox" required name="rules" value="1">
                    <span class="checkmark"></span>
                    بنشر إعلانك أنت توافق على
                    @if($page)
                    <a target="blank" href="{{ route('page',[$page->id , $page->slug]) }}"> الشروط والأحكام</a>
                    @endif
                </label>
            </div>

        </div>
        <div class="text-center">
            <button class="submit-btn hvr-rectangle-in add_item" id="SubmitNow" type="submit">حفظ ونشر الإعلان</button>
            <p class="TextDexter" style="display:none; font-size: 25px; color: #e31331;">
                جاري الرفع فضلا نرجوا الانتظار.
            </p>
        </div>

        {{ csrf_field() }}
    </form>
</div>
<input name="getDetails" type="hidden" data-action="{{route('getDetails')}}">

@push('scripts')

<script>
    var submit_one = 1;
    $('.add_item_form').submit(function(){
        if(submit_one == 0) return true;
        var inputs = $(this).find("[required]");
        var val = 0;
        inputs.each(function(key){
            if($(this).val() == ''){
                val = 1;
                $(this).addClass('requiredInp');
            }else if($(this).attr('type') == 'checkbox' && inputs[key].checked == false){
                val = 1;
                $(this).parent().find('.checkmark').addClass('requiredInp');
            }
        });
        if(val == 1){
            window.scrollTo({
                top: $('.requiredInp:visible:first').offset().top - 10,
                behavior: 'smooth',
            });
            $('.selectpicker').selectpicker('refresh');
            // window.scrollTo(0 , $('.requiredInp:visible:first').offset().top - 10);
            return false;
        }else{
            swal({
                type: "warning",
                title : "هل أنت متأكد ؟",
                text : "هل أنت متأكد من نشر الإعلان ؟" ,
                confirmButtonText : "موافق",
                showCancelButton: true,
                cancelButtonText : "إغلاق"
            }).then(function(ok){
                if(ok.value == true){
                    submit_one = 0;
                    $('#addPost-form').submit();
                    // Dexter
                    $('#SubmitNow').hide();
                    $('.TextDexter').show();
                }
            });
            return false;
        }
    });
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
                    buttons: [
                        "{{ trans('إغلاق') }}",
                        "{{ trans('نعم , احذفها') }}"
                    ]
                }).then(function(isConfirm){
                    if(isConfirm){
                        var myfileid = btn.data('fileid');
                        if(myfileid){
                            images.forEach(function(image , index){
                                if(myfileid == image.id){
                                    delete images[index];
                                    images = images.filter(image => image.id);
                                    console.log(images);
                                    btn.parent().remove();
                                    // sort_images();
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
                var allowed_count = parseInt("{{ 10 }}");
                if(images_count + images.length + length < allowed_count){
                    for ( var i = length ; i >= 0 ; i-- ) {
                        sort = last_sort + i;
                        createImgTag(files[i] , sort , i );
                    };

                    $('.imgsNum').html(images.length + imgsNum);
                    setTimeout(() => {
                        var imageChangeEvent = new CustomEvent('imageChangeEvent');
                        document.dispatchEvent(imageChangeEvent);
                        // sort_images();
                    }, 100);
                }else{
                    swal({
                        type : 'warning',
                        title : '{{ trans("عذراً عملينا العزيز ... مسموح فقط تحميل 10 صور كحد أقصى ") }}'+allowed_count,
                        button : "{{ trans('موافق') }}"
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

        // Dexter


        // Dexter

</script>
@endpush

@stop
