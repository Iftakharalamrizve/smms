<div class="g-topbar-user-profile">

    {{-- <div aria-labelledby="icon" class="g-grid-icon">
        <small>Filter Search</small>
        <i class="bi bi-search"></i>
    </div> --}}

    {{-- <div class="g-user-guide">
        <i class="bi bi-book-fill"></i>
    </div>
    <div class="g-user-mail-notification">
        <i class="bi bi-envelope-fill"></i>
    </div>
    <div class="g-user-notification">
        <i class="bi bi-bell-fill"></i>
    </div> --}}

    <div class="g-user-image dropdown">
            <span class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">

            <img class="img-fluid" src="{{ asset('assets/images/user.jpg') }}" alt="">
            </span>
        <ul class="dropdown-menu g-dropdown-profile mt-4">
            <li><a class="dropdown-item" href="#"><i class="bi bi-card-heading"></i> Profile</a></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-gear-fill"></i> Settings</a></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-toggles"></i> Status</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="{{ route('logout') }}"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
        </ul>
    </div>
</div>
