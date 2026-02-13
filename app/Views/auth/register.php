<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Daftar ke Sistem Informasi Budaya Sekolah Aman Nasional">
    <title>Daftar - BSAN</title>

    <link rel="stylesheet" href="/assets/css/app.css">
    <link rel="icon" href="/assets/icon/favicon.ico">
    <script>
        (function() {
            var saved = localStorage.getItem('bsan-theme');
            if (saved) document.documentElement.setAttribute('data-theme', saved);
            else if (window.matchMedia('(prefers-color-scheme: dark)').matches) document.documentElement.setAttribute('data-theme', 'dark');
        })();
    </script>
</head>

<body>
    <!-- Theme Toggle -->
    <button id="auth-theme-toggle" onclick="toggleAuthTheme()" style="position: fixed; top: 1rem; right: 1rem; z-index: 50; padding: 0.5rem; border-radius: 0.5rem; border: 1px solid var(--color-border); background: var(--color-bg-alt); color: var(--color-text); cursor: pointer; display: inline-flex; align-items: center; justify-content: center;"></button>
    <script>
        function getAuthThemeIcon() {
            var isDark = document.documentElement.getAttribute('data-theme') === 'dark';
            var sun = '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" stroke="none"><circle cx="12" cy="12" r="5"/><g stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></g></svg>';
            var moon = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>';
            return isDark ? sun : moon;
        }
        function toggleAuthTheme() {
            var current = document.documentElement.getAttribute('data-theme') || 'light';
            var next = current === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', next);
            localStorage.setItem('bsan-theme', next);
            document.getElementById('auth-theme-toggle').innerHTML = getAuthThemeIcon();
        }
        document.getElementById('auth-theme-toggle').innerHTML = getAuthThemeIcon();
    </script>

    <div class="auth-page">
        <div class="auth-page__bg"></div>

        <div class="auth-card">
            <div class="auth-card__logo">
                <img src="/assets/icon/0 Logo Kemendikdasmen Puspeka Hitam.png" alt="Logo Kemendikdasmen" class="logo-light">
                <img src="/assets/icon/0 Logo Kemendikdasmen Puspeka Putih.png" alt="Logo Kemendikdasmen" class="logo-dark">
                <p>Sistem Informasi Budaya Sekolah Aman Nasional</p>
            </div>

            <div class="auth-card__form">
                <h2 class="auth-card__title">Hubungi Koordinator</h2>

                <div class="alert alert--warning" style="margin-bottom: var(--spacing-6)">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Pendaftaran akun baru dilakukan melalui Koordinator Provinsi/Kabupaten/Kota.</span>
                </div>

                <div
                    style="background: var(--color-gray-50); border-radius: var(--radius-lg); padding: var(--spacing-4); margin-bottom: var(--spacing-6)">
                    <h4 style="font-weight: 600; margin-bottom: var(--spacing-3)">Langkah Pendaftaran:</h4>
                    <ol style="margin-left: var(--spacing-4); color: var(--color-text-muted); font-size: 0.875rem">
                        <li style="margin-bottom: var(--spacing-2)">Hubungi Koordinator Pokja di wilayah Anda</li>
                        <li style="margin-bottom: var(--spacing-2)">Siapkan data diri dan dokumen pendukung</li>
                        <li style="margin-bottom: var(--spacing-2)">Koordinator akan mendaftarkan akun Anda</li>
                        <li>Anda akan menerima email aktivasi</li>
                    </ol>
                </div>

                <div style="text-align: center">
                    <p style="font-size: 0.875rem; color: var(--color-text-muted); margin-bottom: var(--spacing-4)">
                        Untuk informasi lebih lanjut, hubungi:
                    </p>
                    <a href="mailto:puspeka@dikdasmen.go.id" class="btn btn--blue">
                        📧 puspeka@dikdasmen.go.id
                    </a>
                </div>

                <div class="auth-card__footer">
                    <p>
                        Sudah punya akun?
                        <a href="/auth/login">Masuk di sini</a>
                    </p>
                </div>
            </div>

            <p class="auth-page__copyright">
                © 2026 Kementerian Pendidikan Dasar dan Menengah
            </p>
        </div>
    </div>
</body>

</html>
