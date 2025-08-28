
        <!-- Navbar STart -->
        <header id="topnav" class="defaultscroll sticky" x-data="{
            settingsOpen:false,
            dark:false,
            init(){
                const saved=localStorage.getItem('theme');
                this.dark = saved ? saved==='dark' : window.matchMedia('(prefers-color-scheme: dark)').matches;
                this.applyTheme();
            },
            applyTheme(){ document.documentElement.classList.toggle('dark', this.dark); localStorage.setItem('theme', this.dark?'dark':'light'); }
        }">
            <div class="container">
                <a class="logo" href="index.html">
                    <span class="logo-light-mode">
                        <img src="images/logo-dark.png" class="l-dark" alt="">
                        <img src="images/logo-light.png" class="l-light" alt="">
                    </span>
                    <img src="images/logo-light.png" class="logo-dark-mode" alt="">
                </a>

                <div class="menu-extras">
                    <div class="menu-item">
                        <a class="navbar-toggle" id="isToggle" onclick="toggleMenu()">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                    </div>
                </div>

                <ul class="buy-button list-inline mb-0">
                    <li class="list-inline-item ps-1 mb-0">
                        <div class="dropdown">
                            <button type="button" class="dropdown-toggle btn btn-sm btn-icon btn-pills btn-primary" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i data-feather="search" class="icons"></i>
                            </button>
                            <div class="dropdown-menu dd-menu dropdown-menu-end bg-white rounded border-0 mt-3 p-0" style="width: 240px;">
                                <div class="search-bar">
                                    <div id="itemSearch" class="menu-search mb-0">
                                        <form role="search" method="get" id="searchItemform" class="searchform">
                                            <input type="text" class="form-control rounded border" name="s" id="searchItem" placeholder="Search...">
                                            <input type="submit" id="searchItemsubmit" value="Search">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    @auth
                    <li class="list-inline-item ps-1 mb-0">
                        <div class="dropdown dropdown-primary">
                            <button type="button" class="dropdown-toggle btn btn-sm btn-icon btn-pills btn-primary" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="images/team/01.jpg" class="img-fluid rounded-pill" alt="">
                            </button>
                            <div class="dropdown-menu dd-menu dropdown-menu-end bg-white rounded shadow border-0 mt-3">
                                @php $role = strtolower(auth()->user()->role ?? ''); @endphp
                                <a href="{{ $role === 'kandidat' ? route('profile.show') : route('officers.index') }}" class="dropdown-item fw-medium fs-6">
                                    <i data-feather="user" class="fea icon-sm me-2 align-middle"></i>Profile
                                </a>
                                @if($role === 'kandidat')
                                    <a href="#" @click.prevent="settingsOpen=true" class="dropdown-item fw-medium fs-6">
                                        <i data-feather="settings" class="fea icon-sm me-2 align-middle"></i>Settings
                                    </a>
                                @endif
                                <div class="dropdown-divider border-top"></div>
                                <a href="lock-screen.html" class="dropdown-item fw-medium fs-6"><i data-feather="lock" class="fea icon-sm me-2 align-middle"></i>Lockscreen</a>
                                <form method="POST" action="{{ route('logout') }}" x-data class="d-inline w-100">
                                    @csrf
                                    <button type="submit" class="dropdown-item fw-medium fs-6 border-0 bg-transparent p-0 ps-3 py-2 w-100 text-start"
                                            onclick="event.preventDefault(); this.closest('form').submit();">
                                        <i data-feather="log-out" class="fea icon-sm me-2 align-middle"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                    @endauth
                    @guest
                    <li class="list-inline-item ps-1 mb-0">
                        <a href="{{ route('login') }}" class="btn btn-sm btn-primary">Login</a>
                    </li>
                    @endguest
                </ul>

                @include('partials.navbar-menu')
            </div>
        </header>
        <!-- Navbar End -->

        <!-- Settings Modal -->
        <div x-cloak x-show="settingsOpen" class="fixed inset-0 z-50 d-flex align-items-center justify-content-center">
            <div class="position-fixed top-0 start-0 end-0 bottom-0 bg-dark bg-opacity-50" @click="settingsOpen=false"></div>
            <div class="position-relative bg-white dark:bg-gray-800 rounded shadow p-4" style="width: 100%; max-width: 420px;">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                    <h6 class="mb-0">App Settings</h6>
                    <button class="btn btn-sm btn-light" @click="settingsOpen=false">&times;</button>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <div class="fw-semibold">Dark Mode</div>
                        <small class="text-muted">Switch between light and dark theme</small>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="navDarkSwitch" x-model="dark" @change="applyTheme">
                    </div>
                </div>
                <div class="text-end pt-2 border-top mt-3">
                    <button class="btn btn-primary btn-sm" @click="settingsOpen=false">Close</button>
                </div>
            </div>
            <style>[x-cloak]{display:none!important}</style>
        </div>

