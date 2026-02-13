<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Reset password akun BSAN">
    <title>Lupa Password - BSAN</title>

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
                <h2 class="auth-card__title">Lupa Password</h2>

                <p style="text-align: center; color: var(--color-text-muted); margin-bottom: var(--spacing-6)">
                    Masukkan email Anda dan kami akan mengirimkan link untuk reset password.
                </p>

                <!-- Alert -->
                <div id="forgot-alert" class="alert" style="display: none; margin-bottom: var(--spacing-6)">
                    <span id="forgot-alert-message"></span>
                    <button class="alert__close" onclick="hideAlert()">&times;</button>
                </div>

                <form id="forgot-form" onsubmit="handleForgot(event)">
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-input" placeholder="nama@email.com"
                            required>
                    </div>

                    <button type="submit" id="forgot-btn" class="btn btn--blue btn--full btn--lg">
                        <span id="forgot-btn-text">Kirim Link Reset</span>
                        <div id="forgot-spinner" class="spinner" style="display: none; margin-left: var(--spacing-2)">
                        </div>
                    </button>
                </form>

                <div class="auth-card__footer">
                    <p>
                        Ingat password?
                        <a href="/auth/login">Kembali ke Login</a>
                    </p>
                </div>
            </div>

            <p class="auth-page__copyright">
                © 2026 Kementerian Pendidikan Dasar dan Menengah
            </p>
        </div>
    </div>

    <script>
        function showAlert(message, type = 'error') {
            const alert = document.getElementById('forgot-alert');
            const alertMessage = document.getElementById('forgot-alert-message');
            alert.className = `alert alert--${type}`;
            alertMessage.textContent = message;
            alert.style.display = 'flex';
        }

        function hideAlert() {
            document.getElementById('forgot-alert').style.display = 'none';
        }

        function setLoading(loading) {
            const btn = document.getElementById('forgot-btn');
            const btnText = document.getElementById('forgot-btn-text');
            const spinner = document.getElementById('forgot-spinner');

            btn.disabled = loading;
            btnText.textContent = loading ? 'Mengirim...' : 'Kirim Link Reset';
            spinner.style.display = loading ? 'block' : 'none';
        }

        async function handleForgot(e) {
            e.preventDefault();
            hideAlert();
            setLoading(true);

            const email = document.getElementById('email').value;

            try {
                // Demo mode
                await new Promise(resolve => setTimeout(resolve, 1000));

                showAlert('Link reset password telah dikirim ke email Anda. Silakan cek inbox Anda.', 'success');
                document.getElementById('forgot-form').reset();
            } catch (err) {
                showAlert(err.message || 'Gagal mengirim link reset. Silakan coba lagi.');
            } finally {
                setLoading(false);
            }
        }
    </script>
</body>

</html>
