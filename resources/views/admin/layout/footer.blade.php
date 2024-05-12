<div id="showModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body"></div>
        </div>

    </div>
</div>
<input id="uploadFolder" type="hidden" data-folder="{{url('/').'/assets/uplaods'}}">
<input id="remove-action" type="hidden" data-action="{{route('admin.remove')}}">
<input name="getDetails" type="hidden" data-action="{{route('getDetails')}}">
{{ csrf_field() }}
<!-- /page container -->
<script type="text/javascript" src="{{url('/')}}/assets/admin/datatable/datatable.js"></script>
<script type="text/javascript">
       initSample();
</script>

@stack('scripts')
<script>
       $('.show_lawsuit_details').click(function(){
        $.get($(this).data('href') , function(result){
            $('#showModal .modal-body').html(result);
            $('#showModal').modal('show');
        });
    });

    $('form:not(.add_item_form)').submit(function(){
        var inputs = $(this).find("[required]");
        var val = 0;
        inputs.each(function(){
            if($(this).val() == ''){
                val = 1;
                $(this).addClass('requiredInp');
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
        }
    });
</script>
@include('validate')
