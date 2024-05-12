@extends('site.index')
@section('title'){{ $category->name }}@stop
@section('page')
<p class="form-h">{{ $category->name }}</p>
<div class="lawsuit_txt">
     <div style="display: block; height: 450px; overflow: auto; direction: ltr; width: 100%; padding: 20px; margin-top: 20px;" class="ViewTeXt">
            {!! \App\SiteConfig::first()->lawsuit_txt ?? '' !!}
    </div>        
    <br>
    <button type="button" data-toggle="modal" data-target="#myModal">نموذج طلب</button>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <div>
                    <p class="form-h">نموذج الطلب</p>
                    @include('validate')
                    <form novalidate class="modal-form" method="post" action="{{ route('lawsuits.store') }}" enctype="multipart/form-data">
                        <div class="form-group">
                            <input type="text" value="{{ auth()->user()->username ?? '' }}" required
                                class="form-control" name="name" placeholder="الاسم بالكامل">
                        </div>
                        <div class="form-group">
                            <select required name="area_id" class="form-control selectpicker" title="حدد المدينة"
                                data-live-search="true">
                                @foreach($areas as $area)
                                <option value="{{ $area->id }}">{{ $area->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" required class="form-control" name="address"
                                placeholder="أدخل عنوان يناسب طلبك">
                        </div>
                        <input type="hidden" required name="category_id" value="{{ $category->id }}">

                        <div class="form-group">
                            <div class="ajaxcont"></div>
                        </div>

                        <div class="form-group">
                            <textarea required class="form-control" rows="7" name="content"
                                placeholder="اكتب طلبك بالتفصيل"></textarea>
                        </div>
                         <div class="form-group">
                            <input type="file" required class="form-control" name="file[]" id="image" multiple="multiple" accept="image/*,.pdf,.doc,.docx" />
                        </div>
                        <div class="form-group">
                            <b>
                               (
برفعك المستندات فأنت توافق على مشاركة
هذه الملفات والبيانات مع مدير الموقع
والمحامي أو المستشار القانوني )  
                            </b>
                        </div>
                        <button class="hvr-rectangle-in" type="submit">إرسال</button>
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    $('#get_childs').change(function(){
            $.get("{{ route('get_childs') }}" , {id : $(this).val()} , function(result){
                $('.ajaxcont').html(result);
                $('.selectpicker').selectpicker('refresh'); 
            });
        });
        
    $("#image").on("change", function() {
    if ($("#image")[0].files.length > 5) {
        alert("لا يمكنك رفع أكثر من 5 ملفات أو صور");
        $('#image').val('');
        
    }
});
</script>
@endpush
@stop