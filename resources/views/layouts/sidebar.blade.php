<!-- resources/views/layouts/sidebar.blade.php -->
<div class="sidebar">
    <div class="logo">
        <div class="logo-icon">MD</div>
        <div>
            <h4>Desa Maket</h4>
            <small>Admin Panel</small>
        </div>
    </div>

    <ul class="nav flex-column">
        <!-- Dashboard -->
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" 
               class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- DATA PENDUDUK -->
        <li>
            <a href="/admin/data-penduduk" 
                class="flex items-center gap-3 px-5 py-4 hover:bg-gray-800 text-gray-300 hover:text-white transition-all {{ request()->is('admin/data-penduduk*') ? 'bg-gray-800 text-white' : '' }}">
                <span class="text-2xl">👥</span>
                <span class="font-medium">Data Penduduk</span>
            </a>
        </li>

        <!-- Pengajuan Surat (yang sedang kita kerjakan) -->
        <li class="nav-item">
            <a href="{{ route('admin.pengajuan-surat.index') }}" 
               class="nav-link {{ request()->routeIs('admin.pengajuan-surat.*') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i>
                <span>Pengajuan Surat</span>
            </a>
        </li>

        <!-- Pengaduan Masyarakat -->
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-exclamation-triangle"></i>
                <span>Pengaduan Masyarakat</span>
            </a>
        </li>

        <!-- Laporan & Statistik -->
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-chart-bar"></i>
                <span>Laporan & Statistik</span>
            </a>
        </li>

        <!-- Keuangan Desa -->
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-money-bill-wave"></i>
                <span>Keuangan Desa</span>
            </a>
        </li>

        <!-- Pengaturan -->
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-cog"></i>
                <span>Pengaturan</span>
            </a>
        </li>
    </ul>
</div>