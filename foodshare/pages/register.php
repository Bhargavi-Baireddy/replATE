<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - FoodShare</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-8">
    <main class="w-full max-w-lg">
        <div class="glass p-10 rounded-3xl shadow-2xl">
            <div class="text-center mb-12">
                <div class="w-24 h-24 mx-auto mb-8 glass rounded-3xl flex items-center justify-center shadow-xl">
                    <i class="fas fa-user-plus text-4xl text-white"></i>
                </div>
                <h1 class="text-4xl font-bold text-white mb-4">Create Account</h1>
                <p class="text-white/80">Join FoodShare community</p>
            </div>

            <form id="regForm" class="space-y-6">
                <div class="form-group">
                    <label class="text-white font-semibold">Full Name</label>
                    <input name="name" placeholder="John Doe" required class="form-group input">
                </div>

                <div class="form-group">
                    <label class="text-white font-semibold">Email Address</label>
                    <input name="email" type="email" placeholder="john@example.com" required class="form-group input">
                </div>

                <div class="form-group">
                    <label class="text-white font-semibold">Phone (Optional)</label>
                    <input name="phone" type="tel" placeholder="+1 234 567 8900" class="form-group input">
                </div>

                <div class="form-group">
                    <label class="text-white font-semibold">Address</label>
                    <textarea name="address" rows="2" placeholder="123 Main St, City" class="form-group input resize-none"></textarea>
                </div>

                <div class="form-group">
                    <label class="text-white font-semibold">Password</label>
                    <input name="password" type="password" placeholder="Minimum 6 characters" required class="form-group input">
                </div>

                <div class="form-group">
                    <label class="text-white font-semibold mb-4 block">Join as:</label>
                    <div class="grid grid-cols-2 gap-4">
                    <label class="role-card glass p-6 rounded-2xl cursor-pointer hover:scale-105 hover:bg-white/20 transition-all flex flex-col items-center text-center h-28 group relative">
                            <input name="role" value="donor" type="radio" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required>
                            <i class="fas fa-utensils text-3xl text-orange-400 mb-2 group-hover:scale-110 transition-transform"></i>
                            <span class="text-white font-bold text-lg">Donor</span>
                            <small class="text-white/70 text-xs">Post food</small>
                        </label>
                        <label class="role-card glass p-6 rounded-2xl cursor-pointer hover:scale-105 hover:bg-white/20 transition-all flex flex-col items-center text-center h-28 group relative">
                            <input name="role" value="ngo" type="radio" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required>
                            <i class="fas fa-heart text-3xl text-pink-400 mb-2 group-hover:scale-110 transition-transform"></i>
                            <span class="text-white font-bold text-lg">NGO</span>
                            <small class="text-white/70 text-xs">Claim food</small>
                        </label>
                        <label class="role-card glass p-6 rounded-2xl cursor-pointer hover:scale-105 hover:bg-white/20 transition-all flex flex-col items-center text-center h-28 group relative">
                            <input name="role" value="volunteer" type="radio" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required>
                            <i class="fas fa-truck text-3xl text-blue-400 mb-2 group-hover:scale-110 transition-transform"></i>
                            <span class="text-white font-bold text-lg">Volunteer</span>
                            <small class="text-white/70 text-xs">Deliver</small>
                        </label>
                        <label class="role-card glass p-6 rounded-2xl cursor-pointer hover:scale-105 hover:bg-white/20 transition-all flex flex-col items-center text-center h-28 group relative">
                            <input name="role" value="admin" type="radio" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required>
                            <i class="fas fa-user-shield text-3xl text-purple-400 mb-2 group-hover:scale-110 transition-transform"></i>
                            <span class="text-white font-bold text-lg">Admin</span>
                            <small class="text-white/70 text-xs">Manage</small>
                        </label>
                    </div>
                </div>


                <button type="submit" class="btn-primary w-full text-xl py-4 rounded-2xl font-bold shadow-xl hover:shadow-2xl">
                    <i class="fas fa-user-plus mr-3"></i>Create Account
                </button>
            </form>

            <div class="text-center mt-10 pt-8 border-t border-white/20">
                <p class="text-white/70">
                    Already have an account? <a href="login.php" class="text-yellow-300 font-semibold hover:text-yellow-200">Sign in</a>
                </p>
            </div>
        </div>
    </main>

    <script>
document.getElementById("regForm").onsubmit = async (e)=>{
e.preventDefault();

let fd = new FormData(e.target);
fd.append("action", "register"); 

let res = await fetch("/foodshare/backend/api/auth.php",{method:"POST",body:fd});
let data = await res.json();

if(data.status==="success"){
    // Nice success message
    const successDiv = document.createElement('div');
    successDiv.className = 'glass p-6 rounded-2xl bg-green-500/20 border border-green-400/50 text-green-100 mb-6';
    successDiv.innerHTML = `<i class="fas fa-check-circle text-2xl mr-3"></i><strong>Welcome aboard!</strong> Redirecting to login...`;
    document.querySelector('main').prepend(successDiv);
    setTimeout(() => location.href="/foodshare/pages/login.php", 2000);
}else {
    // Nice error
    const errorDiv = document.createElement('div');
    errorDiv.className = 'glass p-4 rounded-2xl bg-red-500/20 border border-red-400/50 text-red-100 mb-6 animate-pulse';
    errorDiv.innerHTML = `<i class="fas fa-exclamation-triangle mr-2"></i>${data.message}`;
    document.querySelector('main').prepend(errorDiv);
    setTimeout(() => errorDiv.remove(), 5000);
}
};

// Role radio styling
document.querySelectorAll('input[name="role"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.role-card').forEach(card => {
            card.classList.remove('ring-4', 'ring-green-400/50', 'bg-white/20');
        });
        this.parentElement.classList.add('ring-4', 'ring-green-400/50', 'bg-white/20', 'ring-offset-2 ring-offset-transparent');
    });
});

    </script>
</body>
</html>
