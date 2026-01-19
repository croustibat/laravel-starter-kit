<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Paperboy - Créez et partagez vos digests de veille' }}</title>
        <meta name="description" content="{{ $description ?? 'Paperboy vous aide à collecter, organiser et partager votre veille sous forme de digests attractifs sur LinkedIn, X et par newsletter.' }}">

        <!-- Open Graph -->
        <meta property="og:title" content="{{ $title ?? 'Paperboy - Créez et partagez vos digests de veille' }}">
        <meta property="og:description" content="{{ $description ?? 'Paperboy vous aide à collecter, organiser et partager votre veille sous forme de digests attractifs.' }}">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">

        <!-- Fonts - Distinctive typography pairing -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400..700;1,9..40,400..700&family=Fraunces:ital,opsz,wght@0,9..144,400..700;1,9..144,400..700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles        

        <script>
            if (localStorage.getItem('dark-mode') === 'false' || !('dark-mode' in localStorage)) {
                document.querySelector('html').classList.remove('dark');
                document.querySelector('html').style.colorScheme = 'light';
            } else {
                document.querySelector('html').classList.add('dark');
                document.querySelector('html').style.colorScheme = 'dark';
            }
        </script>         
    </head>
    <body class="antialiased bg-white dark:bg-gray-900 text-gray-600 dark:text-gray-400" style="font-family: 'DM Sans', sans-serif;">

        <style>
            /* Display font for headlines */
            .font-display {
                font-family: 'Fraunces', Georgia, serif;
                font-optical-sizing: auto;
            }
            
            /* Smooth scroll */
            html {
                scroll-behavior: smooth;
            }
            
            /* Scroll animations */
            .animate-on-scroll {
                opacity: 0;
                transform: translateY(30px);
                transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            }
            
            .animate-on-scroll.is-visible {
                opacity: 1;
                transform: translateY(0);
            }
            
            /* Staggered children animation */
            .stagger-children > * {
                opacity: 0;
                transform: translateY(20px);
                transition: opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1), transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
            }
            
            .stagger-children.is-visible > *:nth-child(1) { transition-delay: 0.1s; }
            .stagger-children.is-visible > *:nth-child(2) { transition-delay: 0.2s; }
            .stagger-children.is-visible > *:nth-child(3) { transition-delay: 0.3s; }
            .stagger-children.is-visible > *:nth-child(4) { transition-delay: 0.4s; }
            .stagger-children.is-visible > *:nth-child(5) { transition-delay: 0.5s; }
            .stagger-children.is-visible > *:nth-child(6) { transition-delay: 0.6s; }
            
            .stagger-children.is-visible > * {
                opacity: 1;
                transform: translateY(0);
            }
            
            /* Enhanced hover effects */
            .card-hover {
                transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            }
            
            .card-hover:hover {
                transform: translateY(-4px);
                box-shadow: 0 20px 40px -12px rgba(132, 112, 255, 0.15);
            }
            
            /* Gradient text animation */
            .gradient-text-animated {
                background-size: 200% auto;
                animation: gradient-shift 4s ease infinite;
            }
            
            @keyframes gradient-shift {
                0%, 100% { background-position: 0% center; }
                50% { background-position: 100% center; }
            }
            
            /* Floating animation */
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-10px); }
            }
            
            .animate-float {
                animation: float 6s ease-in-out infinite;
            }
            
            /* Grain overlay */
            .grain-overlay::before {
                content: '';
                position: absolute;
                inset: 0;
                background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
                opacity: 0.03;
                pointer-events: none;
                z-index: 1;
            }
            
            /* Button hover glow */
            .btn-glow {
                position: relative;
                overflow: hidden;
            }
            
            .btn-glow::before {
                content: '';
                position: absolute;
                inset: 0;
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
                transform: translateX(-100%);
                transition: transform 0.6s ease;
            }
            
            .btn-glow:hover::before {
                transform: translateX(100%);
            }
        </style>

        <!-- Header -->
        <header class="fixed w-full z-30 bg-white/90 dark:bg-gray-900/90 backdrop-blur-sm border-b border-gray-200 dark:border-gray-700/60">
            <div class="max-w-6xl mx-auto px-4 sm:px-6">
                <div class="flex items-center justify-between h-16 md:h-20">
                    
                    <!-- Logo -->
                    <a class="flex items-center gap-2" href="{{ url('/') }}">
                        <svg class="fill-violet-500" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
                            <path d="M31.956 14.8C31.372 6.92 25.08.628 17.2.044V5.76a9.04 9.04 0 0 0 9.04 9.04h5.716ZM14.8 26.24v5.716C6.92 31.372.63 25.08.044 17.2H5.76a9.04 9.04 0 0 1 9.04 9.04Zm11.44-9.04h5.716c-.584 7.88-6.876 14.172-14.756 14.756V26.24a9.04 9.04 0 0 1 9.04-9.04ZM.044 14.8C.63 6.92 6.92.628 14.8.044V5.76a9.04 9.04 0 0 1-9.04 9.04H.044Z" />
                        </svg>
                        <span class="text-xl font-bold text-gray-800 dark:text-gray-100">Paperboy</span>
                    </a>

                    <!-- Navigation -->
                    <nav class="hidden md:flex items-center gap-6">
                        <a href="#features" class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100 transition">Fonctionnalités</a>
                        <a href="#how-it-works" class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100 transition">Comment ça marche</a>
                        <a href="#pricing" class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100 transition">Tarifs</a>
                    </nav>

                    <!-- CTA -->
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100 transition">Connexion</a>
                        <a href="{{ route('register') }}" class="btn bg-violet-500 hover:bg-violet-600 text-white text-sm px-4 py-2 rounded-lg transition">
                            Commencer gratuitement
                        </a>
                    </div>

                </div>
            </div>
        </header>

        <!-- Main content -->
        <main>
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700/60">
            <div class="max-w-6xl mx-auto px-4 sm:px-6">
                <div class="py-8 md:py-12">
                    <div class="grid md:grid-cols-4 gap-8">
                        
                        <!-- Logo & Description -->
                        <div class="md:col-span-2">
                            <a class="flex items-center gap-2 mb-4" href="{{ url('/') }}">
                                <svg class="fill-violet-500" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 32 32">
                                    <path d="M31.956 14.8C31.372 6.92 25.08.628 17.2.044V5.76a9.04 9.04 0 0 0 9.04 9.04h5.716ZM14.8 26.24v5.716C6.92 31.372.63 25.08.044 17.2H5.76a9.04 9.04 0 0 1 9.04 9.04Zm11.44-9.04h5.716c-.584 7.88-6.876 14.172-14.756 14.756V26.24a9.04 9.04 0 0 1 9.04-9.04ZM.044 14.8C.63 6.92 6.92.628 14.8.044V5.76a9.04 9.04 0 0 1-9.04 9.04H.044Z" />
                                </svg>
                                <span class="text-lg font-bold text-gray-800 dark:text-gray-100">Paperboy</span>
                            </a>
                            <p class="text-sm text-gray-600 dark:text-gray-400 max-w-sm">
                                Créez et partagez vos digests de veille facilement. Publiez sur LinkedIn, X et envoyez des newsletters en quelques clics.
                            </p>
                        </div>

                        <!-- Links -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-100 mb-3">Produit</h4>
                            <ul class="space-y-2">
                                <li><a href="#features" class="text-sm text-gray-600 hover:text-violet-500 dark:text-gray-400 dark:hover:text-violet-400 transition">Fonctionnalités</a></li>
                                <li><a href="#pricing" class="text-sm text-gray-600 hover:text-violet-500 dark:text-gray-400 dark:hover:text-violet-400 transition">Tarifs</a></li>
                                <li><a href="#" class="text-sm text-gray-600 hover:text-violet-500 dark:text-gray-400 dark:hover:text-violet-400 transition">Roadmap</a></li>
                            </ul>
                        </div>

                        <!-- Links -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-100 mb-3">Ressources</h4>
                            <ul class="space-y-2">
                                <li><a href="#" class="text-sm text-gray-600 hover:text-violet-500 dark:text-gray-400 dark:hover:text-violet-400 transition">Documentation</a></li>
                                <li><a href="#" class="text-sm text-gray-600 hover:text-violet-500 dark:text-gray-400 dark:hover:text-violet-400 transition">Blog</a></li>
                                <li><a href="#" class="text-sm text-gray-600 hover:text-violet-500 dark:text-gray-400 dark:hover:text-violet-400 transition">Contact</a></li>
                            </ul>
                        </div>

                    </div>

                    <!-- Bottom -->
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between pt-8 mt-8 border-t border-gray-200 dark:border-gray-700/60">
                        <p class="text-sm text-gray-500 dark:text-gray-500">
                            © {{ date('Y') }} Paperboy. Tous droits réservés.
                        </p>
                        <div class="flex items-center gap-4 mt-4 md:mt-0">
                            <a href="#" class="text-gray-400 hover:text-violet-500 transition">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-violet-500 transition">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                            <a href="https://github.com/ultraviolettes/paperboy" target="_blank" class="text-gray-400 hover:text-violet-500 transition">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        @livewireScriptConfig

        <script>
            // Intersection Observer for scroll animations
            document.addEventListener('DOMContentLoaded', function() {
                const observerOptions = {
                    root: null,
                    rootMargin: '0px',
                    threshold: 0.1
                };

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-visible');
                        }
                    });
                }, observerOptions);

                // Observe all elements with animation classes
                document.querySelectorAll('.animate-on-scroll, .stagger-children').forEach(el => {
                    observer.observe(el);
                });
            });
        </script>
    </body>
</html>
