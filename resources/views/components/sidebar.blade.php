<input type="checkbox" id="sidebar-toggle" />

<label for="sidebar-toggle" class="overlay"></label>

<nav id="sidebar" class="sidebar">
    @auth

        <ul class="navbar-nav internal-links-list"><!-- todo: use view composer -->
            <li class="nav-item">
                <a href="/my-account/info" class="navbar-text">My Account</a>
            </li>
            <li class="nav-item">
                <a href="/my-account/logos" class="navbar-text">Saved Logos</a>
            </li>
            <li class="nav-item">
                <a href="/my-account/orders" class="navbar-text">Order History</a>
            </li>
        </ul>
        <ul class="navbar-nav internal-links-list">
            <li class="nav-item">
                <form id="sidebar-logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button type="submit" class="bg-transparent border-0 w-100">
                        <a class="navbar-text">
                            {{ __('Logout') }}
                        </a>
                    </button>
                </form>
            </li>
        </ul>
    @elseauth

    @endauth
</nav>