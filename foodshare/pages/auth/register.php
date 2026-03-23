
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - FoodShare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .glass { background: rgba(255,255,255,0.1); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.2); }
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .shake { animation: shake 0.5s ease-in-out; }
        @keyframes shake { 0%, 100% { transform: translateX(0); } 25% { transform: translateX(-5px); } 75% { transform: translateX(5px); } }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-6" style="animation: float 3s ease-in-out infinite;">
                <i class="fas fa-user-plus text-3xl text-white"></i>
            </div>
            <h1 class="text-4xl font-bold text-white mb-4">Create Account</h1>
            <p class="text-white/80">Join FoodShare and start making impact</p>
        </div>

        <?php
        require_once '../../includes/functions.php';
        $success = '';
        $error = '';

        if ($_POST) {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $role = $_POST['role'];
            $phone = trim($_POST['phone']);
            $address = trim($_POST['address']);

            // Validation
            if (empty($name) || empty($email) || empty($password) || empty($role)) {
                $error = '<div class="glass p-4 rounded-2xl mb-6 text-red-400 text-center shake"><i class="fas fa-exclamation-triangle mr-2"></i>Please fill all required fields</div>';
            } elseif (strlen($password) < 6) {
                $error = '<div class="glass p-4 rounded-2xl mb-6 text-red-400 text-center shake"><i class="fas fa-exclamation-triangle mr-2"></i>Password must be at least 6 characters</div>';
            } else {
                // Check email exists
$stmt = $functions->getDb()->prepare("SELECT id FROM users WHERE email = ?");
                $stmt->execute([$email]);
                if ($stmt->fetch()) {
                    $error = '<div class="glass p-4 rounded-2xl mb-6 text-red-400 text-center shake"><i class="fas fa-exclamation-triangle mr-2"></i>Email already registered</div>';
                } else {
                    // Insert user
                    $hashed_password = $functions->hashPassword($password);
                    $stmt = $functions->db->prepare("
                        INSERT INTO users (name, email, password, role, phone, address) 
                        VALUES (?, ?, ?, ?, ?, ?)
                    ");
                    if ($stmt->execute([$name, $email, $hashed_password, $role, $phone, $address])) {
$user_id = $functions->getDb()->lastInsertId();
                        $_SESSION['user_id'] = $user_id;
                        $success = '<div class="glass p-4 rounded-2xl mb-6 text-green-400 text-center"><i class="fas fa-check-circle mr-2"></i>Welcome to FoodShare! Redirecting...</div>
                        <script> setTimeout(() => window.location.href = "../dashboard/' . $role . '.php", 1500); </script>';
                    } else {
                        $error = '<div class="glass p-4 rounded-2xl mb-6 text-red-400 text-center shake"><i class="fas fa-exclamation-triangle mr-2"></i>Registration failed. Try again.</div>';
                    }
                }
            }
        }
        echo $success . $error;
        ?>

        <form method="POST" class="glass p-8 rounded-3xl space-y-6">
            <div>
                <label class="block text-white/90 mb-3 font-semibold">Full Name *</label>
                <div class="relative">
                    <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-white/50"></i>
                    <input type="text" name="name" value="<?php echo $_POST['name'] ?? ''; ?>" required class="w-full bg-white/10 border border-white/30 rounded-xl pl-12 pr-4 py-3 text-white placeholder-white/60 focus:outline-none focus:border-white/50 transition">
                </div>
            </div>

            <div>
                <label class="block text-white/90 mb-3 font-semibold">Email Address *</label>
                <div class="relative">
                    <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-white/50"></i>
                    <input type="email" name="email" value="<?php echo $_POST['email'] ?? ''; ?>" required class="w-full bg-white/10 border border-white/30 rounded-xl pl-12 pr-4 py-3 text-white placeholder-white/60 focus:outline-none focus:border-white/50 transition">
                </div>
            </div>

            <div>
                <label class="block text-white/90 mb-3 font-semibold">Phone</label>
                <div class="relative">
                    <i class="fas fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-white/50"></i>
                    <input type="tel" name="phone" value="<?php echo $_POST['phone'] ?? ''; ?>" class="w-full bg-white/10 border border-white/30 rounded-xl pl-12 pr-4 py-3 text-white placeholder-white/60 focus:outline-none focus:border-white/50 transition" placeholder="Optional">
                </div>
            </div>

            <div>
                <label class="block text-white/90 mb-3 font-semibold">Address / Location *</label>
                <div class="relative">
                    <i class="fas fa-map-marker-alt absolute left-4 top-1/2 -translate-y-1/2 text-white/50"></i>
                    <textarea name="address" required rows="2" class="w-full bg-white/10 border border-white/30 rounded-xl pl-12 pr-4 py-3 text-white placeholder-white/60 focus:outline-none focus:border-white/50 transition" placeholder="Enter your full address (Google Maps integration coming soon)"><?php echo $_POST['address'] ?? ''; ?></textarea>
                </div>
            </div>

            <div>
                <label class="block text-white/90 mb-3 font-semibold">Password *</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-white/50"></i>
                    <input type="password" name="password" required class="w-full bg-white/10 border border-white/30 rounded-xl pl-12 pr-4 py-3 text-white placeholder-white/60 focus:outline-none focus:border-white/50 transition" placeholder="Minimum 6 characters">
                </div>
            </div>

            <div>
                <label class="block text-white/90 mb-3 font-semibold">I am a...</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="glass py-3 px-4 rounded-xl cursor-pointer hover:bg-white/20 transition flex items-center space-x-3">
                        <input type="radio" name="role" value="donor" <?php echo ($_POST['role'] ?? '') == 'donor' ? 'checked' : ''; ?> class="hidden">
                        <i class="fas fa-utensils text-yellow-400 text-xl"></i>
                        <span class="text-white font-medium">Restaurant / Donor</span>
                    </label>
                    <label class="glass py-3 px-4 rounded-xl cursor-pointer hover:bg-white/20 transition flex items-center space-x-3">
                        <input type="radio" name="role" value="ngo" <?php echo ($_POST['role'] ?? '') == 'ngo' ? 'checked' : ''; ?> class="hidden">
                        <i class="fas fa-heart text-green-400 text-xl"></i>
                        <span class="text-white font-medium">NGO</span>
                    </label>
                    <label class="glass py-3 px-4 rounded-xl cursor-pointer hover:bg-white/20 transition flex items-center space-x-3">
                        <input type="radio" name="role" value="volunteer" <?php echo ($_POST['role'] ?? '') == 'volunteer' ? 'checked' : ''; ?> class="hidden">
                        <i class="fas fa-truck text-blue-400 text-xl"></i>
                        <span class="text-white font-medium">Volunteer</span>
                    </label>
                </div>
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-green-400 to-blue-500 text-gray-900 py-4 rounded-xl font-bold text-lg hover:from-green-300 hover:to-blue-400 transition transform hover:scale-[1.02] hover:shadow-2xl">
                <i class="fas fa-user-plus mr-2"></i>Create Account
            </button>
        </form>

        <div class="text-center mt-8">
            <p class="text-white/70">Already have an account? <a href="login.php" class="text-yellow-400 font-semibold hover:text-yellow-300 transition">Sign in here</a></p>
        </div>
    </div>

    <script>
        // Radio button styling
        document.querySelectorAll('input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.querySelectorAll('label[for]').forEach(label => {
                    label.classList.remove('ring-2', 'ring-blue-400');
                });
                this.parentElement.classList.add('ring-2', 'ring-blue-400');
            });
        });

        // Input focus animations
        document.querySelectorAll('input, textarea').forEach(input => {
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

