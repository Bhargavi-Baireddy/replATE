<?php
require_once '../includes/functions.php';

if (!$functions->isLoggedIn()) {
    header('Location: ../pages/auth/login.php?role=admin');
    exit;
}

$user = $functions->getCurrentUser();
if ($user['role'] !== 'admin') {
    header('Location: ../pages/auth/login.php');
    exit;
}

// Stats query
$stats = [
    'total_users' => $functions->db->query("SELECT COUNT(*) FROM users")->fetchColumn(),
    'total_donations' => $functions->db->query("SELECT COUNT(*) FROM food_donations")->fetchColumn(),
    'active_ngos' => $functions->db->query("SELECT COUNT(*) FROM users WHERE role='ngo'")->fetchColumn(),
    'active_volunteers' => $functions->db->query("SELECT COUNT(*) FROM users WHERE role='volunteer'")->fetchColumn(),
    'today_claims' => $functions->db->query("SELECT COUNT(*) FROM claims WHERE DATE(created_at) = CURDATE()")->fetchColumn(),
];

$recent_users = $functions->db->query("SELECT name, email, role, created_at FROM users ORDER BY created_at DESC LIMIT 10")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - FoodShare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .glass { background: rgba(255,255,255,0.1); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.2); }
        .gradient-bg { background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%); }
    </style>
