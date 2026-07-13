<?php
session_start();
$error = '';
$dataFile = __DIR__ . '/../data.json';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (file_exists($dataFile)) {
        $data = json_decode(file_get_contents($dataFile), true);
        $users = $data['users'] ?? [];
        
        foreach ($users as $user) {
            if ($user['username'] == $username && $user['password'] == $password) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['user'] = $user;
                header('Location: dashboard.php');
                exit;
            }
        }
    }
    $error = 'Username atau password salah!';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Telur Pedia Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { 
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-box {
            background: white;
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .login-box h2 { color: #0f172a; font-weight: 800; }
        .login-box .sub { color: #64748b; font-size: 14px; }
        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            transition: 0.3s;
        }
        .form-input:focus {
            outline: none;
            border-color: #f59e0b;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.15);
        }
        .btn-login {
            background: #f59e0b;
            color: white;
            padding: 12px;
            border-radius: 12px;
            font-weight: 700;
            border: none;
            width: 100%;
            cursor: pointer;
            transition: 0.3s;
            font-size: 16px;
        }
        .btn-login:hover { background: #d97706; transform: translateY(-2px); }
        .error-msg {
            background: #fef2f2;
            color: #dc2626;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 14px;
            margin-bottom: 16px;
        }
        .logo-text { font-size: 24px; font-weight: 800; color: #0f172a; }
        .logo-text span { color: #f59e0b; }
    </style>
</head>
<body>
    <div class="login-box">
        <div class="text-center mb-6">
            <div class="logo-text">🥚 Telur<span>Pedia</span></div>
            <p class="sub mt-2">Admin Panel</p>
        </div>
        
        <?php if ($error): ?>
        <div class="error-msg"><i class="fas fa-exclamation-circle"></i> <?= $error ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Username *</label>
                <input type="text" name="username" class="form-input" placeholder="admin" required />
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Password *</label>
                <input type="password" name="password" class="form-input" placeholder="••••••••" required />
            </div>
            <button type="submit" class="btn-login"><i class="fas fa-sign-in-alt mr-2"></i> Sign in</button>
        </form>
        <p class="text-center text-xs text-gray-400 mt-4">Default: admin / admin123</p>
    </div>
</body>
</html>
