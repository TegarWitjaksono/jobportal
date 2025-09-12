<!-- Footer Start -->
<footer class="bg-footer">
    <div class="container">
        <div class="row py-5">
            <div class="col-lg-4 col-md-6">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('storage/image/logo.png') }}" alt="Logo" class="mb-3 img-fluid footer-logo" loading="lazy">
                </a>
                <p class="mb-1 text-foot fw-semibold">PT. Multindo Technology Utama</p>
                <p class="mb-2 text-foot">Mining & Industrial Service</p>
                <p class="mb-1 text-foot"><i class="mdi mdi-map-marker-outline me-2"></i>Jl. Raya Mustikasari No.124, Padurenan, Mustika Jaya, Kota Bekasi, Jawa Barat 16340</p>
                <p class="mb-1 text-foot"><i class="mdi mdi-email-outline me-2"></i>hrd@multindo.co.id</p>
                <p class="mb-0 text-foot"><i class="mdi mdi-phone-outline me-2"></i>+62 21 1234 5678</p>
            </div>

            <div class="col-6 col-lg-2 col-md-6 mt-4 mt-md-0">
                <h6 class="text-white footer-head mb-3">Perusahaan</h6>
                <ul class="list-unstyled footer-list">
                    <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right me-2"></i>Tentang Kami</a></li>
                    <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right me-2"></i>Layanan</a></li>
                    <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right me-2"></i>Karier</a></li>
                    <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right me-2"></i>Kontak</a></li>
                </ul>
            </div>

            <div class="col-6 col-lg-2 col-md-6 mt-4 mt-md-0">
                <h6 class="text-white footer-head mb-3">Pelamar</h6>
                <ul class="list-unstyled footer-list">
                    <li><a href="{{ route('jobs.browse') }}" class="text-foot"><i class="mdi mdi-chevron-right me-2"></i>Cari Lowongan</a></li>
                    <li><a href="{{ route('kandidat.lowongan-dilamar') }}" class="text-foot"><i class="mdi mdi-chevron-right me-2"></i>Lowongan Dilamar</a></li>
                    <li><a href="{{ route('cbt.dashboard') }}" class="text-foot"><i class="mdi mdi-chevron-right me-2"></i>Tes Seleksi</a></li>
                    <li><a href="{{ route('profile.show') }}" class="text-foot"><i class="mdi mdi-chevron-right me-2"></i>Profil</a></li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-12 mt-4 mt-lg-0">
                <h6 class="text-white footer-head mb-3">Terhubung</h6>
                <p class="text-foot mb-3">Ikuti kami di media sosial untuk update terbaru.</p>
                <ul class="list-unstyled social-icon foot-social-icon mb-0">
                    <li class="list-inline-item"><a href="#" target="_blank" class="rounded" aria-label="LinkedIn"><i data-feather="linkedin" class="fea icon-sm align-middle"></i></a></li>
                    <li class="list-inline-item"><a href="#" target="_blank" class="rounded" aria-label="Instagram"><i data-feather="instagram" class="fea icon-sm align-middle"></i></a></li>
                    <li class="list-inline-item"><a href="#" target="_blank" class="rounded" aria-label="Facebook"><i data-feather="facebook" class="fea icon-sm align-middle"></i></a></li>
                    <li class="list-inline-item"><a href="#" target="_blank" class="rounded" aria-label="YouTube"><i data-feather="youtube" class="fea icon-sm align-middle"></i></a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="py-4 footer-bar">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 fw-medium">&copy; <script>document.write(new Date().getFullYear())</script> PT. Multindo Technology Utama.</p>
                </div>
                <div class="col-md-6 mt-3 mt-md-0 text-center text-md-end">
                    <ul class="list-unstyled footer-list terms-service mb-0">
                        <li class="list-inline-item my-1"><a href="#" class="text-foot">Kebijakan Privasi</a></li>
                        <li class="list-inline-item my-1"><span class="text-foot">•</span></li>
                        <li class="list-inline-item my-1"><a href="#" class="text-foot">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer><!--end footer-->
<!-- Footer End -->
