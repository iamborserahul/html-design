<?php
session_start();

if (isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/app.php';

$site_name = get_setting('site_name') ?: 'Khodiyar Steel Industries';
$error = '';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $csrf_token = bin2hex(random_bytes(32));
    $_SESSION['csrf_token'] = $csrf_token;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submitted_token = $_POST['csrf_token'] ?? '';
    if (!hash_equals($_SESSION['csrf_token'], $submitted_token)) {
        $error = 'Invalid security token. Please try again.';
    } else {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email === '' || $password === '') {
            $error = 'Please enter both email and password.';
        } else {
            try {
                $db = getDB();
                $stmt = $db->prepare("SELECT id, name, email, password, role, status FROM users WHERE email = :email LIMIT 1");
                $stmt->execute([':email' => $email]);
                $user = $stmt->fetch();

                if ($user && $user['status'] == 1 && password_verify($password, $user['password'])) {
                    session_regenerate_id(true);
                    $_SESSION['admin_id'] = (int) $user['id'];
                    $_SESSION['admin_name'] = $user['name'];
                    $_SESSION['admin_role'] = $user['role'];

                    $upd = $db->prepare("UPDATE users SET last_login = NOW() WHERE id = :id");
                    $upd->execute([':id' => $user['id']]);

                    header('Location: index.php');
                    exit;
                } else {
                    $error = 'Invalid email or password.';
                }
            } catch (PDOException $e) {
                $error = 'A system error occurred. Please try again later.';
            }
        }
    }
    $csrf_token = bin2hex(random_bytes(32));
    $_SESSION['csrf_token'] = $csrf_token;
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | <?= htmlspecialchars($site_name ?? 'Khodiyar Steel Industries') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Cinzel:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --bg: #f5f5f0;
            --gold: #b8860b;
            --gold-dim: rgba(184,134,11,0.08);
            --gold-glow: rgba(184,134,11,0.05);
            --text: #1a1a1a;
            --text-dim: #6b7280;
            --border: #e5e7eb;
            --card-bg: #ffffff;
        }
        html { font-size: 15px; }
        body {
            font-family: 'Outfit', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 600px 400px at 20% 30%, rgba(184,134,11,0.04) 0%, transparent 70%),
                radial-gradient(ellipse 500px 500px at 80% 70%, rgba(184,134,11,0.03) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
            padding: 1.5rem;
        }

        .login-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 2.5rem 2rem 2rem;
            box-shadow: 0 4px 24px rgba(0,0,0,0.06);
        }

        .login-logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-logo .logo-icon {
            width: 64px;
            height: 64px;
            background: var(--gold);
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-family: 'Cinzel', serif;
            font-weight: 700;
            font-size: 1.4rem;
            margin-bottom: 0.75rem;
            box-shadow: 0 4px 16px var(--gold-glow);
        }
        .login-logo h1 {
            font-family: 'Cinzel', serif;
            font-size: 1.15rem;
            color: var(--gold);
            letter-spacing: 0.5px;
        }
        .login-logo p {
            font-size: 0.75rem;
            color: var(--text-dim);
            margin-top: 0.2rem;
        }

        .form-group {
            margin-bottom: 1.1rem;
            position: relative;
        }
        .form-group .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-dim);
            font-size: 0.9rem;
            pointer-events: none;
            transition: color 0.25s;
        }
        .form-group input {
            width: 100%;
            padding: 0.7rem 1rem 0.7rem 2.6rem;
            background: #f9fafb;
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--text);
            font-family: 'Outfit', sans-serif;
            font-size: 0.85rem;
            outline: none;
            transition: all 0.3s;
        }
        .form-group input:focus {
            border-color: var(--gold);
            background: #ffffff;
            box-shadow: 0 0 0 3px var(--gold-dim);
        }
        .form-group input:focus + .input-icon,
        .form-group input:focus ~ .input-icon { color: var(--gold); }
        .form-group input::placeholder { color: var(--text-dim); font-weight: 300; }
        .form-group .toggle-pw {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-dim);
            cursor: pointer;
            font-size: 0.9rem;
            transition: color 0.25s;
            background: none;
            border: none;
            padding: 0;
        }
        .form-group .toggle-pw:hover { color: var(--text); }

        .btn-login {
            width: 100%;
            padding: 0.75rem;
            background: var(--gold);
            color: #ffffff;
            font-family: 'Outfit', sans-serif;
            font-weight: 600;
            font-size: 0.9rem;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }
        .btn-login:hover {
            background: #a07a0a;
            box-shadow: 0 4px 16px var(--gold-glow);
            transform: translateY(-1px);
        }
        .btn-login:active { transform: translateY(0); }

        .login-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.8rem;
        }
        .login-footer a {
            color: var(--gold);
            text-decoration: none;
            font-weight: 500;
            transition: opacity 0.2s;
        }
        .login-footer a:hover { opacity: 0.8; }
        .login-footer .divider {
            display: inline-block;
            margin: 0 0.75rem;
            color: var(--text-dim);
            font-size: 0.6rem;
        }

        .error-msg {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            padding: 0.6rem 1rem;
            font-size: 0.8rem;
            color: #dc2626;
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .error-msg i { font-size: 0.85rem; }

        .login-card .brand-bottom {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.2rem;
            border-top: 1px solid var(--border);
            font-size: 0.65rem;
            color: var(--text-dim);
        }
        .login-card .brand-bottom a {
            color: var(--text-dim);
            text-decoration: none;
        }
        .login-card .brand-bottom a:hover { color: var(--gold); }

        @media (max-width: 480px) {
            .login-container { padding: 1rem; }
            .login-card { padding: 1.75rem 1.25rem; }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-logo">
                <div class="logo-icon">KS</div>
                <h1><?= htmlspecialchars($site_name ?? 'Khodiyar Steel') ?></h1>
                <p>Admin Panel Login</p>
            </div>

            <?php if ($error): ?>
                <div class="error-msg">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="post" autocomplete="off">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">

                <div class="form-group">
                    <input type="email" id="email" name="email" placeholder="Email Address" required autofocus>
                    <span class="input-icon"><i class="fa-regular fa-envelope"></i></span>
                </div>

                <div class="form-group">
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <span class="input-icon"><i class="fa-solid fa-lock"></i></span>
                    <button type="button" class="toggle-pw" onclick="togglePassword()" tabindex="-1" aria-label="Toggle password visibility">
                        <i class="fa-regular fa-eye"></i>
                    </button>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i> Sign In
                </button>
            </form>

            <div class="login-footer">
                <a href="#">Forgot password?</a>
                <span class="divider">|</span>
                <a href="../">Back to Website</a>
            </div>

            <div class="brand-bottom">
                &copy; <?= date('Y') ?> <a href="../"><?= htmlspecialchars($site_name ?? 'Khodiyar Steel Industries') ?></a>
            </div>
        </div>
    </div>

    <script>
    function togglePassword() {
        const pw = document.getElementById('password');
        const icon = document.querySelector('.toggle-pw i');
        if (pw.type === 'password') {
            pw.type = 'text';
            icon.className = 'fa-regular fa-eye-slash';
        } else {
            pw.type = 'password';
            icon.className = 'fa-regular fa-eye';
        }
    }
    </script>
</body>
</html>
