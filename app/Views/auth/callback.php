<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi - BSAN</title>
    <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
</head>
<body>
    <div style="display:flex;align-items:center;justify-content:center;min-height:100vh;font-family:sans-serif;">
        <div style="text-align:center;padding:2rem;">
            <h1>Memverifikasi...</h1>
            <p id="status">Mohon tunggu sebentar.</p>
        </div>
    </div>

    <script>
        (async function () {
            const hash = window.location.hash.substring(1);
            const params = new URLSearchParams(hash);
            const accessToken = params.get('access_token');
            const refreshToken = params.get('refresh_token');
            const type = params.get('type');

            if (type === 'recovery') {
                // Redirect to reset password page
                window.location.href = '/auth/reset-password#' + hash;
                return;
            }

            if (accessToken) {
                // Store token in session via API call
                try {
                    const res = await fetch('/api/auth/session', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ access_token: accessToken, refresh_token: refreshToken }),
                    });
                    if (res.ok) {
                        document.getElementById('status').textContent = 'Berhasil! Mengalihkan ke dashboard...';
                        setTimeout(() => window.location.href = '/dashboard', 1000);
                    } else {
                        document.getElementById('status').textContent = 'Gagal memverifikasi. Silakan coba masuk kembali.';
                    }
                } catch (e) {
                    document.getElementById('status').textContent = 'Error: ' + e.message;
                }
            } else {
                document.getElementById('status').textContent = 'Email berhasil diverifikasi! Silakan masuk.';
                setTimeout(() => window.location.href = '/auth/login', 2000);
            }
        })();
    </script>
</body>
</html>
