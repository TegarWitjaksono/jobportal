
        <!-- Navbar STart -->
        <header id="topnav" class="defaultscroll sticky" x-data="{
            settingsOpen:false,
            authPromptOpen:false,
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

                <!-- Removed hamburger (three lines) toggle as requested -->

                <ul class="buy-button list-inline mb-0 d-flex align-items-center gap-2">
                    @auth
                    <li class="list-inline-item ps-1 mb-0 align-middle">
                        @php
                            $user = auth()->user();
                            $firstName = optional($user->kandidat)->nama_depan ?? \Illuminate\Support\Str::before($user->name ?? '', ' ');
                            $isOfficer = $user->is_officer;
                            $badgeClass = $isOfficer ? $user->role_badge_class : 'bg-soft-success text-success';
                            $icon = $isOfficer ? 'shield' : 'user';
                            $label = $isOfficer ? $user->role_badge_label : null; // hide role label for kandidat
                        @endphp
                        <div class="dropdown role-dropdown d-inline-flex align-items-center">
                            <a href="#" class="dropdown-toggle badge rounded-pill {{ $badgeClass }} px-3 py-2 d-inline-flex align-items-center role-badge-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i data-feather="{{ $icon }}" class="fea icon-sm me-1 align-middle"></i>
                                <span class="fw-semibold">{{ $firstName }}</span>
                                @if($label)
                                    <span class="mx-1">-</span>
                                    <span>{{ $label }}</span>
                                @endif
                                <i class="mdi mdi-chevron-down ms-1"></i>
                            </a>
                            <div class="dropdown-menu dd-menu dropdown-menu-end bg-white rounded shadow border-0 mt-3">
                                <a href="{{ auth()->user()->is_kandidat ? route('profile.show') : route('officers.index') }}" class="dropdown-item fw-medium fs-6 d-flex align-items-center">
                                    <i data-feather="user" class="fea icon-sm me-2 align-middle"></i>
                                    <span>Profile</span>
                                </a>
                                <div class="dropdown-divider border-top"></div>
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

                    @auth @endauth
                    @guest
                    <li class="list-inline-item ps-1 mb-0">
                        <a href="javascript:void(0)" class="btn btn-sm btn-primary" @click="authPromptOpen=true">
                            <i data-feather="log-in" class="fea icon-sm me-1 align-middle"></i>
                            Login
                        </a>
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

        <!-- Auth Prompt Modal (Guest) -->
        @guest
        <div x-cloak x-show="authPromptOpen" class="fixed inset-0 z-50 d-flex align-items-center justify-content-center">
            <div class="position-fixed top-0 start-0 end-0 bottom-0 bg-dark bg-opacity-50" @click="authPromptOpen=false"></div>
            <div class="position-relative bg-white dark:bg-gray-800 rounded shadow p-4" style="width: 100%; max-width: 720px;">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                    <h6 class="mb-0">Masuk atau Tes Awal</h6>
                    <button class="btn btn-sm btn-light" @click="authPromptOpen=false">&times;</button>
                </div>
                <div class="mb-2 text-muted">Pilih salah satu untuk melanjutkan. Untuk pengguna baru, tes BMI & buta warna wajib sebelum membuat akun.</div>

                <div class="row g-3 mt-1">
                    <div class="col-6">
                        <div class="h-100 p-3 border rounded">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-soft-primary text-primary me-2"><i class="mdi mdi-account-check-outline"></i></span>
                                <h6 class="mb-0">Saya sudah punya akun</h6>
                            </div>
                            <p class="text-muted small mb-3">Masuk untuk melanjutkan lamaran dan menyimpan progres.</p>
                            <a href="{{ route('login') }}" class="btn btn-soft-primary w-100">
                                <i class="mdi mdi-login me-1"></i> Login
                            </a>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="h-100 p-3 border rounded">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-soft-success text-success me-2"><i class="mdi mdi-clipboard-text-outline"></i></span>
                                <h6 class="mb-0">Belum punya akun</h6>
                            </div>
                            <p class="text-muted small mb-3">Selesaikan Blind Test & BMI Test agar bisa mendaftar.</p>
                            <a href="{{ route('dashboard', [], false) }}?start_test=1" class="btn btn-primary w-100">
                                <i class="mdi mdi-clipboard-text-outline me-1"></i> Mulai Tes (Blind & BMI)
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endguest
