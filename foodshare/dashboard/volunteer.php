<?php
require_once '../includes/functions.php';

if (!$functions->isLoggedIn()) {
    header('Location: ../pages/auth/login.php?role=volunteer');
    exit;
}

$user = $functions->getCurrentUser();
if ($user['role'] !== 'volunteer') {
    header('Location: ../pages/auth/login.php');
    exit;
}

// Fetch available claims/pickups
$stmt = $functions->db->prepare("
    SELECT c.*, fd.title, fd.quantity, fd.location_lat, fd.location_lng, fd.address, u.name as ngo_name
    FROM claims c
    JOIN food_donations fd ON c.donation_id = fd.id
    JOIN users u ON c.ngo_id = u.id
    WHERE c.status IN ('pending', 'accepted') AND (c.volunteer_id IS NULL OR c.volunteer_id = ?)
    ORDER BY c.created_at DESC
    LIMIT 10
");
$stmt->execute([$user['id']]);
$pickups = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Dashboard - FoodShare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .glass { background: rgba(255,255,255,0.1); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.2); }
        .gradient-bg { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); }
    </style>
</head>
<body class="min-h-screen gradient-bg">
    <header class="glass shadow-2xl sticky top-0 z-50 px-6 py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="../index.php" class="text-2xl font-bold text-white">
                <i class="fas fa-truck mr-2 text-blue-400"></i>FoodShare Volunteer
            </a>
            <div class="flex items-center space-x-4">
                <div class="glass px-4 py-2 rounded-full text-white cursor-pointer relative">
                    <i class="fas fa-bell"></i>
                    <span class="absolute -top-1 -right-1 bg-orange-500 text-xs rounded-full h-5 w-5 flex items-center justify-center">1</span>
                </div>
                <span class="text-white font-semibold"><?php echo htmlspecialchars($user['name']); ?></span>
                <a href="../pages/auth/login.php?logout=1" class="text-white hover:text-white/80 px-4 py-2 rounded-xl hover:bg-white/10 transition">Logout</a>
            </div>
        </div>
    </header>

    <div class="max-w-6xl mx-auto p-8">
        <h1 class="text-4xl font-bold text-white mb-12">Pickup Requests</h1>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if (empty($pickups)): ?>
                <div class="col-span-full glass p-20 rounded-3xl text-center">
                    <i class="fas fa-road text-7xl text-white/30 mb-8"></i>
                    <h2 class="text-2xl font-bold text-white mb-4">No active pickups</h2>
                    <p class="text-white/70 mb-8">NGOs will assign you when they claim food donations</p>
                </div>
            <?php else: ?>
                <?php foreach ($pickups as $pickup): ?>
                <div class="glass p-6 rounded-3xl hover:shadow-2xl transition-all">
                    <div class="flex items-start space-x-4 mb-4">
                        <div class="w-16 h-16 bg-green-500/20 rounded-2xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-utensils text-2xl text-green-400"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-xl text-white mb-1 line-clamp-1"><?php echo htmlspecialchars($pickup['title']); ?></h3>
                            <div class="flex items-center text-yellow-400 mb-1">
                                <i class="fas fa-handshake mr-2"></i>
                                <?php echo htmlspecialchars($pickup['ngo_name']); ?>
                            </div>
                            <div class="text-sm text-white/70 mb-2"><?php echo htmlspecialchars($pickup['quantity']); ?></div>
                            <span class="px-3 py-1 bg-blue-500/20 text-blue-400 text-xs font-bold rounded-full">
                                <?php echo ucfirst(str_replace('_', ' ', $pickup['status'])); ?>
                            </span>
                        </div>
                    </div>
                    <div class="space-y-2 mb-6">
                        <div class="flex items-center text-green-400 text-sm">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            <span class="truncate"><?php echo htmlspecialchars(substr($pickup['address'], 0, 60)); ?>...</span>
                        </div>
                        <div class="text-xs text-white/60"><?php echo date('M j, H:i', strtotime($pickup['created_at'])); ?></div>
                    </div>
                    <div class="flex space-x-3 pt-4 border-t border-white/20">
                        <button onclick="acceptPickup(<?php echo $pickup['id']; ?>)" class="flex-1 bg-green-500/90 hover:bg-green-500 text-white py-3 px-4 rounded-xl font-bold text-sm transition-all hover:shadow-lg">
                            <i class="fas fa-check mr-1"></i>Accept
                        </button>
                        <button onclick="navigateToPickup(<?php echo $pickup['id']; ?>)" class="flex-1 bg-blue-500/90 hover:bg-blue-500 text-white py-3 px-4 rounded-xl font-bold text-sm transition-all hover:shadow-lg">
                            <i class="fas fa-map mr-1"></i>Navigate
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function acceptPickup(pickupId) {
            if (confirm('Accept this pickup request?')) {
                fetch('../api/tracking.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({
                        action: 'accept_pickup',
                        pickup_id: pickupId
                    })
                }).then(res => res.json()).then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                });
            }
        }

        function navigateToPickup(pickupId) {
            alert('Navigation opening in Google Maps (feature coming soon)');
            // window.open(`https://maps.google.com/?q=${lat},${lng}`);
        }

        // Update status buttons based on current status
        document.addEventListener('DOMContentLoaded', function() {
            // Real-time status updates coming soon
        });
    </script>
</body>
</html>

