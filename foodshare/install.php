<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodShare - Install Database</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .purple-gradient { background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 50%, #c084fc 100%); }
        .glass { background: rgba(255,255,255,0.1); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.2); }
        @keyframes checkmark { 0% { transform: scale(0); } 50% { transform: scale(1.2); } 100% { transform: scale(1); } }
    </style>
</head>
<body class="purple-gradient min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-lg glass rounded-3xl p-12 shadow-2xl">
        <div class="text-center mb-12">
            <i class="fas fa-database text-7xl text-white/30 mb-6"></i>
            <h1 class="text-4xl font-bold mb-2">FoodShare Install</h1>
            <p class="opacity-90">One-click database setup</p>
        </div>

        <?php
        $success = false;
        $error = '';
        
        if ($_POST) {
            $sqlFile = 'sql/schema.sql';
            if (file_exists($sqlFile)) {
                $sql = file_get_contents($sqlFile);
                $conn = new mysqli('localhost', 'root', '', 'foodshare_db');
                
                if ($conn->connect_error) {
                    $conn = new mysqli('localhost', 'root', '', '');
                    $conn->query("CREATE DATABASE IF NOT EXISTS foodshare_db");
                    $conn->close();
                    $conn = new mysqli('localhost', 'root', '', 'foodshare_db');
                }
                
                if ($conn->multi_query($sql)) {
                    $success = true;
                    do {
                        if ($result = $conn->store_result()) {
                            $result->free();
                        }
                    } while ($conn->next_result());
                } else {
                    $error = 'Install failed: ' . $conn->error;
                }
                $conn->close();
            } else {
                $error = 'SQL file not found';
            }
        }
        ?>

        <?php if ($success): ?>
        <div class="text-center mb-12">
            <div class="w-32 h-32 glass rounded-full mx-auto mb-8 flex items-center justify-center" style="animation: checkmark 0.8s ease-out;">
                <i class="fas fa-check text-4xl text-green-400"></i>
            </div>
            <h2 class="text-3xl font-bold text-green-400 mb-4">Installation Complete!</h2>
            <p class="opacity-90 mb-8">Database ready with sample data</p>
            <div class="space-y-3">
                <a href="index.php" class="w-full block bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold py-4 px-8 rounded-2xl hover:shadow-green-500/50 transition-all text-center">
                    <i class="fas fa-globe mr-2"></i>Go to FoodShare
                </a>
                <a href="pages/auth/login.php" class="w-full block glass text-white font-bold py-4 px-8 rounded-2xl hover:bg-white/10 transition-all text-center">
                    <i class="fas fa-sign-in-alt mr-2"></i>Demo Login
                </a>
            </div>
            <div class="mt-8 p-4 bg-white/10 rounded-2xl text-xs opacity-80">
                <strong>Demo:</strong> demo@test.com / demo123
            </div>
        </div>
        <?php else: ?>
        <form method="POST" class="space-y-6">
            <div>
                <h3 class="text-2xl font-bold mb-4">Ready to install?</h3>
                <p class="opacity-80 mb-6">This will create foodshare_db + tables + demo users</p>
                <div class="grid grid-cols-2 gap-4 mb-6 p-4 glass rounded-2xl text-sm">
                    <div><i class="fas fa-check text-emerald-400 mr-2"></i>Users table</div>
                    <div><i class="fas fa-check text-emerald-400 mr-2"></i>Donations</div>
                    <div><i class="fas fa-check text-emerald-400 mr-2"></i>Demo data</div>
                    <div><i class="fas fa-check text-emerald-400 mr-2"></i>Indexes optimized</div>
                </div>
            </div>
            <?php if ($error): ?>
            <div class="p-4 rounded-2xl bg-red-500/20 border border-red-500/50 text-red-200">
                <?php echo $error; ?>
            </div>
            <?php endif; ?>
            <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-500 hover:to-purple-600 font-bold py-6 px-8 rounded-2xl text-xl shadow-2xl hover:shadow-purple-500/50 hover:-translate-y-1 transition-all">
                <i class="fas fa-rocket mr-3"></i>Install FoodShare Database
            </button>
        </form>
        <?php endif; ?>
    </div>
</body>
</html>

