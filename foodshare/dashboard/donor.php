<?php
require_once '../includes/functions.php';

if (!$functions->isLoggedIn()) {
    header('Location: ../pages/auth/login.php?role=donor');
    exit;
}

$user = $functions->getCurrentUser();
if ($user['role'] !== 'donor') {
    header('Location: ../pages/auth/login.php');
    exit;
}

// Fetch donor's donations
$stmt = $functions->db->prepare("
    SELECT fd.*, 
           CASE 
               WHEN cl.id IS NOT NULL THEN 'claimed'
               ELSE fd.status 
           END as current_status
    FROM food_donations fd 
    LEFT JOIN claims cl ON fd.id = cl.donation_id AND cl.status != 'cancelled'
    WHERE fd.donor_id = ?
    ORDER BY fd.created_at DESC
    LIMIT 10
");
$stmt->execute([$user['id']]);
$donations = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Dashboard - FoodShare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places&callback=initMap"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .glass { background: rgba(255,255,255,0.1); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.2); }
        .gradient-bg { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-8px); }
    </style>
</head>
<body class="min-h-screen gradient-bg">
    <!-- Header -->
    <header class="glass shadow-2xl sticky top-0 z-50 px-6 py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="../index.php" class="text-2xl font-bold text-white">
                <i class="fas fa-utensils mr-2 text-yellow-400"></i>FoodShare Donor
            </a>
            <div class="flex items-center space-x-4">
                <div class="glass px-4 py-2 rounded-full relative text-white cursor-pointer">
                    <i class="fas fa-bell"></i>
                    <span class="absolute -top-1 -right-1 bg-green-500 text-xs rounded-full h-5 w-5 flex items-center justify-center">2</span>
                </div>
                <span class="text-white font-semibold"><?php echo htmlspecialchars($user['name']); ?></span>
                <a href="../pages/auth/login.php?logout=1" class="text-white hover:text-white/80 px-4 py-2 rounded-xl hover:bg-white/10 transition">Logout</a>
            </div>
        </div>
    </header>

    <div class="max-w-6xl mx-auto p-8">
        <!-- Quick Stats -->
        <div class="grid md:grid-cols-4 gap-6 mb-12">
            <div class="glass p-6 rounded-3xl text-center card-hover">
                <div class="text-3xl font-bold text-yellow-400 mb-2"><?php echo count($donations); ?></div>
                <div class="text-white text-lg">Total Donations</div>
            </div>
            <div class="glass p-6 rounded-3xl text-center card-hover">
                <div class="text-3xl font-bold text-green-400 mb-2"><?php echo count(array_filter($donations, fn($d) => $d['current_status'] === 'available')); ?></div>
                <div class="text-white text-lg">Available</div>
            </div>
            <div class="glass p-6 rounded-3xl text-center card-hover">
                <div class="text-3xl font-bold text-blue-400 mb-2"><?php echo count(array_filter($donations, fn($d) => $d['current_status'] === 'claimed')); ?></div>
                <div class="text-white text-lg">Claimed</div>
            </div>
            <div class="glass p-6 rounded-3xl text-center card-hover">
                <div class="text-3xl font-bold text-orange-400 mb-2">0</div>
                <div class="text-white text-lg">Delivered</div>
            </div>
        </div>

        <!-- Post New Donation Button -->
        <div class="glass p-8 rounded-3xl mb-12">
            <h2 class="text-3xl font-bold text-white mb-6">Post New Donation <i class="fas fa-plus-circle text-green-400 ml-2"></i></h2>
            <form id="donationForm" enctype="multipart/form-data" class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-white/90 mb-3 font-bold">Food Name *</label>
                    <input type="text" name="title" required class="w-full glass p-4 rounded-xl text-white bg-white/10 border border-white/30 focus:border-green-400 focus:outline-none">
                </div>
                <div>
                    <label class="block text-white/90 mb-3 font-bold">Quantity *</label>
                    <input type="text" name="quantity" required placeholder="e.g. 10kg, 20 plates" class="w-full glass p-4 rounded-xl text-white bg-white/10 border border-white/30 focus:border-green-400">
                </div>
                <div>
                    <label class="block text-white/90 mb-3 font-bold">Expiry Time *</label>
                    <input type="datetime-local" name="expiry_time" required class="w-full glass p-4 rounded-xl text-white bg-white/10 border border-white/30 focus:border-green-400">
                </div>
                <div>
                    <label class="block text-white/90 mb-3 font-bold">Food Image</label>
                    <input type="file" name="image" accept="image/*" class="w-full glass p-4 rounded-xl text-white bg-white/10 border border-white/30 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-white/20 file:text-gray-900 hover:file:bg-white/30">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-white/90 mb-3 font-bold">Description</label>
                    <textarea name="description" rows="3" class="w-full glass p-4 rounded-xl text-white bg-white/10 border border-white/30 focus:border-green-400 resize-vertical" placeholder="Special instructions, food type, condition..."></textarea>
                </div>
                <div class="md:col-span-2 text-right">
                    <button type="submit" class="bg-gradient-to-r from-green-400 to-emerald-600 text-white px-10 py-4 rounded-2xl font-bold text-lg hover:from-green-300 hover:to-emerald-500 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                        <i class="fas fa-paper-plane mr-2"></i>Post Donation
                    </button>
                </div>
            </form>
        </div>

        <!-- Donations History -->
        <div class="space-y-6">
            <h2 class="text-3xl font-bold text-white flex items-center">
                <i class="fas fa-history mr-3 text-blue-400"></i>Your Donations
            </h2>
            
            <?php if (empty($donations)): ?>
                <div class="glass p-16 rounded-3xl text-center">
                    <i class="fas fa-utensils text-6xl text-white/30 mb-6"></i>
                    <h3 class="text-2xl font-bold text-white mb-2">No donations yet</h3>
                    <p class="text-white/70 mb-6">Post your first surplus food donation above!</p>
                    <div class="w-32 mx-auto glass py-3 px-6 rounded-2xl cursor-pointer hover:bg-white/20 transition font-bold text-white">
                        Post Donation
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($donations as $donation): ?>
                <div class="glass p-8 rounded-3xl card-hover border-l-4 <?php 
                    echo $donation['current_status'] === 'available' ? 'border-l-green-400' : 
                         ($donation['current_status'] === 'claimed' ? 'border-l-yellow-400' : 'border-l-gray-400'); 
                ?>">
                    <div class="flex flex-wrap items-start justify-between gap-6">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center space-x-4 mb-4">
                                <div class="w-16 h-16 rounded-2xl overflow-hidden bg-white/20">
                                    <img src="<?php echo $donation['image'] ?: 'https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?w=64&h=64&fit=crop'; ?>" alt="" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-white"><?php echo htmlspecialchars($donation['title']); ?></h3>
                                    <div class="flex items-center text-green-400 text-sm">
                                        <i class="fas fa-weight-hanging mr-1"></i>
                                        <?php echo htmlspecialchars($donation['quantity']); ?>
                                    </div>
                                </div>
                            </div>
                            <p class="text-white/80 mb-6 line-clamp-3"><?php echo htmlspecialchars($donation['description'] ?: 'No description provided'); ?></p>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 rounded-xl bg-white/10">
                                    <div class="font-bold text-yellow-400"><?php echo $functions->timeRemaining($donation['expiry_time'])['text']; ?></div>
                                    <div class="text-white/70">Time Left</div>
                                </div>
                                <div class="text-center p-3 rounded-xl bg-white/10">
                                    <div class="font-bold text-blue-400"><?php echo $donation['views']; ?></div>
                                    <div class="text-white/70">Views</div>
                                </div>
                                <div class="text-center p-3 rounded-xl bg-white/10">
                                    <div class="font-bold text-purple-400"><?php echo $donation['claims_count']; ?></div>
                                    <div class="text-white/70">Claims</div>
                                </div>
                                <div class="text-center p-3 rounded-xl bg-white/10">
                                    <div class="font-mono text-xs text-white/60"><?php echo date('M j, H:i', strtotime($donation['created_at'])); ?></div>
                                    <div class="text-white/70 text-xs">Posted</div>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-3 min-w-[120px]">
                            <span class="px-4 py-2 rounded-xl font-bold text-center whitespace-nowrap text-sm bg-white/20 <?php 
                                echo $donation['current_status'] === 'available' ? 'text-green-400 bg-green-500/20' : 
                                     'text-yellow-400 bg-yellow-500/20'; 
                            ?>">
                                <?php echo ucfirst($donation['current_status']); ?>
                            </span>
                            <div class="space-y-2">
                                <button class="glass px-4 py-2 rounded-xl hover:bg-white/20 transition text-white text-sm font-semibold" onclick="editDonation(<?php echo $donation['id']; ?>)">
                                    <i class="fas fa-edit mr-1"></i>Edit
                                </button>
                                <button class="glass px-4 py-2 rounded-xl hover:bg-white/20 transition text-white text-sm font-semibold text-red-400" onclick="deleteDonation(<?php echo $donation['id']; ?>)">
                                    <i class="fas fa-trash mr-1"></i>Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <script>
        document.getElementById('donationForm').onsubmit = async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('action', 'create_donation');
            
            try {
                const res = await fetch('../api/donor.php', {
                    method: 'POST',
                    body: formData
                });
                const data = await res.json();
                
                if (data.success) {
                    alert('Donation posted successfully!');
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            } catch (error) {
                alert('Network error. Please try again.');
            }
        };

        function editDonation(id) {
            alert('Edit functionality coming soon!');
        }

        function deleteDonation(id) {
            if (confirm('Delete this donation?')) {
                // API call
                alert('Deleted! (demo)');
            }
        }

        function initMap() {
            // Location picker map coming soon
        }
    </script>
</body>
</html>
