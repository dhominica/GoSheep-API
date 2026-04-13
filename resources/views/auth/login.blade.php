<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | GoSheep</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"
        rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f8fafc;
        }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen p-6">

    <div class="flex bg-white rounded-[2rem] shadow-2xl overflow-hidden max-w-3xl w-full min-h-[550px]">

        <!-- Left Column: Hero Photo with Blur -->
        <div class="hidden md:flex md:w-2/5 p-10 flex-col justify-between text-white relative overflow-hidden">
            <!-- Background Image -->
            <img src="{{ asset('assets/img/image copy.png') }}" 
                 alt="Farm Background" 
                 class="absolute inset-0 w-full h-full object-cover">
            
            <!-- Green Blur Overlay -->
            <div class="absolute inset-0 bg-[#2E7D32]/60 backdrop-blur-[2px]"></div>

            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-10">
    <div class="bg-white/20 p-2 rounded-lg backdrop-blur-md">
        <img src="{{ asset('assets/img/logo_app.png') }}" alt="Logo GoSheep" class="w-6 h-6 object-contain">
    </div>
    <span class="text-xl font-800 tracking-tight text-white">GoSheep</span>
</div>
                <h2 class="text-2xl font-bold leading-tight">Pantau Ternak Lebih Mudah.</h2>
                <p class="mt-3 text-green-50/90 text-sm">Solusi cerdas untuk peternakan modern Indonesia.</p>
            </div>

            <p class="relative z-10 text-[10px] text-green-200/50 tracking-widest uppercase">© 2026 GOSHEEP ID</p>
        </div>

        <!-- Right Column: Login Form -->
        <div class="w-full md:w-3/5 p-10 flex flex-col justify-center">
            
            <div class="mb-8">
                <h3 class="text-3xl font-bold text-green-800">Masuk</h3>
                <p class="text-gray-400 to text-black text-sm mt-1">Gunakan akun peternak Anda.</p>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                
                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">Email</label>
                    <div class="relative">
                        <i data-lucide="mail" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                            class="w-full pl-11 pr-4 py-3.5 rounded-xl border @error('email') border-red-500 @else border-gray-100 @enderror bg-gray-50 focus:bg-white focus:border-[#2E7D32] focus:ring-4 focus:ring-[#2E7D32]/5 outline-none transition-all text-sm"
                            placeholder="nama@email.com">
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Input -->
                <div>
                    <div class="flex justify-between mb-2 ml-1">
                        <label for="password" class="text-xs font-bold text-gray-500 uppercase tracking-wider">Kata Sandi</label>
                    </div>
                    <div class="relative">
                        <i data-lucide="key-round" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                        <input type="password" name="password" id="password" required
                            class="w-full pl-11 pr-4 py-3.5 rounded-xl border @error('password') border-red-500 @else border-gray-100 @enderror bg-gray-50 focus:bg-white focus:border-[#2E7D32] focus:ring-4 focus:ring-[#2E7D32]/5 outline-none transition-all text-sm"
                            placeholder="••••••••">
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label for="remember" class="flex items-center cursor-pointer">
                        <input type="checkbox" name="remember" id="remember"
                            class="w-4 h-4 rounded border-gray-300 text-[#2E7D32] focus:ring-[#2E7D32]">
                        <span class="ml-2 text-xs font-medium text-gray-500">Ingat saya</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs font-bold text-[#2E7D32] hover:underline">Lupa Password?</a>
                    @else
                        <a href="#" class="text-xs font-bold text-[#2E7D32] hover:underline">Lupa Password?</a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-[#2E7D32] hover:bg-[#1b5e20] text-white font-bold py-3.5 rounded-xl transition-all shadow-lg shadow-green-900/10 active:scale-[0.98] mt-2">
                    Masuk Sekarang
                </button>
            </form>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>