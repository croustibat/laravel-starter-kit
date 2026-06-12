@php
    $links = [
        [
            'label' => 'Atelier',
            'route' => 'dashboard',
            'active' => Request::segment(1) === 'dashboard',
            'badge' => null,
            'icon' => 'M5.936.278A7.983 7.983 0 0 1 8 0a8 8 0 1 1-8 8c0-.722.104-1.413.278-2.064a1 1 0 1 1 1.932.516A5.99 5.99 0 0 0 2 8a6 6 0 1 0 6-6c-.53 0-1.045.076-1.548.21A1 1 0 1 1 5.936.278Z M6.068 7.482A2.003 2.003 0 0 0 8 10a2 2 0 1 0-.518-3.932L3.707 2.293a1 1 0 0 0-1.414 1.414l3.775 3.775Z',
        ],
        [
            'label' => 'Sources',
            'route' => 'items.index',
            'active' => Request::segment(1) === 'items',
            'badge' => null,
            'icon' => 'M13.19 3.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m8.365-3.623 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244',
        ],
        [
            'label' => 'Briefs IA',
            'route' => 'briefs.index',
            'active' => Request::segment(1) === 'briefs',
            'badge' => 'Auto',
            'icon' => 'M8 0a1 1 0 0 1 1 1v1.07a6.003 6.003 0 0 1 4.93 4.93H15a1 1 0 1 1 0 2h-1.07A6.003 6.003 0 0 1 9 13.93V15a1 1 0 1 1-2 0v-1.07A6.003 6.003 0 0 1 2.07 9H1a1 1 0 0 1 0-2h1.07A6.003 6.003 0 0 1 7 2.07V1a1 1 0 0 1 1-1Zm0 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Z',
        ],
        [
            'label' => 'Digests',
            'route' => 'digests.index',
            'active' => Request::segment(1) === 'digests',
            'badge' => null,
            'icon' => 'M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm0 14H4V2h8v12ZM5 4h6v2H5V4Zm0 4h6v2H5V8Zm0 4h4v2H5v-2Z',
        ],
        [
            'label' => 'Tags',
            'route' => 'tags.index',
            'active' => Request::segment(1) === 'tags',
            'badge' => null,
            'icon' => 'M11.136 3.024a4 4 0 0 0-5.656 0L1.696 6.808a4 4 0 0 0 0 5.656l1.84 1.84a4 4 0 0 0 5.656 0l3.784-3.784a4 4 0 0 0 0-5.656l-1.84-1.84Zm-5.084 5.67a1 1 0 1 1 1.414 1.414 1 1 0 0 1-1.414-1.414Z',
        ],
        [
            'label' => 'Réglages',
            'route' => 'account',
            'active' => Request::segment(1) === 'settings',
            'badge' => null,
            'icon' => 'M10.5 1a3.502 3.502 0 0 1 3.355 2.5H15a1 1 0 1 1 0 2h-1.145a3.502 3.502 0 0 1-6.71 0H1a1 1 0 0 1 0-2h6.145A3.502 3.502 0 0 1 10.5 1ZM5.5 9a3.502 3.502 0 0 1 3.355 2.5H15a1 1 0 1 1 0 2H8.855a3.502 3.502 0 0 1-6.71 0H1a1 1 0 1 1 0-2h1.145A3.502 3.502 0 0 1 5.5 9Z',
        ],
    ];
@endphp

