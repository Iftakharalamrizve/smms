<div class="g-top-bar fixed-top">
    <!--Main Logo-->
    <div class="g-logo">
        <a href="{{url('/client')}}">
            <img class="img-fluid" src="{{ asset('assets/images/logo.svg') }}" alt="">
        </a>
    </div>

    <div class="g-sidebar-toggle">
        <span class="border-1 p-1 mb-0 vertical-menu-btn h5 d-flex align-items-center">
            <i class="bi bi-list"></i>
        </span>
    </div>

    <div class="g-breadcrumb-area">
        <h5 class="mb-0 fw-bold">@if(isset($title) && isset($dataPack->headerLink)) <a href="{{ route($dataPack->headerLink) }}" class="text-decoration-none text-black">{{ $title }}</a> @else {{" "}} @endif</h5>

    </div>
    @if(isset($dataPack->routeLink))
        <div class="g-add-new">
            <a href="{{ route($dataPack->routeLink) }}" class="btn btn-outline-primary btn-sm fw-bold"><i class="bi bi-plus-lg"></i> Add New</a>
        </div>
    @endif

    <!--        User Profile-->
    @include('common.top-nav')
    <!--        End User Profile-->

    <!--Mobile Menu-->
    <div class="g-mobile-trigger">
        <i class="bi bi-justify-right"></i>
    </div>
</div>
@include('common.success_error')
