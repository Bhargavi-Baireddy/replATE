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
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .shake { animation: shake 0.5s ease-in-out; }
        @keyframes shake { 0%, 100% { transform: translateX(0); } 25% { transform: translateX(-5px); } 75% { transform: translateX(5px); } }
        .float { animation: float 3s ease-in-out infinite; }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-6 float">
                <i class="fas fa-sign-in-alt text-3xl text-white"></i>
            </div>
            <h1 class="text-4xl font-bold text-white mb-4">Welcome Back</h1>
            <p class="text-white/80">Sign in to your FoodShare account</p>
        </div>

        <?php
        require_once '../../includes/functions.php';
        $error = '';
        
        if ($_POST) {
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            
$stmt = $functions->getDb()->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            
            if ($user && $functions->verifyPassword($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $redirect = isset($_GET['role']) ? '../../dashboard/' . $_GET['role'] . '.php' : '../../dashboard/' . $user['role'] . '.php';
                header("Location: " . $redirect);
                exit;
            } else {
                $error = '<div class="glass p-4 rounded-2xl mb-6 text-red-400 text-center shake"><i class="fas fa-exclamation-triangle mr-2"></i>Invalid email or password</div>';
            }
        }
        echo $error;
        ?>

        <form method="POST" class="glass p-8 rounded-3xl space-y-6">
            <div>
                <label class="block text-white/90 mb-3 font-semibold">Email Address</label>
                <div class="relative">
                    <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-white/50"></i>
                    <input type="email" name="email" required class="w-full bg-white/10 border border-white/30 rounded-xl pl-12 pr-4 py-3 text-white placeholder-white/60 focus:outline-none focus:border-white/50 transition" placeholder="Enter your email">
                </div>
            </div>
            
            <div>
                <label class="block text-white/90 mb-3 font-semibold">Password</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-white/50"></i>
                    <input type="password" name="password" required class="w-full bg-white/10 border border-white/30 rounded-xl pl-12 pr-4 py-3 text-white placeholder-white/60 focus:outline-none focus:border-white/50 transition" placeholder="Enter your password">
                </div>
            </div>
            
            <button type="submit" class="w-full bg-gradient-to-r from-yellow-400 to-orange-500 text-gray-900 py-4 rounded-xl font-bold text-lg hover:from-yellow-300 hover:to-orange-400 transition transform hover:scale-[1.02] hover:shadow-2xl">
                <i class="fas fa-sign-in-alt mr-2"></i>Sign In
            </button>
        </form>

        <div class="text-center mt-8 space-y-4">
            <p class="text-white/70">Don't have an account? <a href="register.php" class="text-yellow-400 font-semibold hover:text-yellow-300 transition">Sign up here</a></p>
            <div class="text-xs text-white/50">
                <a href="#" class="hover:text-white/70 transition">Forgot Password?</a>
            </div>
        </div>

        <!-- Role selection demo -->
        <div class="mt-12 p-6 glass rounded-2xl">
            <p class="text-white text-center mb-4 font-semibold">Quick Login (Demo)</p>
            <div class="grid grid-cols-2 gap-3 text-sm">
                <a href="?role=donor" class="glass py-3 px-4 rounded-xl text-center hover:bg-white/20 transition">
                    <i class="fas fa-utensils text-yellow-400 mb-1 block"></i>Donor
                </a>
                <a href="?role=ngo" class="glass py-3 px-4 rounded-xl text-center hover:bg-white/20 transition">
                    <i class="fas fa-heart text-green-400 mb-1 block"></i>NGO
                </a>
                <a href="?role=volunteer" class="glass py-3 px-4 rounded-xl text-center hover:bg-white/20 transition">
                    <i class="fas fa-truck text-blue-400 mb-1 block"></i>Volunteer
                </a>
                <a href="?role=admin" class="glass py-3 px-4 rounded-xl text-center hover:bg-white/20 transition">
                    <i class="fas fa-user-shield text-purple-400 mb-1 block"></i>Admin
                </a>
            </div>
            <p class="text-xs text-white/60 mt-3 text-center">Email: test@demo.com | Password: password</p>
        </div>
    </div>

    <script>
        // Form animations
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.parentElement.style.transform = 'scale(1.02)';
            });
            input.addEventListener('blur', function() {
                this.parentElement.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>