<div class="min-w-fit">
    <div
        class="fixed inset-0 bg-gray-900/30 z-40 lg:hidden lg:z-auto transition-opacity duration-200"
        :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'"
        aria-hidden="true"
        x-cloak
    ></div>

    <div
        id="sidebar"
        class="flex lg:flex! flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 h-[100dvh] overflow-y-scroll lg:overflow-y-auto no-scrollbar w-72 lg:w-20 lg:sidebar-expanded:!w-72 2xl:w-72! shrink-0 bg-white dark:bg-gray-800 p-4 transition-all duration-200 ease-in-out {{ $variant === 'v2' ? 'border-r border-gray-200 dark:border-gray-700/60' : 'rounded-r-2xl shadow-xs' }}"
        :class="sidebarOpen ? 'max-lg:translate-x-0' : 'max-lg:-translate-x-72'"
        @click.outside="sidebarOpen = false"
        @keydown.escape.window="sidebarOpen = false"
    >
        <div class="flex justify-between mb-10 pr-3 sm:px-2">
            <button class="lg:hidden text-gray-500 hover:text-gray-400" @click.stop="sidebarOpen = !sidebarOpen" aria-controls="sidebar" :aria-expanded="sidebarOpen">
                <span class="sr-only">Close sidebar</span>
                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z" />
                </svg>
            </button>

            <a class="flex items-center gap-3 overflow-hidden" href="{{ route('dashboard') }}" aria-label="Paperboy">
                <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-violet-500 text-white shadow-sm">
                    <svg class="h-5 w-5 fill-current" viewBox="0 0 16 16">
                        <path d="M14.692 1.308a1 1 0 0 1 .24 1.047l-4.8 12a1 1 0 0 1-1.883-.057L6.71 9.29 1.702 7.75a1 1 0 0 1-.057-1.883l12-4.8a1 1 0 0 1 1.047.24ZM4.9 6.68l2.703.832a1 1 0 0 1 .663.663L9.1 10.88l2.96-7.4-7.16 3.2Z" />
                    </svg>
                </span>
                <span class="min-w-0 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                    <span class="block text-lg font-bold text-gray-900 dark:text-gray-100 leading-none">Paperboy</span>
                    <span class="block text-xs uppercase tracking-[0.18em] text-gray-400 mt-1">Atelier éditorial</span>
                </span>
            </a>
        </div>

        <a href="{{ route('items.create') }}" class="mb-6 flex items-center justify-between gap-3 rounded-xl bg-gray-900 px-4 py-3 text-sm font-semibold text-white hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-900 dark:hover:bg-white">
            <span class="flex items-center gap-3">
                <svg class="h-4 w-4 fill-current shrink-0" viewBox="0 0 16 16">
                    <path d="M13.19 3.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m8.365-3.623 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                </svg>
                <span class="lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Capturer</span>
            </span>
            <span class="hidden rounded bg-white/15 px-1.5 py-0.5 text-xs lg:sidebar-expanded:inline 2xl:inline">C</span>
        </a>

        <div>
            <h3 class="text-xs uppercase text-gray-400 dark:text-gray-500 font-semibold pl-3">
                <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6" aria-hidden="true">•••</span>
                <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">Paperboy</span>
            </h3>

            <ul class="mt-3 space-y-0.5">
                @foreach($links as $link)
                    <li class="pl-4 pr-3 py-2 rounded-lg bg-linear-to-r @if($link['active']){{ 'from-violet-500/[0.12] dark:from-violet-500/[0.24] to-violet-500/[0.04]' }}@endif">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition @if(! $link['active']){{ 'hover:text-gray-900 dark:hover:text-white' }}@endif" href="{{ route($link['route']) }}">
                            <div class="flex items-center min-w-0">
                                <svg class="shrink-0 @if($link['active']){{ 'text-violet-500' }}@else{{ 'text-gray-400 dark:text-gray-500' }}@endif" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                    <path d="{{ $link['icon'] }}" />
                                </svg>
                                <span class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">{{ $link['label'] }}</span>
                                @if($link['badge'])
                                    <span class="ml-auto text-[10px] font-semibold uppercase tracking-wide rounded-full bg-violet-100 text-violet-700 dark:bg-violet-900/50 dark:text-violet-300 px-2 py-0.5 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">{{ $link['badge'] }}</span>
                                @endif
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="mt-auto pt-8">
            <form method="POST" action="{{ route('logout') }}" x-data>
                @csrf
                <button type="submit" class="w-full pl-4 pr-3 py-2 rounded-lg text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-100 transition">
                    <span class="flex items-center">
                        <svg class="shrink-0 fill-current" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <path d="M6 2a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H7a1 1 0 1 1 0-2h6V3H7a1 1 0 0 1-1-1ZM5.707 5.293a1 1 0 0 1 0 1.414L4.414 8l1.293 1.293a1 1 0 0 1-1.414 1.414l-3-3a1 1 0 0 1 0-1.414l3-3a1 1 0 1 1 1.414 1.414ZM2 7h6a1 1 0 1 1 0 2H2V7Z" />
                        </svg>
                        <span class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Déconnexion</span>
                    </span>
                </button>
            </form>

            <div class="pt-3 hidden lg:inline-flex 2xl:hidden justify-end w-full">
                <div class="w-12 pl-4 pr-3 py-2">
                    <button class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400 transition-colors" @click="sidebarExpanded = !sidebarExpanded">
                        <span class="sr-only">Expand / collapse sidebar</span>
                        <svg class="shrink-0 fill-current text-gray-400 dark:text-gray-500 sidebar-expanded:rotate-180" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <path d="M15 16a1 1 0 0 1-1-1V1a1 1 0 1 1 2 0v14a1 1 0 0 1-1 1ZM8.586 7H1a1 1 0 1 0 0 2h7.586l-2.793 2.793a1 1 0 1 0 1.414 1.414l4.5-4.5A.997.997 0 0 0 12 8.01M11.924 7.617a.997.997 0 0 0-.217-.324l-4.5-4.5a1 1 0 0 0-1.414 1.414L8.586 7M12 7.99a.996.996 0 0 0-.076-.373Z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
