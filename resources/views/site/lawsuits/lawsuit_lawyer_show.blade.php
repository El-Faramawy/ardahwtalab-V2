@if($lawyers)
   
<!--<div class="col-sm-8 col-lg-9">-->
        <!--<div class="container">-->
        <div class="lawsuit_details">

        <table >
            <tr>
                <th style="width:5%">عرض الأتعاب</th>
                <th style="width:20%">الدفعة المقدمة</th>
                <th style="width:20%">النسبة من مبلغ القضية</th>
                <th style="width:10%">الإجابه</th>
                <th style="width:10%">إختيار</th>
            </tr>
            <?php $x = 1; ?>
            @foreach($lawyers as $lawyer)
                <tr>
                    <td>{{ $x }}</td>
                    <td>{{ $lawyer->fees }}</td>
                    <td>{{ $lawyer->percentage }} %</td>
                    <?php $reason = str_replace('محضور','محذور',$lawyer->reason); ?>
                    <td style="width:10%">{!! $reason !!}</td>
                    <td><a class="btn btn-success fa fa-check-circle-o" href="{{ route('approve_lawyer_choose', $lawyer->id) }}"></a></td>
                </tr>
                <?php $x = $x + 1; ?>
            @endforeach
        </table>
      
           <!--</div>-->

    </div>
@else
    <div class="lawsuit_details">
        لا يوجد محاميين مقترحيين من قبل المشرف حالياً
    </div>
@endif