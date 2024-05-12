<section class="results-section">
    <div class="container">
        <div class="results-content result-cont">
            @if($advs->count())
            <div class="div-header">
                <h1 class="fixall">الإعلانات المضافة مؤخرًا</h1>
                <div class="sort">
                    <div class="chooseBtns-grid">
                        <i class="fas fa-th grid view-active"></i>
                        <i class="fas fa-th-list list"></i>
                        <i class="fas fa-list linear"></i>
                    </div>
                    <h2 class="fixall">حسب المدينة </h2>
                    <select name="area_id" class="selectpicker" onchange="window.location=this.value">
                        <option hidden>اختر المدينة</option>
                        @foreach(\App\Models\Area::all() as $area)
                        <option value="{{ route('search' , ['area' => $area->id]) }}">{{ $area->name }}</option>
                        @endforeach
                    </select>
                    &nbsp;&nbsp;
                    <h2 class="fixall">عدد الإعلانات </h2>
                    <select name="perpage" class="selectpicker" onchange="window.location=this.value">
                    <option {{ request('perpage') == 20 ? 'selected' : '' }} value="{{ route('advs.last' , ['perpage' => 20]) }}">20</option>
                        <option {{ request('perpage') == 50 ? 'selected' : '' }} value="{{ route('advs.last' , ['perpage' => 50]) }}">50</option>
                        <option {{ request('perpage') == 100 ? 'selected' : '' }} value="{{ route('advs.last' , ['perpage' => 100]) }}">100</option>
                    </select>
                </div>
            </div>
            <div>
                <div class="items row">
                    @foreach($advs as $ad)
                    @include('site.parts.advs_box')
                    @endforeach
                </div>
                    <div class="clearfix"></div>
                    <div class="text-center m-20">
                        {{ $advs->links() }}
                    </div>
            </div>
            @else
            <center>
                @if(isset($type))
                @if($type=='comment')
                <h3 style="line-height:60px;">
                    <?php /* لا يوجد تعليقات مبلغ عنها */ ?>
                    لا توجد نتائج حاليا
                </h3>
                @endif
                @else
                <h3 style="line-height:60px;">عفواً لا يوجد اعلانات متوفرة</h3>
                @endif

            </center>
            @endif
        </div>
    </div>
</section>
