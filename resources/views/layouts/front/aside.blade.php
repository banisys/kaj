
<div class="col-lg-2 px-0 float-right text-center my-5" style="border-left: 1px #e2e2e2 solid;">

    <div class="col-md-12 px-0  pt-4 text-right account-menu">
        <ul id="panel_side">
            <li class="py-2 mt-1 pr-2" id="info-btn" style="direction: ltr">
                <a href="{{url('/panel/account')}}">
                    <span class="account-menu-hover"></span>
                    <span class="pr-4" style="color: #222222;">پروفایل</span>
                    <i class="fa fa-user"></i>
                </a>
            </li>
            <li class="py-2 mt-1 pr-2" id="order-btn" style="direction: ltr">
                <a href="{{url('/panel/orders')}}">
                    <span class="account-menu-hover"></span>
                    <span class="pr-4" style="color: #222222;">سفارشات</span>
                    <i class="fa fa-list-alt"></i>
                </a>
            </li>

{{--            <li class="py-2 mt-1 pr-2" id="love-btn" style="direction: ltr">--}}
{{--                <a href="{{url('/favourites')}}">--}}
{{--                    <span class="account-menu-hover"></span>--}}
{{--                    <span class="pr-4" style="color: #222222;">علاقه مندی ها</span>--}}
{{--                </a>--}}
{{--                <i class="fa fa-heart"></i>--}}
{{--            </li>--}}

            <li class="py-2 mt-1 pr-2" style="direction: ltr;height: 45px;" @click="exit">
                <span class="account-menu-hover"></span>
                <form method="POST" action="{{ route('logout') }}" ref="formExit">
                    @csrf
                    <button style="background-color: unset;border: unset;color: #dc3545;font-size:16px;margin-top:4px;margin-right: 10%;">
                        خروج

                    </button>
                    <i style="color:rgb(220, 53, 69)" class="fa fa-power-off"></i>
                </form>
                <br><br>
            </li>
        </ul>
    </div>
</div>

