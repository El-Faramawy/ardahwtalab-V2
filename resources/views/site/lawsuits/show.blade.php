<div class="lawsuit_details">
    <table class="table table-responsive table-bordered" width="100%">
        <tr>
            <th style="width:30%">اسم المستخدم</th>
            <td>{{ $law->name ?? $law->user->username }}</td>
        </tr>
        <tr>
            <th>القسم</th>
            <td>{{ $law->category->name ?? 'اخري' }}</td>
        </tr>
        <tr>
            <th>تاريخ تقديم الطلب</th>
            <td>{{ $law->created_at }}</td>
        </tr>
        <tr>
            <th>الحالة</th>
            <td>{{ $law->mystatus }} - {{ $law->updated_at }}</td>
        </tr>
        <tr>
            <th>المنطقة</th>
            <td>{{ $law->area->name ?? '#' }}</td>
        </tr>
        <tr>
            <th>العنوان</th>
            <td>{{ $law->address ?? '#' }}</td>
        </tr>
        <tr>
            <th>تفاصيل الطلب</th>
            <td>{{ $law->content }}</td>
        </tr>
        @if($law->lawyer->first())
        <tr>
            <th>المقدم</th>
            <td>{{ $law->lawyer->first()->pivot->fees ?? '#' }} ريال</td>
        </tr>
        <tr>
            <th>النسبة المستحقة</th>
            <td>{{ $law->lawyer->first()->pivot->percentage ?? '#' }} %</td>
        </tr>
        <tr>
            <th> رد المحامي / المستشار القانوني</th>
            <td>
                <ol>
                    <li> وفق الشرح والمعطيات التي قدمها العميل ( مبدئيا ) فإنه يمكن السير في الطلب</li>
                    <li> بدارسة الطلب ( مبدئيا) يتبين أنه لا يوجد محذور شرعي </li>
                </ol>
            </td>
        </tr>
        @endif
    </table>
    <hr>
    <div class="btns">
        @if(auth('lawyer')->check() && $law->status == 'wait_lawyer_approve' && request('type') != 'accepted')
        <div class="btns">
            <a href="{{ route('lawsuit.accept' , $law->id) }}" class="btn btn-success">الموافقة</a>
            <a href="{{ route('lawsuit.reject' , $law->id) }}" class="btn btn-danger">رفض</a>
        </div>
        @elseif($law->status == 'wait_payment')
        <a class="btn btn-primary" href="{{ route('payment_for_lawyer' , $law->id) }}">
            <i class="fa fa-money"></i>
            السداد لتزويدكم ببيانات المحامي 
        </a>
        @elseif($law->status == 'lawyer_hired')
        <a class="btn btn-primary" href="{{ route('lawyer.show' , $law->lawyer()->first()->id) }}">
            <i class="fa fa-user"></i>
            إظهار بيانات المحامى
        </a>
        @endif
    </div>
</div>