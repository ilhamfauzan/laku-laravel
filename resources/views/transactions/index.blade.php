<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-8">
            <!-- Add Laundry Button -->
            <div class="mb-4 flex justify-between items-center mr-4">
                <h1 class="text-2xl font-semibold text-gray-900">Transaction History</h1>
                <form action="{{ route('transactions.index') }}" method="get" class="flex items-center">
                    <input type="text" name="keyword" placeholder="Search by name or phone..."
                        class="rounded-md bg-gray-100 border-gray-300 text-gray-700 focus:border-[#FCD535] focus:ring focus:ring-[#FCD535]/50 py-2 px-4">
                    <button type="submit"
                        class="ml-2 bg-blue-500 hover:bg-blue-500/80 text-white font-bold py-2 px-4 rounded-md transition-colors duration-200">
                        Search
                    </button>
                </form>
            </div>

            {{-- Notifications --}}
            @if (session('success'))
                <div
                    class="absolute top-0 left-1/2 transform -translate-x-1/2 mt-4 bg-green-500 text-white p-4 rounded-lg shadow-lg notification opacity-0 transition-opacity duration-500">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div
                    class="absolute top-0 left-1/2 transform -translate-x-1/2 mt-4 bg-red-500 text-white p-4 rounded-lg shadow-lg notification opacity-0 transition-opacity duration-500">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('delete'))
                <div
                    class="absolute top-0 left-1/2 transform -translate-x-1/2 mt-4 bg-red-500 text-white p-4 rounded-lg shadow-lg notification opacity-0 transition-opacity duration-500">
                    {{ session('delete') }}
                </div>
            @endif


            <div class="mt-6">
                @foreach ($transactionsByMonth as $month => $transactions)
                    @php
                        // Cek apakah ini hasil pencarian atau transaksi bulanan
                        $isSearchResults = $month === 'Search Results';
                        $formattedMonth = $isSearchResults
                            ? 'Search Results'
                            : \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y');
                    @endphp

                    <h2 class="text-xl font-semibold text-gray-900 mt-8">{{ $formattedMonth }}</h2>
                    <p class="text-sm text-gray-500 mb-4">Total Earnings:
                        <strong>Rp{{ number_format($monthlyEarnings[$month] ?? 0, 0, ',', '.') }}</strong>
                    </p>

                    @if (!$isSearchResults)
                        <button onclick="printMonthlyReceipt('{{ $month }}')"
                            class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 rounded-md transition-colors duration-200 mb-4">
                            Print Monthly Receipt
                        </button>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white shadow-md rounded-lg mb-8">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b text-left">Customer Name</th>
                                    <th class="py-2 px-4 border-b text-left">Phone Number</th>
                                    <th class="py-2 px-4 border-b text-left">Weight</th>
                                    <th class="py-2 px-4 border-b text-left">Service</th>
                                    <th class="py-2 px-4 border-b text-left">Total Cost</th>
                                    <th class="py-2 px-4 border-b text-left">Payment Date</th>
                                    <th class="py-2 px-4 border-b text-left">Cashier Name</th>
                                    <th class="py-2 px-4 border-b">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaction)
                                    @if ($transaction && isset($transaction->laundry))
                                        {{-- Pastikan transaksi valid --}}
                                        <tr class="hover:bg-gray-100 transition-colors duration-200">
                                            <td class="py-2 px-4 border-b">{{ $transaction->laundry->customer_name }}
                                            </td>
                                            <td class="py-2 px-4 border-b">
                                                {{ $transaction->laundry->customer_phone_number }}</td>
                                            <td class="py-2 px-4 border-b">{{ $transaction->laundry->laundry_weight }}kg
                                            </td>
                                            <td class="py-2 px-4 border-b">
                                                {{ $transaction->laundry->service->service_name }}</td>
                                            <td class="py-2 px-4 border-b">{{ $transaction->formatted_total_price }}
                                            </td>
                                            <td class="py-2 px-4 border-b">{{ $transaction->formatted_payment_date }}
                                            </td>
                                            <td class="py-2 px-4 border-b">{{ $transaction->user->name }}</td>

                                            <td class="py-2 px-4 border-b">
                                                <button onclick="printReceipt({{ $transaction->id }})"
                                                    class="bg-gray-500 hover:bg-gray-400 text-white font-bold py-1 px-2 rounded-md transition-colors duration-200">Print
                                                    Receipt</button>
                                                <button onclick="openDetailModal({{ $transaction->laundry }})"
                                                    class="text-gray-700 font-bold py-1 px-2 rounded-md transition-colors duration-200">...</button>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>


        </div>
    </div>

    <!-- Paid Confirmation Modal -->
    <div id="paidModal"
        class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 flex items-center justify-center">
        <div class="relative p-5 border w-full max-w-md shadow-lg rounded-md bg-white border-gray-300">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Confirm Payment</h3>
                <div class="mt-2">
                    <p class="text-sm text-gray-500">Are you sure you want to mark this transaction as paid? This action
                        cannot be undone.</p>
                </div>
                <div class="mt-4 flex justify-center">
                    <button type="button" onclick="closePaidModal()"
                        class="mr-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-200">
                        Cancel
                    </button>
                    <form id="paidForm" method="POST">
                        @csrf
                        @method('POST')
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-400">
                            Confirm
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div id="detailModal"
        class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 flex items-center justify-center">
        <div class="relative p-5 border w-full max-w-md shadow-lg rounded-md bg-white border-gray-300">
            <div class="mt-3">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Laundry Details</h3>
                <div class="mt-2">
                    <p class="text-sm text-gray-500">Customer Name: <span id="detailCustomerName"></span></p>
                    <p class="text-sm text-gray-500">Phone Number: <span id="detailCustomerPhoneNumber"></span></p>
                    <p class="text-sm text-gray-500">Weight: <span id="detailLaundryWeight"></span> kg</p>
                    <p class="text-sm text-gray-500">Date: <span id="detailLaundryDate"></span></p>
                    <p class="text-sm text-gray-500">Service: <span id="detailServiceName"></span></p>
                    <p class="text-sm text-gray-500">Total Cost: <span id="detailTotalCost"></span></p>
                    <p class="text-sm text-gray-500">Description: <span id="detailDescription"></span></p>
                </div>
                <div class="mt-4 flex justify-end">
                    <button type="button" onclick="closeDetailModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-200">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Show notifications with animation
        document.querySelectorAll('.notification').forEach(notification => {
            notification.classList.add('opacity-100');
        });

        // Hide notifications after 3 seconds
        setTimeout(() => {
            document.querySelectorAll('.notification').forEach(notification => {
                notification.classList.remove('opacity-100');
                setTimeout(() => {
                    notification.remove();
                }, 500);
            });
        }, 3000);


        function printReceipt(id) {
            const url = `${window.location.origin}/transactions/${id}/printReceipt`;
            const printWindow = window.open(url, '_blank');
            printWindow.focus();
            printWindow.onload = function() {
                printWindow.print();
                printWindow.onafterprint = function() {
                    printWindow.close();
                };
            };
        }

        function printMonthlyReceipt(month) {
            const url = `${window.location.origin}/transactions/printMonthlyReceipt/${month}`;
            const printWindow = window.open(url, '_blank');
            printWindow.focus();
            printWindow.onload = function() {
                printWindow.print();
                printWindow.onafterprint = function() {
                    printWindow.close();
                };
            };
        }

        function openDetailModal(laundry) {
            document.getElementById('detailCustomerName').innerText = laundry.customer_name;
            document.getElementById('detailCustomerPhoneNumber').innerText = laundry.customer_phone_number;
            document.getElementById('detailLaundryWeight').innerText = laundry.laundry_weight;
            document.getElementById('detailLaundryDate').innerText = laundry.laundry_date;
            document.getElementById('detailServiceName').innerText = laundry.service.service_name;
            document.getElementById('detailTotalCost').innerText = 'Rp' + (laundry.laundry_weight * laundry.service
                .service_price).toLocaleString('id-ID');
            document.getElementById('detailDescription').innerText = laundry.description;
            document.getElementById('detailModal').classList.remove('hidden');
        }

        function closeDetailModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
