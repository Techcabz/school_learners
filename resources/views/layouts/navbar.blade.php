<header class="topbar">
    <div class="boxTopNav">
        <p>&nbsp;</p>
    </div>
    <nav class="navbar top-navbar navbar-expand-md navbar-light">
        <div class="navbar-header d-flex justify-content-start align-items-center gap-3">
            <a class="navbar-brand" href="">
                <img src="{{ asset('images/favicon.webp') }}" alt="LOGO" class="logo" />
            </a>
            <div class="title-container">
                <h4 class="fw-bold">
                    <strong>Learner's Permanent Academic Records</strong>
                </h4>
            </div>
        </div>

        @auth


            <div class="navbar-collapse">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown account u-pro">
                        <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic"
                            href="{{ route('dashboard') }}">
                            <span
                                class="{{ Request::is('admin/dashboard') ? 'active-nav' : 'not-active-nav' }}
">Dashboard</span></a>
                    </li>
                    <li class="nav-item dropdown account u-pro">
                        <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic"
                            href="{{ route('records.view') }}">
                            <span class="{{ Request::is('admin/records') ? 'active-nav' : 'not-active-nav' }}
">Academic
                                Records</span></a>
                    </li>

                    <li class="nav-item dropdown account u-pro">
                        <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="#"
                            id="navbarDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="{{ Request::is('admin/year') ? 'active-nav' : 'not-active-nav' }}
">Management</span></a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="btn btn-sm btn-outline m-2 btn-drop waves-effect waves-dark"
                                    href="{{ route('users.management') }}"><span>Users</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-sm btn-outline m-2 btn-drop waves-effect waves-dark"
                                    href=""><span>Report</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown account u-pro">
                        <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="#"
                            id="navbarDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="{{ Request::is('admin/year') ? 'active-nav' : 'not-active-nav' }}
">Account</span></a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="btn btn-sm btn-outline m-2 btn-drop waves-effect waves-dark"
                                    href=""><span>Profile</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-sm btn-outline m-2 btn-drop waves-effect waves-dark"
                                    href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"><span>Logout</span>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </a>



                            </li>
                        </ul>
                    </li>
                </ul>

            @endauth

            @guest
                <div class="navbar-collapse">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown account u-pro">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic"
                                href="{{ route('login.custom') }}">
                                <span class="{{ Request::is('/') ? 'active-nav' : 'not-active-nav' }}
">Login</span></a>
                        </li>
                        <li class="nav-item dropdown account u-pro">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic"
                                href="{{ route('register.custom') }}">
                                <span class="{{ Request::is('register') ? 'active-nav' : 'not-active-nav' }}
">Register</span></a>
                        </li>
                    </ul>

                @endguest
            </div>
    </nav>
</header>
