<div class="flex flex-nowrap overflow-x-scroll no-scrollbar md:block md:overflow-auto px-3 py-6 border-b md:border-b-0 md:border-r border-gray-200 dark:border-gray-700/60 min-w-60 md:space-y-3">
    <!-- Group 1 -->
    <div>
        <div class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase mb-3">Business settings</div>
        <ul class="flex flex-nowrap md:block mr-3 md:mr-0">
            <li class="mr-0.5 md:mr-0 md:mb-0.5">
                <a class="flex items-center px-2.5 py-2 rounded-lg whitespace-nowrap {{ Route::is('account') ? 'bg-violet-50 dark:bg-violet-500/30' : 'hover:bg-gray-50 dark:hover:bg-gray-800/20' }}" href="{{ route('account') }}">
                    <svg class="shrink-0 fill-current mr-2 {{ Route::is('account') ? 'text-violet-500' : 'text-gray-400 dark:text-gray-500' }}" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8Zm0 12c-2.2 0-4-1.8-4-4s1.8-4 4-4 4 1.8 4 4-1.8 4-4 4Z" />
                    </svg>
                    <span class="text-sm font-medium {{ Route::is('account') ? 'text-violet-500' : 'text-gray-600 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-200' }}">My Account</span>
                </a>
            </li>
            <li class="mr-0.5 md:mr-0 md:mb-0.5">
                <a class="flex items-center px-2.5 py-2 rounded-lg whitespace-nowrap {{ Route::is('notifications') ? 'bg-violet-50 dark:bg-violet-500/30' : 'hover:bg-gray-50 dark:hover:bg-gray-800/20' }}" href="{{ route('notifications') }}">
                    <svg class="shrink-0 fill-current mr-2 {{ Route::is('notifications') ? 'text-violet-500' : 'text-gray-400 dark:text-gray-500' }}" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M14.3.3c.4-.4 1-.4 1.4 0 .4.4.4 1 0 1.4l-8 8c-.2.2-.4.3-.7.3-.3 0-.5-.1-.7-.3-.4-.4-.4-1 0-1.4l8-8ZM15 7c.6 0 1 .4 1 1 0 4.4-3.6 8-8 8s-8-3.6-8-8 3.6-8 8-8c.6 0 1 .4 1 1s-.4 1-1 1C4.7 2 2 4.7 2 8s2.7 6 6 6 6-2.7 6-6c0-.6.4-1 1-1Z" />
                    </svg>
                    <span class="text-sm font-medium {{ Route::is('notifications') ? 'text-violet-500' : 'text-gray-600 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-200' }}">My Notifications</span>
                </a>
            </li>
            <li class="mr-0.5 md:mr-0 md:mb-0.5">
                <a class="flex items-center px-2.5 py-2 rounded-lg whitespace-nowrap {{ Route::is('apps') ? 'bg-violet-50 dark:bg-violet-500/30' : 'hover:bg-gray-50 dark:hover:bg-gray-800/20' }}" href="{{ route('apps') }}">
                    <svg class="shrink-0 fill-current mr-2 {{ Route::is('apps') ? 'text-violet-500' : 'text-gray-400 dark:text-gray-500' }}" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M3.414 2 9 7.586V16H7V8.414l-5-5V6H0V1a1 1 0 0 1 1-1h5v2H3.414ZM15 0H9v2h3.586l-3.293 3.293 1.414 1.414L14 3.414V7h2V1a1 1 0 0 0-1-1Z" />
                    </svg>
                    <span class="text-sm font-medium {{ Route::is('apps') ? 'text-violet-500' : 'text-gray-600 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-200' }}">Connected Apps</span>
                </a>
            </li>
            <li class="mr-0.5 md:mr-0 md:mb-0.5">
                <a class="flex items-center px-2.5 py-2 rounded-lg whitespace-nowrap {{ Route::is('plans') ? 'bg-violet-50 dark:bg-violet-500/30' : 'hover:bg-gray-50 dark:hover:bg-gray-800/20' }}" href="{{ route('plans') }}">
                    <svg class="shrink-0 fill-current mr-2 {{ Route::is('plans') ? 'text-violet-500' : 'text-gray-400 dark:text-gray-500' }}" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M5 9a1 1 0 1 1 0-2h6a1 1 0 1 1 0 2H5ZM1 4a1 1 0 0 1 1-1h12a1 1 0 1 1 0 2H2a1 1 0 0 1-1-1ZM3 12a1 1 0 0 1 1-1h8a1 1 0 1 1 0 2H4a1 1 0 0 1-1-1Z" />
                    </svg>
                    <span class="text-sm font-medium {{ Route::is('plans') ? 'text-violet-500' : 'text-gray-600 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-200' }}">Plans</span>
                </a>
            </li>
            <li class="mr-0.5 md:mr-0 md:mb-0.5">
                <a class="flex items-center px-2.5 py-2 rounded-lg whitespace-nowrap {{ Route::is('billing') ? 'bg-violet-50 dark:bg-violet-500/30' : 'hover:bg-gray-50 dark:hover:bg-gray-800/20' }}" href="{{ route('billing') }}">
                    <svg class="shrink-0 fill-current mr-2 {{ Route::is('billing') ? 'text-violet-500' : 'text-gray-400 dark:text-gray-500' }}" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M0 3a3 3 0 0 1 3-3h10a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3H3a3 3 0 0 1-3-3V3Zm10.5 3.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3ZM13 10a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v1H7v-1a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-2h-.5v-1H13v1ZM5.5 6.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" />
                    </svg>
                    <span class="text-sm font-medium {{ Route::is('billing') ? 'text-violet-500' : 'text-gray-600 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-200' }}">Billing & Invoices</span>
                </a>
            </li>
        </ul>
    </div>
    <!-- Group 2 -->
    <div>
        <div class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase mb-3">Experience</div>
        <ul class="flex flex-nowrap md:block mr-3 md:mr-0">
            <li class="mr-0.5 md:mr-0 md:mb-0.5">
                <a class="flex items-center px-2.5 py-2 rounded-lg whitespace-nowrap {{ Route::is('feedback') ? 'bg-violet-50 dark:bg-violet-500/30' : 'hover:bg-gray-50 dark:hover:bg-gray-800/20' }}" href="{{ route('feedback') }}">
                    <svg class="shrink-0 fill-current mr-2 {{ Route::is('feedback') ? 'text-violet-500' : 'text-gray-400 dark:text-gray-500' }}" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M14.5 2h-13C.67 2 0 2.67 0 3.5v9c0 .83.67 1.5 1.5 1.5h13c.83 0 1.5-.67 1.5-1.5v-9c0-.83-.67-1.5-1.5-1.5ZM14 12H2V4h12v8Z" />
                    </svg>
                    <span class="text-sm font-medium {{ Route::is('feedback') ? 'text-violet-500' : 'text-gray-600 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-200' }}">Give Feedback</span>
                </a>
            </li>
        </ul>
    </div>
</div>
