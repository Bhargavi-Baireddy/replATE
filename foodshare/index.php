<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodShare - Reduce Food Waste, Feed the Hungry</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translate3d(0,0,0)' },
                            '50%': { transform: 'translate3d(0,-20px,0)' },
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .food-card {
            transition: all 0.3s ease;
        }
        .food-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen">
    <!-- Navigation -->
    <nav class="glass sticky top-0 z-50 px-6 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="text-2xl font-bold text-white">
                <i class="fas fa-utensils mr-2"></i>FoodShare
            </div>
            <div class="space-x-4">
                <a href="#" class="text-white hover:text-blue-300 transition">Home</a>
                <a href="pages/auth/login.php" class="bg-white text-purple-600 px-6 py-2 rounded-full font-semibold hover:bg-gray-100 transition">Login</a>
                <a href="pages/auth/register.php" class="border border-white text-white px-6 py-2 rounded-full font-semibold hover:bg-white hover:text-purple-600 transition">Sign Up</a>
            </div>
    </nav>

    <!-- Hero Section -->
    <section class="py-20 px-6">
        <div class="max-w-7xl mx-auto text-center text-white">
            <h1 class="text-5xl md:text-7xl font-bold mb-8 animate-float">
                Stop Food Waste.<br>
                <span class="text-yellow-300">Feed the Hungry.</span>
            </h1>
            <p class="text-xl md:text-2xl mb-12 opacity-90 max-w-3xl mx-auto">
                Connect restaurants, events & individuals with NGOs and volunteers to rescue surplus food 
                before it goes to waste. Every meal saved counts!
            </p>
            <div class="space-x-4">
                <a href="pages/auth/register.php" class="bg-yellow-400 text-gray-900 px-10 py-4 rounded-full text-xl font-bold hover:bg-yellow-300 transition transform hover:scale-105">
                    <i class="fas fa-utensils mr-2"></i>Join as Donor
                </a>
                <a href="pages/auth/register.php?role=ngo" class="bg-white text-purple-600 px-10 py-4 rounded-full text-xl font-bold hover:bg-gray-100 transition transform hover:scale-105">
                    <i class="fas fa-heart mr-2"></i>Join as NGO
                </a>
            </div>
    </section>

    <!-- Stats Section -->
    <section class="py-20 px-6 bg-white/10 backdrop-blur-sm">
        <div class="max-w-6xl mx-auto grid md:grid-cols-4 gap-8 text-center text-white">
            <div class="glass p-8 rounded-3xl">
                <div class="text-4xl font-bold text-yellow-400 mb-2">12,540+</div>
                <div class="text-lg opacity-90">Meals Saved</div>
            <div class="glass p-8 rounded-3xl">
                <div class="text-4xl font-bold text-green-400 mb-2">2,100+</div>
                <div class="text-lg opacity-90">Food Donations</div>
            <div class="glass p-8 rounded-3xl">
                <div class="text-4xl font-bold text-blue-400 mb-2">45+</div>
                <div class="text-lg opacity-90">Active NGOs</div>
            <div class="glass p-8 rounded-3xl">
                <div class="text-4xl font-bold text-pink-400 mb-2">120+</div>
                <div class="text-lg opacity-90">Active Volunteers</div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-20">
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">How FoodShare Works</h2>
                <p class="text-xl text-white/80 max-w-2xl mx-auto">Simple 3-step process to rescue food</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="glass p-8 rounded-3xl text-center group hover:scale-105 transition">
                    <div class="w-20 h-20 bg-yellow-400 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:rotate-12 transition">
                        <i class="fas fa-utensils text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">Post Surplus Food</h3>
                    <p class="text-white/80">Restaurants post available food with location, quantity & expiry time</p>
                </div>
                
                <div class="glass p-8 rounded-3xl text-center group hover:scale-105 transition">
                    <div class="w-20 h-20 bg-green-400 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:rotate-12 transition">
                        <i class="fas fa-search-location text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">NGOs Claim Food</h3>
                    <p class="text-white/80">NGOs browse nearby donations on map and claim what they need</p>
                </div>
                
                <div class="glass p-8 rounded-3xl text-center group hover:scale-105 transition">
                    <div class="w-20 h-20 bg-blue-400 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:rotate-12 transition">
                        <i class="fas fa-truck text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">Volunteers Deliver</h3>
                    <p class="text-white/80">Volunteers pickup and deliver food to those in need</p>
                </div>
        </div>
    </section>

    <!-- Food Cards Demo -->
    <section class="py-20 px-6 bg-white/10 backdrop-blur-sm">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">Available Food Donations</h2>
                <p class="text-xl text-white/80">Browse surplus food from nearby donors</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="food-card glass p-6 rounded-3xl cursor-pointer group">
                    <img src="https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?w=400&h=300&fit=crop&crop=center" alt="Biryani" class="w-full h-48 object-cover rounded-2xl mb-4 group-hover:scale-105 transition">
                    <div class="space-y-2">
                        <h3 class="font-bold text-xl text-white group-hover:text-yellow-400 transition">Chicken Biryani</h3>
                        <div class="flex items-center text-yellow-400">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            <span>2.4 km away</span>
                        </div>
                        <div class="flex items-center text-green-400">
                            <i class="fas fa-weight-hanging mr-2"></i>
                            <span>15 kg available</span>
                        </div>
                        <div class="flex items-center text-red-400">
                            <i class="fas fa-clock mr-2"></i>
                            <span id="timer1">02:15:30</span>
                        </div>
                        <button class="w-full mt-4 bg-gradient-to-r from-yellow-400 to-orange-500 text-gray-900 py-3 rounded-2xl font-bold hover:from-yellow-300 hover:to-orange-400 transition transform hover:scale-105">
                            Claim Food
                        </button>
                    </div>

                <div class="food-card glass p-6 rounded-3xl cursor-pointer group">
                    <img src="https://images.unsplash.com/photo-1574651351432-98304e3e8f1b?w=400&h=300&fit=crop&crop=center" alt="Pizza" class="w-full h-48 object-cover rounded-2xl mb-4 group-hover:scale-105 transition">
                    <div class="space-y-2">
                        <h3 class="font-bold text-xl text-white group-hover:text-yellow-400 transition">Veg Pizza</h3>
                        <div class="flex items-center text-yellow-400">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            <span>1.8 km away</span>
                        </div>
                        <div class="flex items-center text-green-400">
                            <i class="fas fa-weight-hanging mr-2"></i>
                            <span>20 pieces</span>
                        </div>
                        <div class="flex items-center text-red-400">
                            <i class="fas fa-clock mr-2"></i>
                            <span id="timer2">01:45:12</span>
                        </div>
                        <button class="w-full mt-4 bg-gradient-to-r from-yellow-400 to-orange-500 text-gray-900 py-3 rounded-2xl font-bold hover:from-yellow-300 hover:to-orange-400 transition transform hover:scale-105">
                            Claim Food
                        </button>
                    </div>

                <div class="food-card glass p-6 rounded-3xl cursor-pointer group">
                    <img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?w=400&h=300&fit=crop&crop=center" alt="Sandwich" class="w-full h-48 object-cover rounded-2xl mb-4 group-hover:scale-105 transition">
                    <div class="space-y-2">
                        <h3 class="font-bold text-xl text-white group-hover:text-yellow-400 transition">Veg Sandwiches</h3>
                        <div class="flex items-center text-yellow-400">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            <span>3.2 km away</span>
                        </div>
                        <div class="flex items-center text-green-400">
                            <i class="fas fa-weight-hanging mr-2"></i>
                            <span>50 pieces</span>
                        </div>
                        <div class="flex items-center text-red-400">
                            <i class="fas fa-clock mr-2"></i>
                            <span id="timer3">03:20:45</span>
                        </div>
                        <button class="w-full mt-4 bg-gradient-to-r from-yellow-400 to-orange-500 text-gray-900 py-3 rounded-2xl font-bold hover:from-yellow-300 hover:to-orange-400 transition transform hover:scale-105">
                            Claim Food
                        </button>
                    </div>
            </div>
    </section>

    <!-- Footer -->
    <footer class="glass py-12 px-6 mt-20">
        <div class="max-w-6xl mx-auto text-center text-white/80">
            <div class="text-2xl font-bold mb-6">FoodShare</div>
            <p>&copy; 2024 FoodShare. All rights reserved. Making the world hunger-free, one meal at a time.</p>
        </div>
    </footer>

    <script>
        // Demo countdown timers
        function startTimer(id, time) {
            let totalSeconds = time;
            const timerElement = document.getElementById(id);
            
            const interval = setInterval(() => {
                const hours = Math.floor(totalSeconds / 3600);
                const minutes = Math.floor((totalSeconds % 3600) / 60);
                const seconds = totalSeconds % 60;
                
                timerElement.textContent = 
                    `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                
                if (totalSeconds <= 0) {
                    clearInterval(interval);
                    timerElement.textContent = 'EXPIRED';
                    timerElement.parentElement.parentElement.querySelector('button').disabled = true;
                }
                totalSeconds--;
            }, 1000);
        }

        // Start demo timers
        startTimer('timer1', 8190); // 2h15m30s
        startTimer('timer2', 6312); // 1h45m12s
        startTimer('timer3', 12045); // 3h20m45s

        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>
