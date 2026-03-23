<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FoodShare</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-8">
    <main class="w-full max-w-md">
        <div class="glass p-10 rounded-3xl shadow-2xl">
            <div class="text-center mb-12">
                <div class="w-24 h-24 mx-auto mb-8 glass rounded-3xl flex items-center justify-center shadow-xl">
                    <i class="fas fa-sign-in-alt text-4xl text-white"></i>
                </div>
                <h1 class="text-4xl font-bold text-white mb-4">Welcome Back</h1>
                <p class="text-white/80">Sign in to your account</p>
            </div>

            <form id="loginForm" class="space-y-6">
                <div class="form-group">
                    <label class="text-white font-semibold">Email Address</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-4 top-4 text-white/50"></i>
                        <input name="email" type="email" placeholder="your@email.com" required class="form-group input pl-12">
                    </div>
                </div>

                <div class="form-group">
                    <label class="text-white font-semibold">Password</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-4 top-4 text-white/50"></i>
                        <input name="password" type="password" placeholder="••••••••" required class="form-group input pl-12">
                    </div>
                </div>

                <button type="submit" class="btn-primary w-full text-xl py-4 rounded-2xl font-bold shadow-xl hover:shadow-2xl">
                    <i class="fas fa-arrow-right mr-3"></i>Sign In
                </button>
            </form>

            <div class="text-center mt-8 space-y-4">
                <p class="text-white/70">
                    Don't have an account? <a href="register.php" class="text-yellow-300 font-semibold hover:text-yellow-200">Create one</a>
                </p>
                <div class="glass py-3 px-6 rounded-xl">
                    <p class="text-white/80 text-sm">Demo: <strong>test@test.com</strong> / <strong>password</strong></p>
                </div>
            </div>
        </div>
    </main>

    <script>
document.getElementById("loginForm").onsubmit = async (e)=>{
    e.preventDefault();

let fd = new FormData(e.target);
fd.append("action", "login"); 

    let res = await fetch("/foodshare/backend/api/auth.php",{
        method:"POST",
        body:fd
    });

    let data = await res.json();

    if(data.status==="success"){
        location.href = data.redirect;
    } else {
        // Show nice error
        const errorDiv = document.createElement('div');
        errorDiv.className = 'glass p-4 rounded-2xl bg-red-500/20 border border-red-400/50 text-red-100 mb-6 animate-pulse';
        errorDiv.innerHTML = `<i class="fas fa-exclamation-triangle mr-2"></i>${data.message}`;
        document.querySelector('main').prepend(errorDiv);
        setTimeout(() => errorDiv.remove(), 5000);
    }
};
    </script>
</body>
</html>
