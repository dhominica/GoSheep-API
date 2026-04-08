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

        .hero-pattern {
            background-color: #2E7D32;
            background-image: url("https://www.transparenttextures.com/patterns/pinstriped-suit.png");
        }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen p-6">

    <div class="flex bg-white rounded-[2rem] shadow-2xl overflow-hidden max-w-3xl w-full min-h-[550px]">

        <div class="hidden md:flex md:w-2/5 hero-pattern p-10 flex-col justify-between text-white relative">
            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-10">
                    <div class="bg-white/20 p-2 rounded-lg backdrop-blur-md">
                        <i data-lucide="sprout" class="text-white w-5 h-5"></i>
                    </div>
                    <span class="text-xl font-800 tracking-tight">GoSheep</span>
                </div>
                <h2 class="text-2xl font-bold leading-tight">Pantau Ternak Lebih Mudah.</h2>
                <p class="mt-3 text-green-100/80 text-sm">Solusi cerdas untuk peternakan modern Indonesia.</p>
            </div>

            <p class="relative z-10 text-[10px] text-green-200/50 tracking-widest uppercase">© 2026 GOSHEEP ID</p>

            <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
        </div>

        <div class="w-full md:w-3/5 p-10 flex flex-col justify-center">
            <div class="mb-8">
                <h3 class="text-2xl font-800 text-gray-800">Masuk</h3>
                <p class="text-gray-400 text-sm mt-1">Gunakan akun peternak Anda.</p>
            </div>

            <form action="#" method="POST" class="space-y-5">
                <div>
                    <label
                        class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">Email</label>
                    <div class="relative">
                        <i data-lucide="mail"
                            class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                        <input type="email" name="email" required
                            class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-100 bg-gray-50 focus:bg-white focus:border-[#2E7D32] focus:ring-4 focus:ring-[#2E7D32]/5 outline-none transition-all text-sm"
                            placeholder="nama@email.com">
                    </div>
                </div>

                <div>
                    <div class="flex justify-between mb-2 ml-1">
                        <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Kata Sandi</label>
                    </div>
                    <div class="relative">
                        <i data-lucide="key-round"
                            class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                        <input type="password" name="password" required
                            class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-100 bg-gray-50 focus:bg-white focus:border-[#2E7D32] focus:ring-4 focus:ring-[#2E7D32]/5 outline-none transition-all text-sm"
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox"
                            class="w-4 h-4 rounded border-gray-300 text-[#2E7D32] focus:ring-[#2E7D32]">
                        <span class="ml-2 text-xs font-medium text-gray-500">Ingat saya</span>
                    </label>
                    <a href="#" class="text-xs font-bold text-[#2E7D32] hover:underline">Lupa Password?</a>
                </div>

                <button type="submit"
                    class="w-full bg-[#2E7D32] hover:bg-[#1b5e20] text-white font-bold py-3.5 rounded-xl transition-all shadow-lg shadow-green-900/10 active:scale-[0.98] mt-2">
                    Masuk Sekarang
                </button>

                <p class="text-center text-xs text-gray-500 mt-6">
                    Belum bergabung?
                    <a href="#" class="text-[#2E7D32] font-bold hover:text-green-800 transition-colors ml-1">Buat Akun
                        Baru</a>
                </p>
            </form>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>