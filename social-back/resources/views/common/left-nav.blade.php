<aside class="">
    <!--Sidebar Area-->

    <div class="vertical-menu mm-active">
        <div data-simplebar class="sidebar-menu-scroll mm-show">

            <!--- Sidemenu -->
            <div id="sidebar-menu">
                <!-- Left Menu Start -->
                <ul class="metismenu list-unstyled" id="side-menu">
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bi bi-people-fill"></i>
                            <span>Agents</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('agent.index') }}" class="waves-effect">
                                    <i class="bi bi-person-video2"></i>
                                    <span>Agent List</span>
                                </a>

                            </li>
                            <li>
                                <a href="{{ route('agent.create') }}" class="waves-effect">
                                    <i class="bi bi-person-plus-fill"></i>
                                    <span>Create Agent</span>
                                </a>

                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('social-platform.index') }}" class="waves-effect">
                            <i class="bi bi-chat-quote"></i>
                            <span>Social Platforms</span>
                        </a>

                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bi bi-gear"></i>
                            <span>Setting</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{route('users.index')}}"> <i class="bi bi-journal-check"></i>
                                    Systems Users</a>
                            </li>
                            <li>
                                <a href="{{route('roles.index')}}"> <i class="bi bi-journal-check"></i>
                                    Systems Roles</a>
                            </li>
                            <li>
                                <a href="{{route('permissions.index')}}"> <i class="bi bi-journal-check"></i>
                                    Systems Permissions</a>
                            </li>

                            <li>
                                <a href="{{route('webhook-log.index')}}"> <i class="bi bi-list"></i>
                                    Webhook Log</a>
                            </li>
                        </ul>
                    </li>

                    {{-- <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bi bi-box-fill"></i>
                            <span>Layouts</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            <li>
                                <a href="javascript: void(0);" class="has-arrow">Vertical</a>
                                <ul class="sub-menu" aria-expanded="true">
                                    <li><a href="layouts-dark-sidebar">Dark Sidebar</a></li>
                                    <li><a href="layouts-compact-sidebar">Compact Sidebar</a></li>
                                    <li><a href="layouts-icon-sidebar">Icon Sidebar</a></li>
                                    <li><a href="layouts-boxed">Boxed Width</a></li>
                                    <li><a href="layouts-preloader">Preloader</a></li>
                                    <li><a href="layouts-colored-sidebar">Colored Sidebar</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow">Horizontal</a>
                                <ul class="sub-menu" aria-expanded="true">
                                    <li><a href="layouts-horizontal">Horizontal</a></li>
                                    <li><a href="layouts-hori-topbar-dark">Topbar Dark</a></li>
                                    <li><a href="layouts-hori-boxed-width">Boxed Width</a></li>
                                    <li><a href="layouts-hori-preloader">Preloader</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li> --}}

                </ul>
            </div>
            <!-- Sidebar -->
        </div>
    </div>



    <!-- Close Icon -->
    <div class="g-close-icon">
        <span class="bi bi-x-lg"></span>
    </div>
    <!-- end close Icon -->
</aside>
