<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Masuk ke Sistem Informasi Budaya Sekolah Aman Nasional">
    <title>Masuk - BSAN</title>

    <link rel="stylesheet" href="/assets/css/app.css">
    <link rel="icon" href="/assets/icon/favicon.ico">
    <script>
        // Apply saved theme immediately to prevent flash
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
        <!-- Background decoration -->
        <div class="auth-page__bg"></div>

        <div class="auth-card">
            <!-- Logo -->
            <div class="auth-card__logo">
                <img src="/assets/icon/0 Logo Kemendikdasmen Puspeka Hitam.png" alt="Logo Kemendikdasmen" class="logo-light">
                <img src="/assets/icon/0 Logo Kemendikdasmen Puspeka Putih.png" alt="Logo Kemendikdasmen" class="logo-dark">
                <p>Sistem Informasi Budaya Sekolah Aman Nasional</p>
            </div>

            <!-- Login Form -->
            <div class="auth-card__form">
                <h2 class="auth-card__title">Masuk ke Akun</h2>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert--error" style="margin-bottom: var(--spacing-6)">
                        <span><?= session()->getFlashdata('error') ?></span>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert--success" style="margin-bottom: var(--spacing-6)">
                        <span><?= session()->getFlashdata('success') ?></span>
                    </div>
                <?php endif; ?>

                <form id="login-form" action="/auth/login" method="POST">
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-input" placeholder="nama@email.com"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-input" placeholder="••••••••"
                            required>
                    </div>

                    <div class="flex justify-between items-center" style="margin-bottom: var(--spacing-5)">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" class="form-checkbox" name="remember">
                            <span style="font-size: 0.875rem; color: var(--color-gray-600)">Ingat saya</span>
                        </label>
                        <a href="/auth/forgot-password"
                            style="font-size: 0.875rem; color: var(--color-primary-light)">Lupa password?</a>
                    </div>

                    <button type="submit" id="login-btn" class="btn btn--blue btn--full btn--lg">
                        <span id="login-btn-text">Masuk</span>
                    </button>
                </form>

                <div class="auth-card__footer">
                    <p>
                        Belum punya akun?
                        <a href="/auth/register">Hubungi Koordinator</a>
                    </p>
                </div>

                <!-- Demo Quick Login -->
                <div style="margin-top: var(--spacing-6); padding-top: var(--spacing-5); border-top: 1px solid var(--color-border);">
                    <p style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-gray-500); margin-bottom: var(--spacing-3); font-weight: 600;">Demo Login</p>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                        <button type="button" onclick="demoLogin('admin@bsan.id','admin123')" style="padding: 0.5rem; border-radius: 0.5rem; border: 1px solid var(--color-border); background: var(--color-bg-alt); color: var(--color-text); cursor: pointer; font-size: 0.75rem; text-align: center; transition: all 0.15s;">
                            <span style="font-weight: 600; display: block;">🏛️ Admin Pusat</span>
                            <span style="color: var(--color-gray-500); font-size: 0.65rem;">admin@bsan.id</span>
                        </button>
                        <button type="button" onclick="demoLogin('koordinator@bsan.id','koordinator123')" style="padding: 0.5rem; border-radius: 0.5rem; border: 1px solid var(--color-border); background: var(--color-bg-alt); color: var(--color-text); cursor: pointer; font-size: 0.75rem; text-align: center; transition: all 0.15s;">
                            <span style="font-weight: 600; display: block;">👤 Koordinator</span>
                            <span style="color: var(--color-gray-500); font-size: 0.65rem;">koordinator@bsan.id</span>
                        </button>
                        <button type="button" onclick="demoLogin('jateng@bsan.id','jateng123')" style="padding: 0.5rem; border-radius: 0.5rem; border: 1px solid var(--color-border); background: var(--color-bg-alt); color: var(--color-text); cursor: pointer; font-size: 0.75rem; text-align: center; transition: all 0.15s;">
                            <span style="font-weight: 600; display: block;">🏢 Prov. Jawa Tengah</span>
                            <span style="color: var(--color-gray-500); font-size: 0.65rem;">jateng@bsan.id</span>
                        </button>
                        <button type="button" onclick="demoLogin('dki@bsan.id','dki123')" style="padding: 0.5rem; border-radius: 0.5rem; border: 1px solid var(--color-border); background: var(--color-bg-alt); color: var(--color-text); cursor: pointer; font-size: 0.75rem; text-align: center; transition: all 0.15s;">
                            <span style="font-weight: 600; display: block;">🏢 Prov. DKI Jakarta</span>
                            <span style="color: var(--color-gray-500); font-size: 0.65rem;">dki@bsan.id</span>
                        </button>
                        <button type="button" onclick="demoLogin('surakarta@bsan.id','surakarta123')" style="padding: 0.5rem; border-radius: 0.5rem; border: 1px solid var(--color-border); background: var(--color-bg-alt); color: var(--color-text); cursor: pointer; font-size: 0.75rem; text-align: center; transition: all 0.15s;">
                            <span style="font-weight: 600; display: block;">🏫 Kota Surakarta</span>
                            <span style="color: var(--color-gray-500); font-size: 0.65rem;">surakarta@bsan.id</span>
                        </button>
                        <button type="button" onclick="demoLogin('bandung@bsan.id','bandung123')" style="padding: 0.5rem; border-radius: 0.5rem; border: 1px solid var(--color-border); background: var(--color-bg-alt); color: var(--color-text); cursor: pointer; font-size: 0.75rem; text-align: center; transition: all 0.15s;">
                            <span style="font-weight: 600; display: block;">🏫 Kota Bandung</span>
                            <span style="color: var(--color-gray-500); font-size: 0.65rem;">bandung@bsan.id</span>
                        </button>
                    </div>
                </div>
                <script>
                    function demoLogin(email, password) {
                        document.getElementById('email').value = email;
                        document.getElementById('password').value = password;
                        document.getElementById('login-form').submit();
                    }
                </script>
            </div>

            <!-- Copyright -->
            <p class="auth-page__copyright">
                © 2026 Kementerian Pendidikan Dasar dan Menengah
            </p>
        </div>
    </div>
</body>

</html>
