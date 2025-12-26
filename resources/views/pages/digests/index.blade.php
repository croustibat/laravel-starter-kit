<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-[96rem] mx-auto">

        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">My Digests</h1>
            </div>

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                <a href="{{ route('digests.create') }}" class="btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white">
                    <svg class="fill-current shrink-0 xs:hidden" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                    <span class="max-xs:sr-only">New Digest</span>
                </a>
            </div>

        </div>

        <!-- Success message -->
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg">
                <p class="text-sm text-green-600 dark:text-green-400">{{ session('success') }}</p>
            </div>
        @endif

        @if($digests->isEmpty())
            <!-- Empty state -->
            <div class="max-w-2xl m-auto mt-16">
                <div class="text-center px-4">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-t from-gray-200 to-gray-100 dark:from-gray-700 dark:to-gray-800 mb-4">
                        <svg class="w-6 h-6 fill-current text-gray-400" viewBox="0 0 24 24">
                            <path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl text-gray-800 dark:text-gray-100 font-bold mb-2">No digests yet</h2>
                    <div class="mb-6 text-gray-500 dark:text-gray-400">Create your first digest to start curating content for your audience.</div>
                    <a href="{{ route('digests.create') }}" class="btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white">
                        Create Your First Digest
                    </a>
                </div>
            </div>
        @else
            <!-- Digests grid -->
            <div class="grid grid-cols-12 gap-6">
                @foreach($digests as $digest)
                    <div class="col-span-full sm:col-span-6 xl:col-span-4 bg-white dark:bg-gray-800 shadow-xs rounded-xl">
                        <div class="flex flex-col h-full p-5">
                            <header>
                                <div class="flex items-center justify-between">
                                    <!-- Status badge -->
                                    @if($digest->status === 'published')
                                        <div class="text-xs inline-flex font-medium bg-green-500/20 text-green-700 rounded-full text-center px-2.5 py-1">Published</div>
                                    @else
                                        <div class="text-xs inline-flex font-medium bg-gray-500/20 text-gray-600 dark:text-gray-400 rounded-full text-center px-2.5 py-1">Draft</div>
                                    @endif
                                    <!-- Menu button -->
                                    <div class="relative inline-flex" x-data="{ open: false }">
                                        <button class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400 rounded-full" :class="{ 'bg-gray-100 dark:bg-gray-700/60 text-gray-500 dark:text-gray-400': open }" aria-haspopup="true" @click.prevent="open = !open" :aria-expanded="open">
                                            <span class="sr-only">Menu</span>
                                            <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                                <circle cx="16" cy="16" r="2" />
                                                <circle cx="10" cy="16" r="2" />
                                                <circle cx="22" cy="16" r="2" />
                                            </svg>
                                        </button>
                                        <div class="origin-top-right z-10 absolute top-full right-0 min-w-36 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 py-1.5 rounded-lg shadow-lg overflow-hidden mt-1" @click.outside="open = false" @keydown.escape.window="open = false" x-show="open" x-transition:enter="transition ease-out duration-200 transform" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-out duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak>
                                            <ul>
                                                <li>
                                                    <a class="font-medium text-sm text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-200 flex py-1 px-3" href="{{ route('digests.edit', $digest) }}" @click="open = false" @focus="open = true" @focusout="open = false">Edit</a>
                                                </li>
                                                @if($digest->status === 'published')
                                                <li>
                                                    <a class="font-medium text-sm text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-200 flex py-1 px-3" href="{{ route('digests.show', $digest) }}" @click="open = false" @focus="open = true" @focusout="open = false">View</a>
                                                </li>
                                                @endif
                                                <li>
                                                    <form method="POST" action="{{ route('digests.destroy', $digest) }}" onsubmit="return confirm('Are you sure you want to delete this digest?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="font-medium text-sm text-red-500 hover:text-red-600 flex py-1 px-3 w-full text-left" @click="open = false">Delete</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </header>
                            <div class="grow mt-2">
                                <a class="inline-flex text-gray-800 dark:text-gray-100 hover:text-gray-900 dark:hover:text-white mb-1" href="{{ route('digests.edit', $digest) }}">
                                    <h2 class="text-xl leading-snug font-semibold">{{ $digest->title }}</h2>
                                </a>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $digest->items->count() }} items</div>
                            </div>
                            <footer class="mt-5">
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    @if($digest->published_at)
                                        Published {{ $digest->published_at->diffForHumans() }}
                                    @else
                                        Created {{ $digest->created_at->diffForHumans() }}
                                    @endif
                                </div>
                            </footer>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</x-app-layout>
