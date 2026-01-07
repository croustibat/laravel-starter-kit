<div class="grow">
    <!-- Panel body -->
    <div class="p-6 space-y-6">
        <h2 class="text-2xl text-gray-800 dark:text-gray-100 font-bold mb-5">Give Feedback</h2>
        <!-- Feedback Form -->
        <section>
            <h3 class="text-xl leading-snug text-gray-800 dark:text-gray-100 font-bold mb-1">We'd love to hear from you</h3>
            <div class="text-sm">Your feedback helps us improve our product and services.</div>
            <div class="mt-5">
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1" for="feedback-type">Feedback Type</label>
                    <select id="feedback-type" class="form-select w-full">
                        <option>Select a type</option>
                        <option>Bug Report</option>
                        <option>Feature Request</option>
                        <option>General Feedback</option>
                        <option>Other</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1" for="feedback-subject">Subject</label>
                    <input id="feedback-subject" class="form-input w-full" type="text" placeholder="Brief description of your feedback" />
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1" for="feedback-message">Message</label>
                    <textarea id="feedback-message" class="form-textarea w-full" rows="5" placeholder="Tell us more about your experience..."></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">How would you rate your experience?</label>
                    <div class="flex items-center space-x-2">
                        @for ($i = 1; $i <= 5; $i++)
                        <button type="button" class="text-gray-300 hover:text-yellow-400 focus:text-yellow-400">
                            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>
                        </button>
                        @endfor
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- Panel footer -->
    <footer>
        <div class="flex flex-col px-6 py-5 border-t border-gray-200 dark:border-gray-700/60">
            <div class="flex self-end">
                <button class="btn dark:bg-gray-800 border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-gray-800 dark:text-gray-300">Cancel</button>
                <button class="btn bg-violet-500 hover:bg-violet-600 text-white ml-3">Submit Feedback</button>
            </div>
        </div>
    </footer>
</div>