</head>
<body class="min-h-screen gradient-bg">
    <!-- Sidebar -->
    <aside class="glass w-64 fixed h-full p-6 shadow-2xl z-40 lg:translate-x-0">
        <div class="text-2xl font-bold text-white mb-12">
            <i class="fas fa-user-shield mr-3 text-purple-400"></i>Admin Panel
        </div>
        <nav class="space-y-4">
            <a href="#stats" class="flex items-center space-x-3 text-white/90 py-3 px-4 rounded-xl hover:bg-white/20 transition font-semibold">
                <i class="fas fa-chart-bar w-5"></i><span>Dashboard</span>
            </a>
            <a href="#users" class="flex items-center space-x-3 text-white/70 py-3 px-4 rounded-xl hover:bg-white/20 transition">
                <i class="fas fa-users w-5"></i><span>Users</span>
            </a>
            <a href="#donations" class="flex items-center space-x-3 text-white/70 py-3 px-4 rounded-xl hover:bg-white/20 transition">
                <i class="fas fa-utensils w-5"></i><span>Donations</span>
            </a>
            <a href="#analytics" class="flex items-center space-x-3 text-white/70 py-3 px-4 rounded-xl hover:bg-white/20 transition">
                <i class="fas fa-chart-line w-5"></i><span>Analytics</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="lg:ml-64 p-8">
        <header class="glass p-6 rounded-3xl mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-white">Admin Dashboard</h1>
                <p class="text-white/70">Welcome back, Super Admin</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="glass px-4 py-2 rounded-xl text-white cursor-pointer relative">
                    <i class="fas fa-bell"></i>
                    <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 rounded-full flex items-center justify-center text-xs font-bold">4</span>
                </div>
                <div class="w-12 h-12 bg-white/30 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-user text-white"></i>
                </div>
            </div>
        </header>

        <!-- Stats Grid -->
        <div class="grid lg:grid-cols-4 md:grid-cols-2 gap-8 mb-12" id="stats">
            <div class="glass p-8 rounded-3xl text-center hover:shadow-2xl transition-all">
                <div class="text-4xl font-bold bg-gradient-to-r from-blue-400 to-blue-600 bg-clip-text text-transparent mb-3"><?php echo $stats['total_users']; ?></div>
                <div class="text-white/90 text-lg font-semibold">Total Users</div>
                <div class="w-full bg-white/20 rounded-full h-2 mt-3">
                    <div class="bg-blue-400 h-2 rounded-full" style="width: 75%"></div>
                </div>
            </div>
            <div class="glass p-8 rounded-3xl text-center hover:shadow-2xl transition-all">
                <div class="text-4xl font-bold bg-gradient-to-r from-emerald-400 to-emerald-600 bg-clip-text text-transparent mb-3"><?php echo $stats['total_donations']; ?></div>
                <div class="text-white/90 text-lg font-semibold">Food Donations</div>
            </div>
            <div class="glass p-8 rounded-3xl text-center hover:shadow-2xl transition-all">
                <div class="text-4xl font-bold bg-gradient-to-r from-purple-400 to-purple-600 bg-clip-text text-transparent mb-3"><?php echo $stats['today_claims']; ?></div>
                <div class="text-white/90 text-lg font-semibold">Claims Today</div>
            </div>
            <div class="glass p-8 rounded-3xl text-center hover:shadow-2xl transition-all">
                <div class="text-4xl font-bold bg-gradient-to-r from-orange-400 to-orange-600 bg-clip-text text-transparent mb-3">
                    <?php echo $stats['active_ngos']; ?> / <?php echo $stats['active_volunteers']; ?>
                </div>
                <div class="text-white/90 text-lg font-semibold">NGOs / Volunteers</div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid lg:grid-cols-2 gap-8 mb-12" id="analytics">
            <div class="glass p-8 rounded-3xl">
                <h3 class="text-2xl font-bold text-white mb-6">Donations Over Time</h3>
                <canvas id="donationsChart" height="100"></canvas>
            </div>
            <div class="glass p-8 rounded-3xl">
                <h3 class="text-2xl font-bold text-white mb-6">User Growth</h3>
                <canvas id="usersChart" height="100"></canvas>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="grid lg:grid-cols-2 gap-8" id="users">
            <div class="glass p-8 rounded-3xl">
                <h3 class="text-2xl font-bold text-white mb-6">Recent Users</h3>
                <div class="space-y-4 max-h-96 overflow-y-auto">
                    <?php foreach ($recent_users as $u): ?>
                    <div class="flex items-center space-x-4 p-4 hover:bg-white/10 rounded-2xl transition">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-pink-500 rounded-2xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-user text-white text-xl"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-bold text-white text-lg"><?php echo htmlspecialchars($u['name']); ?></div>
                            <div class="text-white/70 truncate"><?php echo htmlspecialchars($u['email']); ?></div>
                        </div>
                        <span class="px-3 py-1 bg-white/20 text-white text-xs font-bold rounded-full">
                            <?php echo ucfirst($u['role']); ?>
                        </span>
                        <div class="text-right">
                            <div class="text-xs text-white/60"><?php echo date('H:i', strtotime($u['created_at'])); ?></div>
                            <div class="text-xs text-white/50"><?php echo date('M j', strtotime($u['created_at'])); ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="glass p-8 rounded-3xl">
                <h3 class="text-2xl font-bold text-white mb-6">Recent Donations</h3>
                <div class="space-y-4">
                    <!-- Demo data - connect to real donations table -->
                    <div class="flex items-center justify-between p-4 hover:bg-white/10 rounded-2xl transition">
                        <div>
                            <div class="font-bold text-white">Chicken Biryani</div>
                            <div class="text-sm text-white/70">Restaurant ABC • 15kg</div>
                        </div>
                        <div class="text-right">
                            <span class="px-2 py-1 bg-green-500/20 text-green-400 text-xs font-bold rounded-full">Available</span>
                        </div>
                    </div>
                    <!-- More demo entries -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // Charts
        new Chart(document.getElementById('donationsChart'), {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Donations',
                    data: [65, 59, 80, 81, 56, <?php echo $stats['total_donations']; ?>],
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.2)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.1)' } }, x: { grid: { color: 'rgba(255,255,255,0.1)' } } },
                elements: { point: { hoverRadius: 8 } }
            }
        });

        new Chart(document.getElementById('usersChart'), {
            type: 'bar',
            data: {
                labels: ['Donors', 'NGOs', 'Volunteers', 'Admins'],
                datasets: [{
                    data: [120, <?php echo $stats['active_ngos']; ?>, <?php echo $stats['active_volunteers']; ?>, 1],
                    backgroundColor: ['#f59e0b', '#10b981', '#3b82f6', '#8b5cf6']
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.1)' } }, x: { grid: { display: false } } }
            }
        });
    </script>
</body>
</html>

