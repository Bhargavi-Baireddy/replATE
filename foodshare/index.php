<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodShare - Reduce Food Waste</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        .glass {
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255,255,255,0.12);
        }
        .purple-gradient {
            background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 50%, #c084fc 100%);
        }
        .card-hover {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .card-hover:hover {
            transform: translateY(-16px);
            box-shadow: 0 32px 64px rgba(0,0,0,0.3);
        }
        .floating {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
    </style>
</head>
<body class="purple-gradient min-h-screen text-white">
    
    <!-- Fixed Navbar -->
    <nav class="glass fixed top-0 left-0 right-0 z-50 px-6 py-5 border-b border-white/10">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center gap-3">
                <div class="w-14 h-14 glass rounded-2xl flex items-center justify-center p-3">
                    <i class="fas fa-seedling text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-black leading-tight">FoodShare</h1>
                    <p class="text-xs opacity-80 font-medium">Rescue Food. Save Lives.</p>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="flex items-center gap-4">
                <button class="glass p-3 rounded-2xl relative hover:bg-white/10 transition-all flex items-center">
                    <i class="fas fa-bell text-xl"></i>
                    <span class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full text-xs font-bold flex items-center justify-center animate-pulse">5</span>
                </button>
                <a href="pages/auth/login.php" class="glass px-8 py-3 rounded-2xl font-semibold hover:bg-white/10 transition-all">Login</a>
                <a href="pages/auth/register.php" class="bg-white text-purple-600 px-10 py-3 rounded-2xl font-bold text-lg hover:bg-gray-100 hover:shadow-2xl transition-all shadow-xl">Sign Up Free</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="min-h-screen flex items-center justify-center pt-32 pb-20 px-6 relative">
        <div class="max-w-7xl mx-auto text-center">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 mb-12 px-6 py-3 glass rounded-full max-w-max mx-auto floating">
                <div class="w-3 h-3 bg-green-400 rounded-full animate-ping"></div>
                <span class="font-semibold opacity-90">Live • 2.1K donations today</span>
            </div>
            
            <h1 class="text-7xl lg:text-9xl xl:text-[10rem] font-black leading-[0.9] mb-8 bg-gradient-to-r from-white via-white/80 to-white/40 bg-clip-text text-transparent drop-shadow-2xl">
                Stop <span class="block text-yellow-300 text-[0.65em] tracking-wider font-normal opacity-90">FOOD WASTE</span>
            </h1>
            
            <p class="text-2xl lg:text-3xl font-medium opacity-90 max-w-2xl mx-auto mb-12 leading-relaxed">
                Connect restaurants with NGOs instantly. Rescue surplus food before it expires.
                <span class="block text-lg opacity-75 mt-4">Zero waste. Maximum impact. Every plate saved counts.</span>
            </p>
            
            <div class="flex flex-col lg:flex-row gap-6 justify-center items-center max-w-3xl mx-auto mb-24">
                <a href="pages/auth/register.php?role=donor" class="flex-1 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-400 hover:to-orange-500 text-xl font-bold px-12 py-6 rounded-3xl shadow-2xl hover:shadow-orange-500/50 hover:-translate-y-2 transition-all text-white max-w-md mx-auto lg:mx-0">
                    <i class="fas fa-utensils mr-3"></i>
                    Start Donating
                </a>
                <a href="pages/auth/register.php?role=ngo" class="flex-1 glass px-12 py-6 rounded-3xl font-bold text-xl border border-white/20 hover:bg-white/10 hover:border-white/30 hover:-translate-y-2 transition-all max-w-md mx-auto lg:mx-0">
                    <i class="fas fa-heart mr-3"></i>
                    Join as NGO
                </a>
            </div>

            <!-- Scroll Indicator -->
            <div class="animate-bounce">
                <i class="fas fa-chevron-down text-2xl opacity-60"></i>
            </div>
        </div>

        <!-- Floating Particles -->
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-20 left-20 w-64 h-64 bg-white/5 rounded-full blur-3xl animate-ping" style="animation-delay: 0s;"></div>
            <div class="absolute bottom-40 right-32 w-80 h-80 bg-white/4 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
            <div class="absolute top-1/2 left-10 w-32 h-32 bg-yellow-400/10 rounded-full blur-xl animate-float" style="animation-delay: 1s;"></div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-32 relative">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-12">
                <div class="group glass p-12 rounded-4xl cursor-pointer card-hover">
                    <i class="fas fa-utensils text-6xl text-white/20 group-hover:text-emerald-400 transition-all duration-700 mb-8"></i>
                    <div class="text-6xl lg:text-7xl font-black bg-gradient-to-r from-emerald-400 to-teal-400 bg-clip-text text-transparent mb-6 group-hover:scale-110 transition-all">25.6K</div>
                    <h3 class="text-2xl font-bold text-white mb-3">Meals Rescued</h3>
                    <p class="opacity-75">This week alone</p>
                </div>

                <div class="group glass p-12 rounded-4xl cursor-pointer card-hover">
                    <i class="fas fa-donate text-6xl text-white/20 group-hover:text-orange-400 transition-all duration-700 mb-8"></i>
                    <div class="text-6xl lg:text-7xl font-black bg-gradient-to-r from-orange-400 to-amber-400 bg-clip-text text-transparent mb-6 group-hover:scale-110 transition-all">3.8K</div>
                    <h3 class="text-2xl font-bold text-white mb-3">Active Donations</h3>
                    <p class="opacity-75">Ready for pickup</p>
                </div>

                <div class="group glass p-12 rounded-4xl cursor-pointer card-hover">
                    <i class="fas fa-handshake text-6xl text-white/20 group-hover:text-blue-400 transition-all duration-700 mb-8"></i>
                    <div class="text-6xl lg:text-7xl font-black bg-gradient-to-r from-blue-400 to-cyan-400 bg-clip-text text-transparent mb-6 group-hover:scale-110 transition-all">89</div>
                    <h3 class="text-2xl font-bold text-white mb-3">NGO Partners</h3>
                    <p class="opacity-75">Verified organizations</p>
                </div>

                <div class="group glass p-12 rounded-4xl cursor-pointer card-hover">
                    <i class="fas fa-truck-fast text-6xl text-white/20 group-hover:text-purple-400 transition-all duration-700 mb-8"></i>
                    <div class="text-6xl lg:text-7xl font-black bg-gradient-to-r from-purple-400 to-violet-400 bg-clip-text text-transparent mb-6 group-hover:scale-110 transition-all">247</div>
                    <h3 class="text-2xl font-bold text-white mb-3">Active Volunteers</h3>
                    <p class="opacity-75">Ready to deliver</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Food Grid -->
    <section class="py-32 px-6 -mt-20 relative">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-24">
                <h2 class="text-6xl lg:text-7xl font-black bg-gradient-to-r from-white via-white/90 to-white/60 bg-clip-text text-transparent mb-6">
                    Live Donations <span class="text-4xl block font-normal opacity-80">Nearby • Fresh • Ready</span>
                </h2>
            </div>
            
            <div class="grid xl:grid-cols-3 lg:grid-cols-2 gap-8">
                <!-- Card 1 -->
                <div class="glass rounded-4xl p-8 card-hover group cursor-pointer overflow-hidden">
                    <div class="relative mb-8">
                        <img src="https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?w=500&h=280&fit=crop&crop=entropy" class="w-full h-64 object-cover rounded-3xl group-hover:scale-110 transition-transform duration-700" alt="Biryani">
                        <div class="absolute top-6 right-6 glass px-5 py-2 rounded-full text-lg font-bold text-orange-400 shadow-2xl">
                            <i class="fas fa-clock mr-2"></i><span id="timer1">02:15:30</span>
                        </div>
                        <div class="absolute bottom-6 left-6 glass px-4 py-2 rounded-full text-sm font-bold bg-green-500/90 text-white">
                            <i class="fas fa-map-marker-alt mr-1"></i>2.4 km
                        </div>
                    </div>
                    <div>
                        <h3 class="text-3xl font-bold text-white mb-4 group-hover:text-orange-300 transition-colors">Chicken Biryani</h3>
                        <div class="flex items-center gap-6 mb-6 text-xl opacity-90">
                            <span><i class="fas fa-weight-hanging text-emerald-400 mr-2"></i>15 kg</span>
                            <span><i class="fas fa-user text-purple-400 mr-2"></i>Hotel Paradise</span>
                        </div>
                        <button class="w-full bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-400 hover:to-red-400 text-xl font-bold py-5 rounded-3xl shadow-2xl hover:shadow-orange-500/50 hover:-translate-y-3 transition-all group-hover:bg-orange-400">
                            <i class="fas fa-bolt mr-3"></i>Claim Instantly
                        </button>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="glass rounded-4xl p-8 card-hover group cursor-pointer overflow-hidden">
                    <div class="relative mb-8">
                        <img src="https://images.unsplash.com/photo-1574651351432-98304e3e8f1b?w=500&h=280&fit=crop&crop=entropy" class="w-full h-64 object-cover rounded-3xl group-hover:scale-110 transition-transform duration-700" alt="Pizza">
                        <div class="absolute top-6 right-6 glass px-5 py-2 rounded-full text-lg font-bold text-emerald-400 shadow-2xl">
                            <i class="fas fa-clock mr-2"></i><span id="timer2">01:45:12</span>
                        </div>
                        <div class="absolute bottom-6 left-6 glass px-4 py-2 rounded-full text-sm font-bold bg-blue-500/90 text-white">
                            <i class="fas fa-map-marker-alt mr-1"></i>1.8 km
                        </div>
                    </div>
                    <div>
                        <h3 class="text-3xl font-bold text-white mb-4 group-hover:text-emerald-300 transition-colors">Margherita Pizza</h3>
                        <div class="flex items-center gap-6 mb-6 text-xl opacity-90">
                            <span><i class="fas fa-pizza-slice text-yellow-400 mr-2"></i>25 slices</span>
                            <span><i class="fas fa-user text-purple-400 mr-2"></i>Domino's</span>
                        </div>
                        <button class="w-full bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-400 hover:to-red-400 text-xl font-bold py-5 rounded-3xl shadow-2xl hover:shadow-orange-500/50 hover:-translate-y-3 transition-all group-hover:bg-orange-400">
                            <i class="fas fa-bolt mr-3"></i>Claim Instantly
                        </button>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="glass rounded-4xl p-8 card-hover group cursor-pointer overflow-hidden">
                    <div class="relative mb-8">
                        <img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?w=500&h=280&fit=crop&crop=entropy" class="w-full h-64 object-cover rounded-3xl group-hover:scale-110 transition-transform duration-700" alt="Sandwich">
                        <div class="absolute top-6 right-6 glass px-5 py-2 rounded-full text-lg font-bold text-purple-400 shadow-2xl">
                            <i class="fas fa-clock mr-2"></i><span id="timer3">03:20:45</span>
                        </div>
                        <div class="absolute bottom-6 left-6 glass px-4 py-2 rounded-full text-sm font-bold bg-green-500/90 text-white">
                            <i class="fas fa-map-marker-alt mr-1"></i>3.2 km
                        </div>
                    </div>
                    <div>
                        <h3 class="text-3xl font-bold text-white mb-4 group-hover:text-purple-300 transition-colors">Club Sandwiches</h3>
                        <div class="flex items-center gap-6 mb-6 text-xl opacity-90">
                            <span><i class="fas fa-bread-slice text-amber-400 mr-2"></i>60 pieces</span>
                            <span><i class="fas fa-user text-purple-400 mr-2"></i>Cafe Coffee Day</span>
                        </div>
                        <button class="w-full bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-400 hover:to-red-400 text-xl font-bold py-5 rounded-3xl shadow-2xl hover:shadow-orange-500/50 hover:-translate-y-3 transition-all group-hover:bg-orange-400">
                            <i class="fas fa-bolt mr-3"></i>Claim Instantly
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="glass py-16 px-6 border-t border-white/10 mt-32">
        <div class="max-w-7xl mx-auto text-center">
            <div class="text-3xl font-black mb-6 opacity-90">FoodShare</div>
            <p class="text-lg opacity-75 mb-12 max-w-xl mx-auto">
                Making the world hunger-free, one meal at a time. Join the movement.
            </p>
            <div class="flex flex-wrap gap-6 justify-center text-xl opacity-80">
                <a href="#" class="hover:text-white/60 transition-colors"><i class="fab fa-twitter"></i></a>
                <a href="#" class="hover:text-white/60 transition-colors"><i class="fab fa-linkedin"></i></a>
                <a href="#" class="hover:text-white/60 transition-colors"><i class="fab fa-instagram"></i></a>
                <a href="#" class="hover:text-white/60 transition-colors"><i class="fas fa-envelope"></i></a>
            </div>
            <p class="text-sm opacity-50 mt-12">&copy; 2024 FoodShare. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Perfect live timers
        const timerElements = ['timer1', 'timer2', 'timer3'];
        const initialTimes = [8190, 6312, 12045]; // 2h15m30s, 1h45m12s, 3h20m45s
        
        timerElements.forEach((id, index) => {
            let timeLeft = initialTimes[index];
            const element = document.getElementById(id);
            
            const updateTimer = () => {
                if (timeLeft <= 0) {
                    element.innerHTML = '<i class="fas fa-exclamation-triangle mr-2 text-red-400"></i>EXPIRED';
                    element.closest('.glass').style.borderColor = 'rgb(239 68 68 / 0.5)';
                    return;
                }
                
                const h = Math.floor(timeLeft / 3600);
                const m = Math.floor((timeLeft % 3600) / 60);
                const s = timeLeft % 60;
                element.textContent = `${h.toString().padStart(2,'0')}:${m.toString().padStart(2,'0')}:${s.toString().padStart(2,'0')}`;
                
                if (timeLeft <= 300) { // 5 min warning
                    element.parentElement.classList.add('animate-pulse', 'bg-red-500/90');
                }
                
                timeLeft--;
            };
            
            updateTimer(); // Initial
            setInterval(updateTimer, 1000);
        });

        // Smooth scrolling + navbar hide/show
        let lastScroll = 0;
        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('nav');
            if (window.scrollY > lastScroll && window.scrollY > 100) {
                navbar.style.transform = 'translateY(-100%)';
            } else {
                navbar.style.transform = 'translateY(0)';
            }
            lastScroll = window.scrollY;
        });
    </script>
</body>
</html>
