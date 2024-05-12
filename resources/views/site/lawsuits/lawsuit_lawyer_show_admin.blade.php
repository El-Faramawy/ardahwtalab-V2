@if($lawyer)
    <div class="lawsuit_details">
        <table class="table table-responsive table-bordered" width="100%">
            <tr>
                <th style="width:30%">اسم المحامى</th>
                <th>الردرو</th>
            </tr>
                <tr>
                    <td>{{ \DB::table('lawyers')->where('id', $lawyer->lawyer_id)->first()->fullname }}</td>
                    <!--<td>{!! $lawyer->reason !!}</td>-->
                    <td>
                        <ol>
                            <li> وفق الشرح والمعطيات التي قدمها العميل ( مبدئيا ) فإنه يمكن السير في الطلب</li>
                            <li> بدارسة الطلب ( مبدئيا) يتبين أنه لا يوجد محذور شرعي </li>
                        </ol>
                    </td>
                </tr>
        </table>
        
    </div>
@else
    <div class="lawsuit_details">
        لا يوجد ردوود من قبل المحامى
    </div>
@endif