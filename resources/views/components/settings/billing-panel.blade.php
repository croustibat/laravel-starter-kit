<div class="grow">
    <!-- Panel body -->
    <div class="p-6 space-y-6">
        <h2 class="text-2xl text-gray-800 dark:text-gray-100 font-bold mb-5">Billing & Invoices</h2>
        <!-- Billing Info -->
        <section>
            <h3 class="text-xl leading-snug text-gray-800 dark:text-gray-100 font-bold mb-1">Billing Information</h3>
            <div class="text-sm">Update your billing details and address.</div>
            <div class="sm:flex sm:items-center space-y-4 sm:space-y-0 sm:space-x-4 mt-5">
                <div class="sm:w-1/2">
                    <label class="block text-sm font-medium mb-1" for="card">Card Number</label>
                    <input id="card" class="form-input w-full" type="text" placeholder="**** **** **** 4242" />
                </div>
                <div class="sm:w-1/4">
                    <label class="block text-sm font-medium mb-1" for="expiry">Expiry</label>
                    <input id="expiry" class="form-input w-full" type="text" placeholder="MM/YY" />
                </div>
                <div class="sm:w-1/4">
                    <label class="block text-sm font-medium mb-1" for="cvc">CVC</label>
                    <input id="cvc" class="form-input w-full" type="text" placeholder="***" />
                </div>
            </div>
            <div class="mt-5">
                <button class="btn bg-violet-500 hover:bg-violet-600 text-white">Update Card</button>
            </div>
        </section>
        <!-- Invoices -->
        <section>
            <h3 class="text-xl leading-snug text-gray-800 dark:text-gray-100 font-bold mb-1">Invoices</h3>
            <div class="text-sm mb-5">View and download your past invoices.</div>
            <!-- Invoices Table -->
            <div class="overflow-x-auto">
                <table class="table-auto w-full">
                    <thead class="text-xs uppercase text-gray-400 dark:text-gray-500 bg-gray-50 dark:bg-gray-700 dark:bg-opacity-50 rounded-sm">
                        <tr>
                            <th class="p-2 whitespace-nowrap">
                                <div class="font-semibold text-left">Invoice</div>
                            </th>
                            <th class="p-2 whitespace-nowrap">
                                <div class="font-semibold text-left">Date</div>
                            </th>
                            <th class="p-2 whitespace-nowrap">
                                <div class="font-semibold text-left">Amount</div>
                            </th>
                            <th class="p-2 whitespace-nowrap">
                                <div class="font-semibold text-left">Status</div>
                            </th>
                            <th class="p-2 whitespace-nowrap">
                                <div class="font-semibold text-right">Action</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700/60">
                        <tr>
                            <td class="p-2 whitespace-nowrap">
                                <div class="text-gray-800 dark:text-gray-100">#INV-2024001</div>
                            </td>
                            <td class="p-2 whitespace-nowrap">
                                <div>Jan 01, 2024</div>
                            </td>
                            <td class="p-2 whitespace-nowrap">
                                <div class="text-left font-medium text-green-500">$49.00</div>
                            </td>
                            <td class="p-2 whitespace-nowrap">
                                <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-500/20 text-green-600 dark:text-green-400">Paid</div>
                            </td>
                            <td class="p-2 whitespace-nowrap text-right">
                                <a class="text-violet-500 hover:text-violet-600 font-medium" href="#0">Download</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-2 whitespace-nowrap">
                                <div class="text-gray-800 dark:text-gray-100">#INV-2023012</div>
                            </td>
                            <td class="p-2 whitespace-nowrap">
                                <div>Dec 01, 2023</div>
                            </td>
                            <td class="p-2 whitespace-nowrap">
                                <div class="text-left font-medium text-green-500">$49.00</div>
                            </td>
                            <td class="p-2 whitespace-nowrap">
                                <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-500/20 text-green-600 dark:text-green-400">Paid</div>
                            </td>
                            <td class="p-2 whitespace-nowrap text-right">
                                <a class="text-violet-500 hover:text-violet-600 font-medium" href="#0">Download</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-2 whitespace-nowrap">
                                <div class="text-gray-800 dark:text-gray-100">#INV-2023011</div>
                            </td>
                            <td class="p-2 whitespace-nowrap">
                                <div>Nov 01, 2023</div>
                            </td>
                            <td class="p-2 whitespace-nowrap">
                                <div class="text-left font-medium text-green-500">$49.00</div>
                            </td>
                            <td class="p-2 whitespace-nowrap">
                                <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-500/20 text-green-600 dark:text-green-400">Paid</div>
                            </td>
                            <td class="p-2 whitespace-nowrap text-right">
                                <a class="text-violet-500 hover:text-violet-600 font-medium" href="#0">Download</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>
