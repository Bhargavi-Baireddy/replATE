<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FoodShare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .glass { background: rgba(255,255,255,0.1); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.2); }
        .purple-gradient { background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 50%, #c084fc 100%); }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        .shake { animation: shake 0.5s ease-in-out; }
        @keyframes shake { 0%, 100% { transform: translateX(0); } 25% { transform: translateX(-5px); } 75% { transform: translateX(5px); } }
    </style>
</head>
<body class="purple-gradient min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md glass rounded-3xl p-10 shadow-2xl">
        <div class="text-center mb-10">
            <div class="w-24 h-24 bg-white/20 rounded-3xl flex items-center justify-center mx-auto mb-6 floating">
                <i class="fas fa-sign-in-alt text-3xl"></i>
            </div>
            <h1 class="text-4xl font-bold mb-2">Welcome Back</h1>
            <p class="opacity-90">Sign in to continue rescuing food</p>
        </div>

        <?php
        session_start();
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            
$conn = new mysqli('localhost:3305', 'root', '', 'foodshare_db');

            $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");


            $stmt->bind_param("s", $email);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                header("Location: ../../dashboard/" . $user['role'] . ".php");
                exit;
            } else {
                $error = '<div class="glass p-4 rounded-2xl mb-6 text-red-400 text-center shake flex items-center justify-center gap-2">
                    <i class="fas fa-exclamation-triangle"></i> Invalid credentials
                </div>';
            }
        }
        echo $error;
        ?>

        <form method="POST">
            <div class="mb-8">
                <label class="block text-white/90 font-semibold mb-4">Email Address</label>
                <div class="relative">
                    <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-white/50"></i>
                    <input type="email" name="email" required 
                           class="w-full bg-white/10 border border-white/30 rounded-2xl pl-12 pr-4 py-4 text-white placeholder-white/60 focus:outline-none focus:border-white/50 focus:ring-4 focus:ring-purple-500/30 transition-all text-lg" 
                           placeholder="your@email.com">
                </div>
            </div>
            
            <div class="mb-10">
                <label class="block text-white/90 font-semibold mb-4">Password</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-white/50"></i>
                    <input type="password" name="password" required 
                           class="w-full bg-white/10 border border-white/30 rounded-2xl pl-12 pr-4 py-4 text-white placeholder-white/60 focus:outline-none focus:border-white/50 focus:ring-4 focus:ring-purple-500/30 transition-all text-lg" 
                           placeholder="••••••••">
                </div>
            </div>
            
            <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-500 hover:to-purple-600 text-lg font-bold py-5 rounded-2xl shadow-2xl hover:shadow-purple-500/50 hover:-translate-y-1 transition-all">
                <i class="fas fa-arrow-right mr-3"></i>Sign In Securely
            </button>
        </form>

        <div class="text-center mt-10 space-y-3">
            <p class="opacity-90">Don't have an account? <a href="register.php" class="font-bold hover:underline">Create one now</a></p>
            <div class="text-xs opacity-70 pt-6 border-t border-white/20">
                <a href="#" class="hover:opacity-80">Forgot Password?</a>
            </div>
        </div>

        <!-- Demo Quick Login -->
        <div class="mt-12 p-6 glass rounded-2xl">
            <p class="text-center font-semibold mb-4 opacity-90">🔥 Quick Demo Login</p>
            <div class="grid grid-cols-2 gap-3 text-sm">
                <button onclick="quickLogin('donor')" class="glass p-4 rounded-xl hover:bg-white/20 transition flex items-center gap-2">
                    <i class="fas fa-utensils text-yellow-400"></i> Donor
                </button>
                <button onclick="quickLogin('ngo')" class="glass p-4 rounded-xl hover:bg-white/20 transition flex items-center gap-2">
                    <i class="fas fa-heart text-green-400"></i> NGO
                </button>
                <button onclick="quickLogin('volunteer')" class="glass p-4 rounded-xl hover:bg-white/20 transition flex items-center gap-2">
                    <i class="fas fa-truck text-blue-400"></i> Volunteer
                </button>
                <button onclick="quickLogin('admin')" class="glass p-4 rounded-xl hover:bg-white/20 transition flex items-center gap-2">
                    <i class="fas fa-shield-alt text-purple-400"></i> Admin
                </button>
            </div>
            <p class="text-xs opacity-70 mt-3 text-center">Email: demo@test.com | Password: demo123</p>
        </div>
    </div>

    <script>
        function quickLogin(role) {
            document.querySelector('input[name="email"]').value = 'demo@test.com';
            document.querySelector('input[name="password"]').value = 'demo123';
            // Auto submit after 1s
            setTimeout(() => document.querySelector('form').submit(), 1000);
        }

        // Focus animations
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', () => {
                input.parentElement.parentElement.style.transform = 'scale(1.02)';
            });
            input.addEventListener('blur', () => {
                input.parentElement.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>

