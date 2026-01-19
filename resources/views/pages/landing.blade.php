<x-landing-layout>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 md:pt-40 md:pb-32 overflow-hidden grain-overlay">
        <!-- Background with more distinctive gradient -->
        <div class="absolute inset-0 bg-gradient-to-b from-violet-50 via-white to-white dark:from-gray-900 dark:via-gray-900 dark:to-gray-800 -z-10"></div>
        
        <!-- Decorative grid pattern -->
        <div class="absolute inset-0 -z-10 opacity-[0.015] dark:opacity-[0.03]" style="background-image: linear-gradient(rgba(132, 112, 255, 1) 1px, transparent 1px), linear-gradient(90deg, rgba(132, 112, 255, 1) 1px, transparent 1px); background-size: 60px 60px;"></div>
        
        <!-- Decorative shapes -->
        <div class="absolute top-32 -left-20 w-64 h-64 bg-gradient-to-br from-violet-400/20 to-sky-400/20 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-20 -right-20 w-80 h-80 bg-gradient-to-tl from-sky-400/20 to-violet-400/20 rounded-full blur-3xl animate-float" style="animation-delay: -3s;"></div>
        
        <!-- Decorative dots -->
        <div class="absolute top-40 right-20 hidden lg:grid grid-cols-6 gap-2 opacity-20">
            @for ($i = 0; $i < 24; $i++)
                <div class="w-1.5 h-1.5 rounded-full bg-violet-500"></div>
            @endfor
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 relative z-10">
            <div class="max-w-3xl mx-auto text-center">
                
                <!-- Badge with subtle animation -->
                <div class="animate-on-scroll inline-flex items-center gap-2 bg-white dark:bg-gray-800 text-violet-600 dark:text-violet-400 text-sm font-medium px-5 py-2 rounded-full mb-8 shadow-sm border border-violet-100 dark:border-violet-900/50">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-violet-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-violet-500"></span>
                    </span>
                    <span>Bientôt disponible</span>
                    <span class="text-violet-300 dark:text-violet-600">—</span>
                    <span class="text-gray-500 dark:text-gray-400">V1 Alpha en préparation</span>
                </div>

                <!-- Headline with distinctive serif font -->
                <h1 class="animate-on-scroll font-display text-4xl md:text-5xl lg:text-6xl font-semibold text-gray-900 dark:text-white mb-6 leading-tight" style="animation-delay: 0.1s;">
                    Transformez votre veille en 
                    <span class="relative">
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-violet-600 via-violet-500 to-sky-500 gradient-text-animated">contenu engageant</span>
                        <svg class="absolute -bottom-2 left-0 w-full" viewBox="0 0 300 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 8.5C50 2.5 100 2.5 150 5.5C200 8.5 250 8.5 298 2.5" stroke="url(#paint0_linear)" stroke-width="3" stroke-linecap="round"/>
                            <defs>
                                <linearGradient id="paint0_linear" x1="2" y1="5" x2="298" y2="5" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#8470FF"/>
                                    <stop offset="1" stop-color="#67BFFF"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </span>
                </h1>

                <!-- Subheadline -->
                <p class="animate-on-scroll text-lg md:text-xl text-gray-600 dark:text-gray-400 mb-10 max-w-2xl mx-auto leading-relaxed" style="animation-delay: 0.2s;">
                    Collectez vos meilleures trouvailles, créez des digests attractifs et partagez-les sur <strong class="text-gray-700 dark:text-gray-300">LinkedIn</strong>, <strong class="text-gray-700 dark:text-gray-300">X</strong> et par <strong class="text-gray-700 dark:text-gray-300">newsletter</strong> — en quelques clics.
                </p>

                <!-- CTA Buttons -->
                <div class="animate-on-scroll flex flex-col sm:flex-row items-center justify-center gap-4" style="animation-delay: 0.3s;">
                    <a href="{{ route('register') }}" class="group w-full sm:w-auto btn-glow bg-gray-900 dark:bg-white hover:bg-gray-800 dark:hover:bg-gray-100 text-white dark:text-gray-900 font-semibold px-8 py-4 rounded-xl shadow-xl shadow-gray-900/10 dark:shadow-white/10 transition-all duration-300">
                        <span class="flex items-center justify-center gap-2">
                            Rejoindre la beta gratuite
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </span>
                    </a>
                    <a href="#how-it-works" class="group w-full sm:w-auto text-gray-600 dark:text-gray-400 font-medium px-6 py-4 hover:text-violet-600 dark:hover:text-violet-400 transition-colors duration-300">
                        <span class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Voir comment ça marche
                        </span>
                    </a>
                </div>

                <!-- Social proof -->
                <div class="animate-on-scroll mt-12 flex flex-wrap items-center justify-center gap-6 text-sm text-gray-500 dark:text-gray-500" style="animation-delay: 0.4s;">
                    <div class="flex items-center gap-2 bg-white dark:bg-gray-800/50 px-4 py-2 rounded-full border border-gray-100 dark:border-gray-700">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Gratuit pour commencer</span>
                    </div>
                    <div class="flex items-center gap-2 bg-white dark:bg-gray-800/50 px-4 py-2 rounded-full border border-gray-100 dark:border-gray-700">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Sans carte bancaire</span>
                    </div>
                    <div class="flex items-center gap-2 bg-white dark:bg-gray-800/50 px-4 py-2 rounded-full border border-gray-100 dark:border-gray-700">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Setup en 2 min</span>
                    </div>
                </div>

            </div>

            <!-- Hero Mockup - More engaging illustration -->
            <div class="animate-on-scroll mt-16 md:mt-20 relative" style="animation-delay: 0.5s;">
                <!-- Browser window -->
                <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl shadow-gray-900/10 dark:shadow-black/30 border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <!-- Browser chrome -->
                    <div class="bg-gray-100 dark:bg-gray-900 px-4 py-3 flex items-center gap-3 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex gap-2">
                            <div class="w-3 h-3 rounded-full bg-red-400 hover:bg-red-500 transition-colors"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-400 hover:bg-yellow-500 transition-colors"></div>
                            <div class="w-3 h-3 rounded-full bg-green-400 hover:bg-green-500 transition-colors"></div>
                        </div>
                        <div class="flex-1 flex justify-center">
                            <div class="bg-white dark:bg-gray-800 px-4 py-1.5 rounded-lg text-xs text-gray-500 dark:text-gray-400 flex items-center gap-2 border border-gray-200 dark:border-gray-600">
                                <svg class="w-3 h-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span>app.paperboy.fr/digests</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- App content mockup -->
                    <div class="aspect-[16/10] bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 p-6 md:p-8">
                        <div class="h-full grid grid-cols-12 gap-4 md:gap-6">
                            <!-- Sidebar -->
                            <div class="col-span-3 hidden md:flex flex-col gap-4">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-8 h-8 bg-violet-500 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                        </svg>
                                    </div>
                                    <span class="font-semibold text-gray-800 dark:text-white text-sm">Paperboy</span>
                                </div>
                                <div class="space-y-1">
                                    <div class="bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300 px-3 py-2 rounded-lg text-xs font-medium">📰 Mes Digests</div>
                                    <div class="text-gray-500 dark:text-gray-400 px-3 py-2 text-xs">🔖 Bookmarks</div>
                                    <div class="text-gray-500 dark:text-gray-400 px-3 py-2 text-xs">📊 Analytics</div>
                                    <div class="text-gray-500 dark:text-gray-400 px-3 py-2 text-xs">⚙️ Paramètres</div>
                                </div>
                            </div>
                            
                            <!-- Main content -->
                            <div class="col-span-12 md:col-span-9 flex flex-col">
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <div class="bg-gray-200 dark:bg-gray-700 h-4 w-32 rounded animate-pulse"></div>
                                    </div>
                                    <div class="bg-violet-500 hover:bg-violet-600 text-white px-3 py-1.5 rounded-lg text-xs font-medium flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Nouveau digest
                                    </div>
                                </div>
                                
                                <!-- Digest cards grid -->
                                <div class="grid grid-cols-2 gap-3 md:gap-4 flex-1">
                                    <!-- Card 1 - Active -->
                                    <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow">
                                        <div class="flex items-start gap-3 mb-3">
                                            <div class="w-10 h-10 bg-gradient-to-br from-violet-500 to-sky-500 rounded-lg flex items-center justify-center text-white text-lg">📱</div>
                                            <div class="flex-1 min-w-0">
                                                <div class="font-medium text-gray-800 dark:text-white text-xs truncate">Tech Weekly #12</div>
                                                <div class="text-gray-400 text-[10px]">5 articles • Publié</div>
                                            </div>
                                        </div>
                                        <div class="flex gap-1.5 mb-3">
                                            <div class="w-8 h-8 bg-gray-100 dark:bg-gray-700 rounded"></div>
                                            <div class="w-8 h-8 bg-gray-100 dark:bg-gray-700 rounded"></div>
                                            <div class="w-8 h-8 bg-gray-100 dark:bg-gray-700 rounded"></div>
                                        </div>
                                        <div class="flex gap-1">
                                            <span class="text-[9px] px-1.5 py-0.5 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded">✓ Newsletter</span>
                                            <span class="text-[9px] px-1.5 py-0.5 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded">✓ LinkedIn</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Card 2 -->
                                    <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow">
                                        <div class="flex items-start gap-3 mb-3">
                                            <div class="w-10 h-10 bg-gradient-to-br from-amber-400 to-orange-500 rounded-lg flex items-center justify-center text-white text-lg">🎨</div>
                                            <div class="flex-1 min-w-0">
                                                <div class="font-medium text-gray-800 dark:text-white text-xs truncate">Design Trends</div>
                                                <div class="text-gray-400 text-[10px]">3 articles • Brouillon</div>
                                            </div>
                                        </div>
                                        <div class="flex gap-1.5 mb-3">
                                            <div class="w-8 h-8 bg-gray-100 dark:bg-gray-700 rounded"></div>
                                            <div class="w-8 h-8 bg-gray-100 dark:bg-gray-700 rounded"></div>
                                        </div>
                                        <div class="flex gap-1">
                                            <span class="text-[9px] px-1.5 py-0.5 bg-gray-100 dark:bg-gray-700 text-gray-500 rounded">Planifié 15 jan.</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Card 3 -->
                                    <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow hidden sm:block">
                                        <div class="flex items-start gap-3 mb-3">
                                            <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-lg flex items-center justify-center text-white text-lg">💡</div>
                                            <div class="flex-1 min-w-0">
                                                <div class="font-medium text-gray-800 dark:text-white text-xs truncate">Marketing Tips</div>
                                                <div class="text-gray-400 text-[10px]">8 articles • Publié</div>
                                            </div>
                                        </div>
                                        <div class="flex gap-1.5 mb-3">
                                            <div class="w-8 h-8 bg-gray-100 dark:bg-gray-700 rounded"></div>
                                            <div class="w-8 h-8 bg-gray-100 dark:bg-gray-700 rounded"></div>
                                            <div class="w-8 h-8 bg-gray-100 dark:bg-gray-700 rounded"></div>
                                            <div class="w-8 h-8 bg-gray-100 dark:bg-gray-700 rounded flex items-center justify-center text-[8px] text-gray-400">+5</div>
                                        </div>
                                        <div class="flex gap-1">
                                            <span class="text-[9px] px-1.5 py-0.5 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded">✓ Newsletter</span>
                                            <span class="text-[9px] px-1.5 py-0.5 bg-gray-100 dark:bg-gray-900/30 text-gray-600 dark:text-gray-400 rounded">✓ X</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Card 4 - Empty state -->
                                    <div class="border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-xl p-4 flex flex-col items-center justify-center text-center hover:border-violet-300 dark:hover:border-violet-700 transition-colors hidden sm:flex">
                                        <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-2">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                        </div>
                                        <span class="text-gray-400 text-[10px]">Créer un digest</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Floating elements around the browser -->
                <div class="absolute -top-4 -right-4 md:-right-8 bg-white dark:bg-gray-800 rounded-xl shadow-lg p-3 border border-gray-100 dark:border-gray-700 animate-float hidden lg:block" style="animation-delay: -1s;">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs font-medium text-gray-800 dark:text-white">Envoyé !</div>
                            <div class="text-[10px] text-gray-400">Newsletter • 247 contacts</div>
                        </div>
                    </div>
                </div>
                
                <div class="absolute -bottom-4 -left-4 md:-left-8 bg-white dark:bg-gray-800 rounded-xl shadow-lg p-3 border border-gray-100 dark:border-gray-700 animate-float hidden lg:block" style="animation-delay: -4s;">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs font-medium text-gray-800 dark:text-white">Publié !</div>
                            <div class="text-[10px] text-gray-400">LinkedIn • Il y a 2 min</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 md:py-32 bg-white dark:bg-gray-900">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            
            <!-- Section header -->
            <div class="animate-on-scroll max-w-3xl mx-auto text-center mb-16">
                <span class="inline-flex items-center gap-2 text-violet-600 dark:text-violet-400 text-sm font-semibold tracking-wide uppercase mb-4">
                    <span class="w-12 h-px bg-violet-500"></span>
                    Fonctionnalités
                    <span class="w-12 h-px bg-violet-500"></span>
                </span>
                <h2 class="font-display text-3xl md:text-4xl font-semibold text-gray-900 dark:text-white mb-4">
                    Tout ce dont vous avez besoin pour votre veille
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400">
                    De la collecte à la publication, Paperboy simplifie chaque étape de votre workflow de content curation.
                </p>
            </div>

            <!-- Features grid -->
            <div class="stagger-children grid md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Feature 1 -->
                <div class="card-hover group p-6 bg-gray-50 dark:bg-gray-800/50 rounded-2xl border border-gray-100 dark:border-gray-700/50">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-violet-500 to-violet-600 text-white rounded-xl mb-4 shadow-lg shadow-violet-500/20 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Collecte intelligente</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Sauvegardez vos liens en un clic avec notre extension navigateur. Titre, image et description extraits automatiquement.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="card-hover group p-6 bg-gray-50 dark:bg-gray-800/50 rounded-2xl border border-gray-100 dark:border-gray-700/50">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-sky-500 to-sky-600 text-white rounded-xl mb-4 shadow-lg shadow-sky-500/20 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Digest Builder</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Organisez vos liens en digests attractifs avec notre éditeur drag & drop. Ajoutez vos commentaires et analyses.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="card-hover group p-6 bg-gray-50 dark:bg-gray-800/50 rounded-2xl border border-gray-100 dark:border-gray-700/50">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 text-white rounded-xl mb-4 shadow-lg shadow-green-500/20 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Publication multi-canal</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Publiez sur LinkedIn, X et envoyez par newsletter depuis une seule interface. Planifiez vos publications.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="card-hover group p-6 bg-gray-50 dark:bg-gray-800/50 rounded-2xl border border-gray-100 dark:border-gray-700/50">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-amber-500 to-amber-600 text-white rounded-xl mb-4 shadow-lg shadow-amber-500/20 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Newsletter intégrée</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Envoyez vos digests par email avec Resend. Templates élégants, tracking des ouvertures et clics inclus.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="card-hover group p-6 bg-gray-50 dark:bg-gray-800/50 rounded-2xl border border-gray-100 dark:border-gray-700/50">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-rose-500 to-rose-600 text-white rounded-xl mb-4 shadow-lg shadow-rose-500/20 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">IA Snippets</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Génération automatique de résumés, hashtags et suggestions de contenu grâce à l'intelligence artificielle.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="card-hover group p-6 bg-gray-50 dark:bg-gray-800/50 rounded-2xl border border-gray-100 dark:border-gray-700/50">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-violet-500 to-violet-600 text-white rounded-xl mb-4 shadow-lg shadow-violet-500/20 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Analytics</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Suivez les performances de vos digests : vues, clics, engagement. Comprenez ce qui résonne avec votre audience.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- How it works Section -->
    <section id="how-it-works" class="py-20 md:py-32 bg-gray-50 dark:bg-gray-800/50 relative overflow-hidden">
        <!-- Decorative background -->
        <div class="absolute inset-0 -z-10 opacity-[0.02]" style="background-image: radial-gradient(circle at 2px 2px, currentColor 1px, transparent 0); background-size: 40px 40px;"></div>
        
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            
            <!-- Section header -->
            <div class="animate-on-scroll max-w-3xl mx-auto text-center mb-16">
                <span class="inline-flex items-center gap-2 text-violet-600 dark:text-violet-400 text-sm font-semibold tracking-wide uppercase mb-4">
                    <span class="w-12 h-px bg-violet-500"></span>
                    Comment ça marche
                    <span class="w-12 h-px bg-violet-500"></span>
                </span>
                <h2 class="font-display text-3xl md:text-4xl font-semibold text-gray-900 dark:text-white mb-4">
                    3 étapes pour devenir un thought leader
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400">
                    Un workflow simple pour transformer votre veille quotidienne en contenu qui vous positionne comme expert.
                </p>
            </div>

            <!-- Steps -->
            <div class="stagger-children grid md:grid-cols-3 gap-8 md:gap-6 relative">
                <!-- Connecting line -->
                <div class="hidden md:block absolute top-10 left-[16%] right-[16%] h-0.5 bg-gradient-to-r from-violet-500 via-sky-500 to-green-500 opacity-20"></div>

                <!-- Step 1 -->
                <div class="relative text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-violet-500 to-violet-600 text-white text-2xl font-display font-bold rounded-2xl mb-6 shadow-xl shadow-violet-500/20 relative z-10">
                        1
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Collectez</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Sauvegardez les articles, tweets et ressources qui vous inspirent au fil de vos lectures avec notre extension navigateur.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="relative text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-sky-500 to-sky-600 text-white text-2xl font-display font-bold rounded-2xl mb-6 shadow-xl shadow-sky-500/20 relative z-10">
                        2
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Organisez</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Créez des digests thématiques en organisant vos bookmarks. Ajoutez vos commentaires et points de vue personnels.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="relative text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 text-white text-2xl font-display font-bold rounded-2xl mb-6 shadow-xl shadow-green-500/20 relative z-10">
                        3
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Partagez</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Publiez votre digest sur LinkedIn, X et envoyez-le à vos abonnés newsletter en un clic. Planifiez pour plus tard.
                    </p>
                </div>

            </div>

        </div>
    </section>

    <!-- Use Cases Section -->
    <section class="py-20 md:py-32 bg-white dark:bg-gray-900">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            
            <!-- Section header -->
            <div class="animate-on-scroll max-w-3xl mx-auto text-center mb-16">
                <span class="inline-flex items-center gap-2 text-violet-600 dark:text-violet-400 text-sm font-semibold tracking-wide uppercase mb-4">
                    <span class="w-12 h-px bg-violet-500"></span>
                    Pour qui ?
                    <span class="w-12 h-px bg-violet-500"></span>
                </span>
                <h2 class="font-display text-3xl md:text-4xl font-semibold text-gray-900 dark:text-white mb-4">
                    Conçu pour les professionnels du marketing
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400">
                    Que vous soyez en PME ou freelance, Paperboy s'adapte à votre façon de travailler.
                </p>
            </div>

            <!-- Use cases grid -->
            <div class="stagger-children grid md:grid-cols-2 gap-6">

                <!-- Use case 1 -->
                <div class="card-hover flex gap-5 p-6 bg-gradient-to-br from-violet-50 to-violet-100/50 dark:from-violet-900/20 dark:to-violet-800/10 rounded-2xl border border-violet-200/50 dark:border-violet-800/30">
                    <div class="shrink-0">
                        <div class="w-14 h-14 bg-gradient-to-br from-violet-500 to-violet-600 rounded-xl flex items-center justify-center shadow-lg shadow-violet-500/20">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Marketing Managers</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Positionnez votre entreprise comme experte de son secteur avec des digests de veille réguliers qui engagent votre communauté.
                        </p>
                    </div>
                </div>

                <!-- Use case 2 -->
                <div class="card-hover flex gap-5 p-6 bg-gradient-to-br from-sky-50 to-sky-100/50 dark:from-sky-900/20 dark:to-sky-800/10 rounded-2xl border border-sky-200/50 dark:border-sky-800/30">
                    <div class="shrink-0">
                        <div class="w-14 h-14 bg-gradient-to-br from-sky-500 to-sky-600 rounded-xl flex items-center justify-center shadow-lg shadow-sky-500/20">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Content Creators</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Nourrissez votre audience avec du contenu curé de qualité et positionnez-vous comme la référence dans votre niche.
                        </p>
                    </div>
                </div>

                <!-- Use case 3 -->
                <div class="card-hover flex gap-5 p-6 bg-gradient-to-br from-green-50 to-green-100/50 dark:from-green-900/20 dark:to-green-800/10 rounded-2xl border border-green-200/50 dark:border-green-800/30">
                    <div class="shrink-0">
                        <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg shadow-green-500/20">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Consultants & Freelances</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Montrez votre expertise à vos clients et prospects en partageant régulièrement les tendances de votre secteur.
                        </p>
                    </div>
                </div>

                <!-- Use case 4 -->
                <div class="card-hover flex gap-5 p-6 bg-gradient-to-br from-amber-50 to-amber-100/50 dark:from-amber-900/20 dark:to-amber-800/10 rounded-2xl border border-amber-200/50 dark:border-amber-800/30">
                    <div class="shrink-0">
                        <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center shadow-lg shadow-amber-500/20">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Veilleurs & Analystes</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Structurez et partagez vos recherches avec votre équipe ou votre communauté de manière professionnelle.
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-20 md:py-32 bg-gray-50 dark:bg-gray-800/50 relative overflow-hidden">
        <!-- Decorative elements -->
        <div class="absolute top-0 left-1/4 w-64 h-64 bg-violet-200/30 dark:bg-violet-900/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 w-64 h-64 bg-sky-200/30 dark:bg-sky-900/10 rounded-full blur-3xl"></div>
        
        <div class="max-w-6xl mx-auto px-4 sm:px-6 relative z-10">
            
            <!-- Section header -->
            <div class="animate-on-scroll max-w-3xl mx-auto text-center mb-16">
                <span class="inline-flex items-center gap-2 text-violet-600 dark:text-violet-400 text-sm font-semibold tracking-wide uppercase mb-4">
                    <span class="w-12 h-px bg-violet-500"></span>
                    Tarifs
                    <span class="w-12 h-px bg-violet-500"></span>
                </span>
                <h2 class="font-display text-3xl md:text-4xl font-semibold text-gray-900 dark:text-white mb-4">
                    Simple et transparent
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400">
                    Commencez gratuitement et évoluez selon vos besoins. Pas de frais cachés.
                </p>
            </div>

            <!-- Pricing cards -->
            <div class="stagger-children grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-5xl mx-auto">

                <!-- Free tier -->
                <div class="card-hover bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-700 p-8">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Free</h3>
                        <div class="flex items-baseline gap-1">
                            <span class="font-display text-5xl font-semibold text-gray-900 dark:text-white">0€</span>
                            <span class="text-gray-500">/mois</span>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">Pour découvrir Paperboy</p>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            3 digests par mois
                        </li>
                        <li class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            50 bookmarks
                        </li>
                        <li class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Page publique
                        </li>
                        <li class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Stats basiques
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="block w-full text-center py-3 px-4 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 font-medium rounded-xl hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors duration-300">
                        Commencer gratuitement
                    </a>
                </div>

                <!-- Pro tier -->
                <div class="card-hover bg-white dark:bg-gray-900 rounded-2xl border-2 border-violet-500 p-8 relative shadow-xl shadow-violet-500/10">
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2">
                        <span class="bg-gradient-to-r from-violet-500 to-sky-500 text-white text-xs font-semibold px-4 py-1.5 rounded-full shadow-lg">Populaire</span>
                    </div>
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Pro</h3>
                        <div class="flex items-baseline gap-1">
                            <span class="font-display text-5xl font-semibold text-gray-900 dark:text-white">19€</span>
                            <span class="text-gray-500">/mois</span>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">Pour les créateurs actifs</p>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <strong class="text-gray-900 dark:text-white">Digests illimités</strong>
                        </li>
                        <li class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <strong class="text-gray-900 dark:text-white">Bookmarks illimités</strong>
                        </li>
                        <li class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Publication LinkedIn & X
                        </li>
                        <li class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Newsletter 500 contacts
                        </li>
                        <li class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            IA Snippets
                        </li>
                        <li class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Analytics avancés
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn-glow block w-full text-center py-3 px-4 bg-gradient-to-r from-violet-500 to-violet-600 text-white font-medium rounded-xl hover:from-violet-600 hover:to-violet-700 shadow-lg shadow-violet-500/25 transition-all duration-300">
                        Démarrer l'essai gratuit
                    </a>
                </div>

                <!-- Team tier -->
                <div class="card-hover bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-700 p-8">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Team</h3>
                        <div class="flex items-baseline gap-1">
                            <span class="font-display text-5xl font-semibold text-gray-900 dark:text-white">49€</span>
                            <span class="text-gray-500">/mois</span>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">Pour les équipes marketing</p>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Tout ce qui est dans Pro
                        </li>
                        <li class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            5 membres d'équipe
                        </li>
                        <li class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Newsletter 5000 contacts
                        </li>
                        <li class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Domaine personnalisé
                        </li>
                        <li class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Support prioritaire
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="block w-full text-center py-3 px-4 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 font-medium rounded-xl hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors duration-300">
                        Contacter l'équipe
                    </a>
                </div>

            </div>

        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 md:py-32 bg-gray-900 dark:bg-black relative overflow-hidden">
        <!-- Background pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 32px 32px;"></div>
        </div>
        
        <!-- Decorative gradient -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-gradient-to-r from-violet-600/20 to-sky-600/20 rounded-full blur-3xl"></div>
        
        <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center relative z-10">
            
            <div class="animate-on-scroll">
                <h2 class="font-display text-3xl md:text-5xl font-semibold text-white mb-6">
                    Prêt à transformer votre veille en contenu ?
                </h2>
                <p class="text-lg text-gray-400 mb-10 max-w-2xl mx-auto">
                    Rejoignez la beta gratuite de Paperboy et commencez à créer des digests qui engagent votre communauté.
                </p>
                
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('register') }}" class="group w-full sm:w-auto btn-glow bg-white text-gray-900 font-semibold px-8 py-4 rounded-xl hover:bg-gray-100 shadow-xl transition-all duration-300">
                        <span class="flex items-center justify-center gap-2">
                            Créer mon compte gratuit
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </span>
                    </a>
                    <a href="#features" class="w-full sm:w-auto text-gray-400 font-medium px-8 py-4 rounded-xl border border-gray-700 hover:border-gray-600 hover:text-white transition-all duration-300">
                        En savoir plus
                    </a>
                </div>

                <p class="text-sm text-gray-500 mt-8 flex items-center justify-center gap-4">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Pas de carte bancaire
                    </span>
                    <span class="text-gray-700">•</span>
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        2 min pour démarrer
                    </span>
                </p>
            </div>

        </div>
    </section>

</x-landing-layout>
