<?php
require_once '../includes/functions.php';

if (!$functions->isLoggedIn()) {
    header('Location: ../pages/auth/login.php?role=ngo');
    exit;
}

$user = $functions->getCurrentUser();
if ($user['role'] !== 'ngo') {
    header('Location: ../pages/auth/login.php');
    exit;
}

// Demo NGO location (Hyderabad, India)
$ngo_lat = $user['location_lat'] ?? 17.3850;
$ngo_lng = $user['location_lng'] ?? 78.4867;
$donations = $functions->getNearbyDonations($ngo_lat, $ngo_lng, 20);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGO Dashboard - FoodShare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .glass { background: rgba(255,255,255,0.1); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.2); }
        .gradient-bg { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
        .food-card { transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); }
        .food-card:hover { transform: translateY(-12px) rotateX(5deg); box-shadow: 0 25px 50px rgba(0,0,0,0.15); }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-green-400 via-blue-500 to-purple-600">
    <!-- Header -->
    <header class="glass shadow-2xl sticky top-0 z-50 px-6 py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="../index.php" class="text-2xl font-bold text-white flex items-center">
                <i class="fas fa-heart mr-3 text-red-400"></i>FoodShare NGO
            </a>
            <div class="flex items-center space-x-4">
                <div class="glass px-4 py-2 rounded-full text-white relative">
                    <i class="fas fa-bell mr-1"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-xs rounded-full h-5 w-5 flex items-center justify-center text-white font-bold">3</span>
                </div>
                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-white"></i>
                </div>
                <a href="../pages/auth/login.php?logout=1" class="text-white hover:text-white/80 transition">Logout</a>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto p-6">
        <!-- Stats Cards -->
        <div class="grid lg:grid-cols-4 md:grid-cols-2 gap-6 mb-10">
            <div class="glass p-6 rounded-3xl text-center">
                <div class="text-3xl font-bold text-green-400 mb-2"><?php echo count(array_filter($donations, fn($d) => strtotime($d['expiry_time']) > time())); ?></div>
                <div class="text-white/90">Available Donations</div>
            </div>
            <div class="glass p-6 rounded-3xl text-center">
                <div class="text-3xl font-bold text-yellow-400 mb-2">0</div>
                <div class="text-white/90">Claimed Today</div>
            </div>
            <div class="glass p-6 rounded-3xl text-center">
                <div class="text-3xl font-bold text-blue-400 mb-2">12.5km</div>
                <div class="text-white/90">Search Radius</div>
            </div>
            <div class="glass p-6 rounded-3xl text-center">
                <div class="text-3xl font-bold text-purple-400 mb-2">5</div>
                <div class="text-white/90">Notifications</div>
            </div>
        </div>

        <!-- Filters & Search -->
        <div class="glass p-6 rounded-3xl mb-8">
            <div class="flex flex-wrap lg:items-center gap-4">
                <div class="flex-1 min-w-[250px]">
                    <div class="relative">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-white/50"></i>
                        <input type="text" id="search" placeholder="Search food items..." class="w-full bg-white/10 border border-white/30 rounded-xl pl-12 pr-4 py-3 text-white placeholder-white/60 focus:outline-none focus:border-white/50">
                    </div>
                </div>
                <select id="distance" class="glass px-4 py-3 rounded-xl text-white bg-white/10 border border-white/30">
                    <option>Within 5km</option>
                    <option>Within 10km</option>
                    <option>Within 20km</option>
                    <option>All</option>
                </select>
                <select id="sort" class="glass px-4 py-3 rounded-xl text-white bg-white/10 border border-white/30">
                    <option>Nearest First</option>
                    <option>Expiring Soon</option>
                    <option>Largest Quantity</option>
                </select>
                <button id="filterBtn" class="glass px-6 py-3 rounded-xl font-semibold text-white hover:bg-white/20 transition">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
            </div>
        </div>

        <!-- Food Donations Grid + Map -->
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Food Cards -->
            <div class="lg:col-span-2 space-y-6">
                <h2 class="text-3xl font-bold text-white mb-8 flex items-center">
                    <i class="fas fa-utensils mr-3 text-yellow-400"></i>
                    Nearby Food Donations
                </h2>
                <?php if (empty($donations)): ?>
                    <div class="glass p-16 rounded-3xl text-center">
                        <i class="fas fa-search-location text-6xl text-white/50 mb-6"></i>
                        <h3 class="text-2xl font-bold text-white mb-2">No donations nearby</h3>
                        <p class="text-white/70">Try increasing search radius or check later</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($donations as $donation): 
                        $timeInfo = $functions->timeRemaining($donation['expiry_time']);
                    ?>
                    <div class="food-card glass p-6 rounded-3xl cursor-pointer group hover:border-yellow-400/50 border border-white/20" data-donation-id="<?php echo $donation['id']; ?>">
                        <div class="relative overflow-hidden rounded-2xl mb-4">
                            <img src="<?php echo $donation['image'] ?: 'https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?w=400&h=250&fit=crop'; ?>" alt="<?php echo htmlspecialchars($donation['title']); ?>" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute top-3 right-3 glass px-3 py-1 rounded-full text-xs font-bold text-green-400">
                                <?php echo $timeInfo['text']; ?>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <h3 class="font-bold text-xl text-white group-hover:text-yellow-400 transition line-clamp-2"><?php echo htmlspecialchars($donation['title']); ?></h3>
                            <div class="flex items-center text-yellow-400">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                <span><?php echo round($donation['distance'], 1); ?> km away</span>
                            </div>
                            <div class="flex items-center text-green-400">
                                <i class="fas fa-weight-hanging mr-2"></i>
                                <span><?php echo htmlspecialchars($donation['quantity']); ?></span>
                            </div>
                            <div class="text-white/80 text-sm line-clamp-2"><?php echo htmlspecialchars($donation['description'] ?: 'Ready for immediate pickup'); ?></div>
                            <div class="flex items-center space-x-2 text-sm text-white/70">
                                <i class="fas fa-user mr-1"></i>
                                <span><?php echo htmlspecialchars($donation['donor_name']); ?></span>
                            </div>
                            <button class="w-full glass py-3 px-6 rounded-xl font-bold text-lg bg-gradient-to-r from-yellow-400/90 to-orange-500/90 hover:from-yellow-400 hover:to-orange-500 text-gray-900 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-xl group-hover:bg-yellow-400/100" onclick="claimDonation(<?php echo $donation['id']; ?>)">
                                <i class="fas fa-hand-pointer mr-2"></i>Claim This Food
                            </button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Map Sidebar -->
            <div class="glass rounded-3xl p-6 h-[500px] sticky top-24">
                <h3 class="text-xl font-bold text-white mb-4 flex items-center">
                    <i class="fas fa-map mr-2 text-blue-400"></i>Map View
                </h3>
                <div id="map" class="w-full h-full rounded-2xl" style="min-height: 400px;"></div>
                <div class="text-xs text-white/60 mt-4 text-center">
                    Green markers: Available donations
                </div>
            </div>
        </div>
    </div>

    <script>
        let map;
        const donations = <?php echo json_encode($donations); ?>;

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: <?php echo $ngo_lat; ?>, lng: <?php echo $ngo_lng; ?>},
                zoom: 12,
                styles: [
                    {featureType: "poi", elementType: "labels", stylers: [{visibility: "off"}]},
                    {featureType: "transit", elementType: "labels", stylers: [{visibility: "off"}]}
                ]
            });

            // NGO marker
            new google.maps.Marker({
                position: {lat: <?php echo $ngo_lat; ?>, lng: <?php echo $ngo_lng; ?>},
                map: map,
                title: 'Your NGO Location',
                icon: 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png'
            });

            // Donation markers
            donations.forEach(donation => {
                const marker = new google.maps.Marker({
                    position: {lat: parseFloat(donation.location_lat), lng: parseFloat(donation.location_lng)},
                    map: map,
                    title: donation.title,
                    icon: {
                        url: 'https://maps.google.com/mapfiles/ms/icons/green-dot.png',
                        scaledSize: new google.maps.Size(32, 32)
                    }
                });

                marker.addListener('click', () => {
                    map.setCenter(marker.getPosition());
                    map.setZoom(15);
                    alert(`${donation.title}\n${donation.distance.toFixed(1)}km away\n${donation.quantity}`);
                });
            });
        }

        function claimDonation(donationId) {
            if (confirm('Claim this donation? You will be connected with the donor.')) {
                fetch('../api/claim.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({donation_id: donationId})
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert('Food claimed successfully! Check notifications.');
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                });
            }
        }

        // Filters
        document.getElementById('filterBtn').onclick = function() {
            // Simulate filter
            console.log('Filtering donations...');
        };

        // Live search
        document.getElementById('search').onkeyup = function() {
            const term = this.value.toLowerCase();
            document.querySelectorAll('.food-card').forEach(card => {
                const title = card.querySelector('h3').textContent.toLowerCase();
                card.style.display = title.includes(term) ? 'block' : 'none';
            });
        };
    </script>
</body>
</html>

