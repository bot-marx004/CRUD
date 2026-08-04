<?php
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['user'] = ['username' => $username];
        $_SESSION['success'] = 'Welcome back, admin!';
        header('Location: index.php');
        exit;
    }

    $_SESSION['error'] = 'Invalid username or password.';
}

include 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-5 col-md-7">
        <div class="card-modern login-card animate-in">
            <div class="text-center mb-4">
                <div class="login-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <h3 class="fw-bold mb-2">Welcome Back</h3>
                <p class="text-muted mb-0">Sign in to access your inventory dashboard</p>
            </div>

            <form method="POST" action="login.php">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" name="username" class="form-control input-modern" placeholder="Enter username" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                        <input type="password" name="password" class="form-control input-modern" placeholder="Enter password" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-modern btn-modern-primary w-100">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
            </form>

            <div class="mt-3 text-center small text-muted">
                Demo credentials: <strong>admin / admin123</strong>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
