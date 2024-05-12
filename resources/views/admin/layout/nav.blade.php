<div class="sidebar sidebar-main">
    <div class="sidebar-content">
        <div class="sidebar-category sidebar-category-visible">
            <div class="category-content no-padding">
                <ul class="navigation navigation-main navigation-accordion">
                    <li class="active">
                        <a href="{{route('admin')}}">
                            <i class="icon-home4"></i>
                            <span>الرئيسية</span>
                        </a>
                    </li>
                    @if(user_roles('site_config'))
                    <li>
                        <a href="#!">
                            <i class="icon-stack2"></i>
                            <span>اعدادات الموقع</span>
                        </a>
                        <ul>
                            <li>
                                <a href="{{route('admin.site_config')}}">الإعدادات العامة</a>
                            </li>
                            <li><a href="{{route('admin.advs.config','commision')}}">العمولة</a></li>
                            <li>
                                <a href="{{route('admin.contacts')}}">معلومات التواصل</a>
                            </li>
                            {{-- <li>
                                <a href="{{route('admin.systems')}}">أنظمة الموقع</a>
                    </li> --}}
                    <li>
                        <a href="{{route('admin.close')}}">وضع الصيانة</a>
                    </li>
                    <li>
                        <a href="{{route('admin.mail')}}">اعدادات البريد الالكترونى</a>
                    </li>
                    {{-- <li>
                        <a href="{{route('admin.sms')}}">اعدادت الرسائل النصية (sms)</a>
                    </li> --}}
                    <li>
                        <a href="{{route('admin.apps')}}">لينكات التطبيق</a>
                    </li>
                    {{-- <li>
                        <a href="{{route('admin.advs.config',['watermark'])}}"> العلامة المائية</a>
                    </li> --}}
                    <li>
                        <a href="{{route('bankTransfer')}}"> التحويلات البنكيه </a>
                    </li>
                    <li>
                        <a href="{{route('message')}}">  رسالة الاضافة </a>
                    </li>

                </ul>
                </li>
                @endif


                @if(user_roles('pages'))
                <li>
                    <a href="#!">
                        <i class="icon-stack2"></i>
                        <span>الصفحات</span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{route('admin.pages.index')}}">عرض الصفحات</a>
                        </li>
                        <li>
                            <a href="{{route('admin.pages.create')}}">اضافة صفحة</a>
                        </li>
                    </ul>
                </li>
                @endif

                @if(user_roles('contactus'))
                <li>
                    <a href="{{route('admin.contactus')}}">
                        <i class="icon-stack2"></i>
                        <span>الشكاوى ورسائل العملاء</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.claim')}}">
                        <i class="icon-stack2"></i>
                        <span>المخالفات</span>
                    </a>
                </li>
                @endif

                <li>
                    <a href="{{route('admin.commissions')}}">
                        <i class="icon-stack2"></i>
                        <span>تقارير حساب العمولة</span>
                        <?php
                            $count_rep = \App\Models\CommissionReports::where(['status'=>0])->count();
                        ?>
                        <span style=" background: red; padding: 0px 7px; border-radius: 3px; position: absolute; left: 20px; ">{{ $count_rep }}</span>
                    </a>
                </li>


                @if(user_roles('depts'))
                <li>
                    <a href="#!">
                        <i class="icon-stack2"></i>
                        <span>أقسام الإعلانات</span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{route('depts.index')}}">عرض الأقسام</a>
                        </li>
                        <li>
                            <a href="{{route('depts.create')}}">اضافة قسم</a>
                        </li>
                        <li>
                            <a href="{{route('props.index')}}">الخصائص</a>
                        </li>
                    </ul>
                </li>
                @endif
                @if(user_roles('area'))
                <li>
                    <a href="#!">
                        <i class="icon-stack2"></i>
                        <span>المناطق</span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{route('country.index')}}">عرض الدول</a>
                        </li>
                        <li>
                            <a href="{{route('area.index')}}">عرض المناطق</a>
                        </li>
                    </ul>
                </li>
                @endif @if(user_roles('peroids'))
                {{-- <li>
                        <a href="#!">
                            <i class="icon-stack2"></i>
                            <span>الفترات الزمنية</span>
                        </a>
                        <ul>
                            <li>
                                <a href="{{route('admin.peroids.index')}}">عرض الفترات الزمنية</a>
                </li>
                <li>
                    <a href="{{route('admin.peroids.create')}}">اضافة فترة زمنية</a>
                </li>
                </ul>
                </li> --}}
                @endif
                @if(user_roles('payments'))
                <li>
                    <a href="#!">
                        <i class="icon-stack2"></i>
                        <span>أنظمة الدفع</span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{route('paymethods.index')}}">عرض طرق السداد</a>
                        </li>
                        <li>
                            <a href="{{route('paymethods.create')}}">اضافة طريقة جديدة</a>
                        </li>
                    </ul>
                </li>
                @endif @if(user_roles('currency'))
                {{-- <li>
                        <a href="#!">
                            <i class="icon-stack2"></i>
                            <span>العمﻻت</span>
                        </a>
                        <ul>
                            <li>
                                <a href="{{route('admin.currency.index')}}">عرض العمﻻت</a>
                </li>
                <li>
                    <a href="{{route('admin.currency.create')}}">اضافة عملة</a>
                </li>
                </ul>
                </li> --}}
                @endif
                <?php
                    /*

                      @if(user_roles('joins'))
                      <li>
                      <a href="#!">
                      <i class="icon-stack2"></i>
                      <span>أنظمة الاشتركات</span>
                      </a>
                      <ul>
                      <li>
                      <a href="{{route('admin.jointypes.index')}}">عرض الأنظمة</a>
                      </li>
                      <li>
                      <a href="{{route('admin.jointypes.create')}}">اضافة نظام</a>
                      </li>
                      </ul>
                      </li>
                      @endif


                     */
                    ?>
                <?php
                    /*
                      @if(user_roles('posters'))
                      <li>
                      <a href="#!">
                      <i class="icon-stack2"></i>
                      <span>البنرات الإعﻻنية</span>
                      </a>
                      <ul>
                      <li>
                      <a href="{{ route('admin.posters.index') }}">عرض البنرات</a>
                      </li>
                      </ul>
                      </li>
                      @endif
                     */
                    ?>
                @if(user_roles('sliders'))
                {{-- <li>
                        <a href="#!">
                            <i class="icon-stack2"></i>
                            <span>شرائح السليدر الرئيسية</span>
                        </a>
                        <ul>
                            <li>
                                <a href="{{ route('admin.sliders.index') }}">عرض الشرائح</a>
                </li>
                <li>
                    <a href="{{ route('admin.sliders.create') }}">إضافة شريحة</a>
                </li>
                </ul>
                </li> --}}
                @endif
                @if(user_roles('jobs'))
                {{-- <li>
                        <a href="#!">
                            <i class="icon-stack2"></i>
                            <span>طلبات الوظائف</span>
                        </a>
                        <ul>
                            <li>
                                <a href="{{ route('admin.jobs') }}">عرض كل الطلبات</a>
                </li>
                </ul>
                </li> --}}
                @endif
                @if(user_roles('advs'))
                <li>
                    <a href="#!">
                        <i class="icon-stack2"></i>
                        <span>الإعلانات</span>
                    </a>
                    <ul>
                        {{-- <li>
                                <a href="{{route('admin.advs.index')}}?type=excellent">الاعلانات المميزه</a>
                </li> --}}
                <li>
                    <a href="{{route('admin.advs.index')}}?type=deleted">الإعلانات تم حذفها</a>
                </li>
                <li>
                    <a href="{{route('admin.advs.index')}}?type=active">أخر الإعلانات المفعله</a>
                </li>
                <li>
                    <a href="{{route('admin.advs.index')}}?type=not-active">أخر طلبات التفعيل</a>
                </li>
                <li>
                    <a href="{{route('admin.advs.index')}}?type=report">أخر الإعلانات المبلغ عنها</a>
                </li>
                <li>
                    <a href="{{route('admin.advs.index',['type'=>'report-comments'])}}">أخر التعليقات المبلغ عنها</a>
                </li>
                {{-- <li>
                                <a href="{{route('admin.advs.index')}}?type=median">طلبات الوساطة</a>
                </li> --}}
                <li>
                    <a href="{{ route('advs.create') }}">اضافة إعلان</a>
                </li>
                </ul>
                </li>
                @endif @if(user_roles('users'))
                <li>
                    <a href="#!">
                        <i class="icon-stack2"></i>
                        <span>المستخدمين</span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{route('admin.users.index')}}">عرض المستخدمين</a>
                        </li>
                        <li>
                            <a href="{{route('admin.users.index')}}?type=not-active">الغير مفعلين</a>
                        </li>
                        <li>
                            <a href="{{route('admin.users.index')}}?type=blacklist">القائمة السوداء</a>
                        </li>
                        <li>
                            <a href="{{route('admin.users.create')}}">اضافة مستخدم</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#!">
                        <i class="icon-stack2"></i>
                        <span>صلاحيات لوحة التحكم</span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{route('roles.index')}}">عرض الصلاحيات</a>
                        </li>
                        <li>
                            <a href="{{route('roles.create')}}">اضافة صلاحية</a>
                        </li>
                    </ul>
                </li>
                @endif
                <li>
                    <a href="#!">
                        <i class="icon-stack2"></i>
                        <span>التقارير</span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{route('admin.reports.users')}}">المستخدمين</a>
                            <a href="{{route('admin.reports.advs')}}">الإعلانات</a>
                           {{-- <a href="{{route('admin.reports.orders')}}">طلبات الوساطه</a>--}}
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#!">
                        <i class="icon-stack2"></i>
                        <span>فوره التوثيق</span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{route('admin.documentation.category.index')}}">الاقسام</a>
                            <a href="{{route('admin.documentation.index')}}">الطلبات</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#!">
                        <i class="icon-stack2"></i>
                        <span>الإشعارات</span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{route('admin.notifcation.index')}}">إرسال إشعار</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#!">
                        <i class="icon-stack2"></i>
                        <span>الاشتراكات</span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{route('admin.subscription.index')}}">الاشتراكات</a>
                        </li>
                        <li>
                            <a href="{{route('admin.subscription.create')}}">اضافة اشتراك</a>
                        </li>
                    </ul>
                </li>

                <!-- Dexter -->
                 <li>
                    <a href="#!">
                        <i class="icon-stack2"></i>
                        <span>الاشتراكات الشهرية</span>
                    </a>
                    <ul>
                        <li>
                            <a href="/admin/members/manage">استعراض وتحكم</a>
                        </li>
                        <li>
                            <a href="/admin/members/new">اضافة اشتراك</a>
                        </li>
                    </ul>
                </li>
                <!-- Dexter -->
                </ul>
            </div>
        </div>
    </div>
</div>
