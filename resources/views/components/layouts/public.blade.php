<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'GoSheep - Ekosistem Cerdas Peternakan Modern' }}</title>
    <meta name="description" content="{{ $description ?? 'Platform manajemen ternak domba berbasis Machine Learning.' }}">

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] },
                    colors: { primary: '#059669', secondary: '#047857', accent: '#10B981' },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'float-delayed': 'float 6s ease-in-out 3s infinite',
                        'blob': 'blob 7s infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'marquee': 'marquee 25s linear infinite',
                        'spin-slow': 'spin 8s linear infinite',
                        'shine': 'shine 3s ease-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        },
                        blob: {
                            '0%': { transform: 'translate(0px, 0px) scale(1)' },
                            '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' },
                        },
                        marquee: {
                            '0%': { transform: 'translateX(0%)' },
                            '100%': { transform: 'translateX(-100%)' },
                        },
                        shine: {
                            '0%': { transform: 'translateX(-100%) skewX(-15deg)' },
                            '20%, 100%': { transform: 'translateX(200%) skewX(-15deg)' },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #10B981; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #059669; }
        .hide-scroll::-webkit-scrollbar { display: none; }

        .animated-border {
            position: relative;
            background: #0f172a;
            background-clip: padding-box;
            border: 2px solid transparent;
            border-radius: 1.5rem;
        }
        .animated-border::before {
            content: '';
            position: absolute;
            top: 0; right: 0; bottom: 0; left: 0;
            z-index: -1;
            margin: -2px;
            border-radius: inherit;
            background: conic-gradient(from 0deg, #10B981, #3b82f6, #10B981);
            animation: spin-slow 4s linear infinite;
        }

        .animate-bounce-slow { animation: bounce 3s infinite; }
        @keyframes bounce {
            0%, 100% { transform: translateY(-5%); animation-timing-function: cubic-bezier(0.8, 0, 1, 1); }
            50% { transform: none; animation-timing-function: cubic-bezier(0, 0, 0.2, 1); }
        }

        {{ $styles ?? '' }}
    </style>
</head>

<body class="bg-[#F8FAFC] text-slate-800 antialiased overflow-x-hidden selection:bg-accent selection:text-white">

    <x-navbar />

    {{-- ===== PAGE CONTENT ===== --}}
    {{ $slot }}

    {{-- ===== FOOTER ===== --}}
    <x-footer />

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, offset: 50, duration: 800, easing: 'ease-out-cubic' });

        // Mobile Menu Toggle
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        const icon = document.getElementById('menu-icon');
        let isMenuOpen = false;

        btn.addEventListener('click', () => {
            isMenuOpen = !isMenuOpen;
            if (isMenuOpen) {
                menu.classList.remove('hidden');
                setTimeout(() => {
                    menu.classList.remove('scale-y-0', 'opacity-0');
                    menu.classList.add('scale-y-100', 'opacity-100');
                    icon.classList.replace('ph-list', 'ph-x');
                }, 10);
            } else {
                menu.classList.remove('scale-y-100', 'opacity-100');
                menu.classList.add('scale-y-0', 'opacity-0');
                icon.classList.replace('ph-x', 'ph-list');
                setTimeout(() => { menu.classList.add('hidden'); }, 300);
            }
        });
    </script>

</body>
</html>
