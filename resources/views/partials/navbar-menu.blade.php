<div id="navigation">
    <!-- Navigation Menu-->
    <ul class="navigation-menu nav-right nav-light">
        @php $role = auth()->check() ? auth()->user()->role : null; @endphp

        @if($role === 'kandidat')
            <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">{{ __('Dashboard') }}</a></li>
            <li><a href="{{ route('jobs.browse') }}" class="{{ request()->routeIs('jobs.*') ? 'active' : '' }}">{{ __('Jobs') }}</a></li>
            <li><a href="{{ route('kandidat.lowongan-dilamar') }}" class="{{ request()->routeIs('kandidat.lowongan-dilamar') ? 'active' : '' }}">{{ __('Lamaran Saya') }}</a></li>
            <li><a href="{{ route('profile.show') }}" class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">{{ __('Profil') }}</a></li>
        @elseif($role === 'officer')
            @php $jabatan = strtolower(optional(auth()->user()->officer)->jabatan); @endphp
            <li><a href="{{ route('officers.index') }}" class="{{ request()->routeIs('officers.index') ? 'active' : '' }}">{{ __('Officers') }}</a></li>
            <li><a href="{{ route('kategori-lowongan.Index') }}" class="{{ request()->routeIs('kategori-lowongan.*') ? 'active' : '' }}">{{ __('Kategori Lowongan') }}</a></li>
            <li><a href="{{ route('Lowongan.Index') }}" class="{{ request()->routeIs('Lowongan.*') ? 'active' : '' }}">{{ __('Lowongan') }}</a></li>
            <li><a href="{{ route('lamaran-lowongan.index') }}" class="{{ request()->routeIs('lamaran-lowongan.index') ? 'active' : '' }}">{{ __('Lamaran') }}</a></li>
            <li><a href="{{ route('jadwal-interview.index') }}" class="{{ request()->routeIs('jadwal-interview.index') ? 'active' : '' }}">{{ __('Jadwal Interview') }}</a></li>
            <li><a href="{{ route('test-results.index') }}" class="{{ request()->routeIs('test-results.*') ? 'active' : '' }}">{{ __('Hasil Test CBT') }}</a></li>
            @if(in_array($jabatan, ['manager','coordinator']))
                <li><a href="{{ route('bank-soal.index') }}" class="{{ request()->routeIs('bank-soal.*') ? 'active' : '' }}">{{ __('Bank Soal') }}</a></li>
            @endif
        @else
            <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">{{ __('Home') }}</a></li>
            <li><a href="{{ route('jobs.browse') }}" class="{{ request()->routeIs('jobs.*') ? 'active' : '' }}">{{ __('Jobs') }}</a></li>
        @endif
    </ul><!--end navigation menu-->
</div><!--end navigation-->
