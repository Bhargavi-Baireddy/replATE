<?php
require_once '../includes/functions.php';

if (!$functions->isLoggedIn()) {
    header("Location: /foodshare/pages/login.php");
    exit();
}

$user = $functions->getCurrentUser();

// Demo location - replace with real user location
$lat = 17.3850; // Hyderabad
$lng = 78.4867;
$donations = $functions->getNearbyDonations($lat, $lng);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGO Dashboard - FoodShare</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="gradient-bg min-h-screen">
    <!-- Top Navbar -->
    <nav class="glass shadow-2xl py-4 px-6 sticky top-0 z-50">
        <div class="container mx-auto flex items-center justify-between">
            <a href="../index.php" class="text-2xl font-bold text-white flex items-center">
                <i class="fas fa-heart mr-3 text-pink-400"></i>
                FoodShare NGO
            </a>
            <div class="flex items-center space-x-6">
                <div class="glass p-3 rounded-full relative cursor-pointer notification-bell">
                    <i class="fas fa-bell text-xl text-white"></i>
                    <span class="notification-badge bg-red-500">3</span>
                    <div class="notification-dropdown glass absolute right-0 mt-2 w-80 p-4 rounded-2xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 hidden">
                        <h4 class="font-bold text-white mb-3">Notifications</h4>
                        <div class="space-y-3 max-h-60 overflow-y-auto">
                            <div class="glass p-3 rounded-xl">
                                <p class="text-white text-sm">New donation available nearby</p>
                                <span class="text-xs text-white/60">2 min ago</span>
                            </div>
                            <div class="glass p-3 rounded-xl">
                                <p class="text-white text-sm">Donation claimed successfully</p>
                                <span class="text-xs text-white/60">1 hour ago</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-12 h-12 glass rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-white"></i>
                </div>
                <a href="../backend/api/logout.php" class="glass px-6 py-2 rounded-xl text-white font-semibold hover:bg-white/20 transition-all">
                    Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-8">
        <!-- Welcome & Stats -->
        <div class="glass p-8 rounded-3xl mb-12">
            <div class="flex flex-col lg:flex-row gap-8 items-start lg:items-center">
                <div>
                    <h1 class="text-4xl font-bold text-white mb-3">Welcome back, <span class="text-yellow-300"><?= htmlspecialchars($user['name']) ?></span> 👋</h1>
                    <p class="text-xl text-white/80">Find surplus food nearby and make an impact today</p>
                </div>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 ml-auto">
                    <div class="glass p-4 rounded-2xl text-center">
                        <div class="text-2xl font-bold text-green-400"><?= count($donations) ?></div>
                        <div class="text-white/80 text-sm">Available</div>
                    </div>
                    <div class="glass p-4 rounded-2xl text-center">
                        <div class="text-2xl font-bold text-yellow-400">0</div>
                        <div class="text-white/80 text-sm">My Claims</div>
                    </div>
                    <div class="glass p-4 rounded-2xl text-center">
                        <div class="text-2xl font-bold text-blue-400">5km</div>
                        <div class="text-white/80 text-sm">Radius</div>
                    </div>
                    <div class="glass p-4 rounded-2xl text-center">
                        <div class="text-2xl font-bold text-purple-400">3</div>
                        <div class="text-white/80 text-sm">Alerts</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="glass p-8 rounded-3xl mb-12">
            <div class="flex flex-wrap gap-4 items-center">
                <div class="relative flex-1 min-w-[280px]">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-white/50"></i>
                    <input type="text" id="search" placeholder="Search biryani, rice, vegetables..." class="w-full pl-12 pr-6 py-4 glass rounded-2xl text-white placeholder-white/60 focus:outline-none focus:ring-4 ring-blue-400/30">
                </div>
                <select id="radius" class="glass px-6 py-4 rounded-2xl text-white">
                    <option>5km</option>
                    <option>10km</option>
                    <option>20km</option>
                </select>
                <select id="sort" class="glass px-6 py-4 rounded-2xl text-white">
                    <option>Nearest</option>
                    <option>Expiring Soon</option>
                    <option>Largest Quantity</option>
                </select>
                <button onclick="applyFilters()" class="btn-primary px-8 py-4 rounded-2xl font-bold">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
            </div>
        </div>

        <!-- Donations Grid -->
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Food Cards Column -->
            <div class="lg:col-span-2 space-y-8">
                <h2 class="text-4xl font-bold text-white flex items-center mb-8">
                    <i class="fas fa-utensils mr-4 text-yellow-400"></i>
                    Surplus Food Available
                </h2>
                
                <?php if (empty($donations)): ?>
                    <div class="glass p-20 rounded-3xl text-center">
                        <i class="fas fa-search-location text-7xl text-white/30 mb-8"></i>
                        <h3 class="text-3xl font-bold text-white mb-4">No donations nearby</h3>
                        <p class="text-xl text-white/70 mb-8">Try expanding your search radius</p>
                        <button onclick="expandRadius()" class="btn-primary px-12 py-4 rounded-2xl font-bold text-xl">
                            Expand Search
                        </button>
                    </div>
                <?php else: ?>
                    <?php foreach ($donations as $index => $donation): ?>
                    <div class="food-card glass p-8 rounded-3xl cursor-pointer group hover:border-yellow-400 border-2 border-white/20 hover:shadow-2xl transition-all duration-500 fade-in" data-index="<?= $index ?>">
                        <div class="relative overflow-hidden rounded-3xl mb-6">
                            <img src="<?= htmlspecialchars($donation['image'] ?? 'https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?w=500&h=300') ?>" alt="<?= htmlspecialchars($donation['title']) ?>" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute top-4 right-4 glass px-4 py-2 rounded-full text-xs font-bold shadow-lg">
                                <?= $functions->timeRemaining($donation['expiry_time']) ?>
                            </div>
                            <div class="absolute bottom-4 left-4 right-4 glass p-4 rounded-xl opacity-0 group-hover:opacity-100 transition-all duration-300">
                                <p class="text-white text-sm"><?= htmlspecialchars(substr($donation['description'], 0, 100)) ?>...</p>
                            </div>
                        </div>
                        
                        <div>
                            <div class="flex items-start justify-between mb-4">
                                <h3 class="text-2xl font-bold text-white group-hover:text-yellow-400 transition-all duration-300 line-clamp-2 flex-1 pr-4">
                                    <?= htmlspecialchars($donation['title']) ?>
                                </h3>
                                <div class="glass px-4 py-2 rounded-full">
                                    <span class="font-bold text-green-400"><?= htmlspecialchars($donation['distance']) ?>km</span>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
                                <div class="flex items-center text-green-400">
                                    <i class="fas fa-weight-hanging mr-2"></i>
                                    <?= htmlspecialchars($donation['quantity']) ?>
                                </div>
                                <div class="flex items-center text-blue-400">
                                    <i class="fas fa-user mr-2"></i>
                                    <?= htmlspecialchars($donation['donor_name']) ?>
                                </div>
                            </div>
                            
                            <form method="POST" action="/foodshare/backend/api/claim.php" class="mt-6">
                                <input type="hidden" name="donation_id" value="<?= $donation['id'] ?>">
                                <button type="submit" class="btn-primary w-full py-4 px-8 rounded-2xl font-bold text-lg shadow-xl hover:shadow-2xl transition-all duration-300">
                                    <i class="fas fa-hand-pointer mr-3"></i>Claim This Donation
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Quick Stats & Map Placeholder -->
            <div class="space-y-8">
                <div class="glass p-8 rounded-3xl sticky top-32">
                    <h3 class="text-2xl font-bold text-white mb-6 flex items-center">
                        <i class="fas fa-map mr-3 text-blue-400"></i>Search Area
                    </h3>
                    <div class="bg-gradient-to-br from-gray-800 to-gray-900 p-8 rounded-2xl text-center text-white/70 min-h-[300px] flex items-center justify-center">
                        <div>
                            <i class="fas fa-map-marked-alt text-6xl mb-4 opacity-50"></i>
                            <p class="text-lg mb-2">Map Coming Soon</p>
                            <p class="text-sm">Google Maps integration</p>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="glass p-8 rounded-3xl">
                    <h3 class="text-2xl font-bold text-white mb-6">Quick Actions</h3>
                    <div class="space-y-4">
                        <a href="#" class="glass p-6 rounded-2xl block text-center hover:bg-white/20 transition-all flex items-center space-x-4">
                            <i class="fas fa-plus-circle text-green-400 text-2xl"></i>
                            <span class="font-semibold text-white">Create Claim Report</span>
                        </a>
                        <a href="#" class="glass p-6 rounded-2xl block text-center hover:bg-white/20 transition-all flex items-center space-x-4">
                            <i class="fas fa-chart-line text-blue-400 text-2xl"></i>
                            <span class="font-semibold text-white">View Analytics</span>
                        </a>
                        <a href="#" class="glass p-6 rounded-2xl block text-center hover:bg-white/20 transition-all flex items-center space-x-4">
                            <i class="fas fa-users text-purple-400 text-2xl"></i>
                            <span class="font-semibold text-white">Manage Team</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/main.js"></script>
    <script>
        function applyFilters() {
            // Filter logic
            console.log('Applying filters...');
        }

        function expandRadius() {
            document.getElementById('radius').value = '20km';
            applyFilters();
        }

        // Search functionality
        document.getElementById('search').addEventListener('input', function() {
            const term = this.value.toLowerCase();
            document.querySelectorAll('.food-card').forEach(card => {
                const title = card.querySelector('h3').textContent.toLowerCase();
                card.style.display = title.includes(term) || term === '' ? 'block' : 'none';
            });
        });

        // Claim confirmation
        document.querySelectorAll('form[action*="/claim.php"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('Claim this donation? You will be notified when donor responds.')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>
