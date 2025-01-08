{{-- filepath: /C:/laragon/www/laundryku/resources/views/transactions/index.blade.php --}}
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-8">
            <div class="mt-6">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Finished Laundry</h2>
                <div class="overflow-x-auto">
                    @foreach($laundries as $laundry)
                        @if(!$transactions->contains('laundry_id', $laundry->id))
                        <table class="min-w-full bg-white shadow-md rounded-lg">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b">ID</th>
                                    <th class="py-2 px-4 border-b">Customer Name</th>
                                    <th class="py-2 px-4 border-b">Phone Number</th>
                                    <th class="py-2 px-4 border-b">Weight (kg)</th>
                                    <th class="py-2 px-4 border-b">Date</th>
                                    <th class="py-2 px-4 border-b">Service</th>
                                    <th class="py-2 px-4 border-b">Total Cost</th>
                                    <th class="py-2 px-4 border-b">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @if($laundry->status == 'Finished')
                                        <tr class="hover:bg-gray-100 transition-colors duration-200">
                                            <td class="py-2 px-4 border-b">{{ $laundry->id }}</td>
                                            <td class="py-2 px-4 border-b">{{ $laundry->customer_name }}</td>
                                            <td class="py-2 px-4 border-b">{{ $laundry->customer_phone_number }}</td>
                                            <td class="py-2 px-4 border-b">{{ $laundry->laundry_weight }}</td>
                                            <td class="py-2 px-4 border-b">{{ $laundry->laundry_date }}</td>
                                            <td class="py-2 px-4 border-b">{{ $laundry->service->service_name }}</td>
                                            <td class="py-2 px-4 border-b">Rp{{ number_format($laundry->laundry_weight * $laundry->service->service_price, 0, ',', '.') }}</td>
                                            <td class="py-2 px-4 border-b">
                                                <button onclick="openPaidModal({{ $laundry->id }})"
                                                    class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-1 px-2 rounded-md transition-colors duration-200">
                                                    Set as Paid
                                                </button>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            @endif
                    @endforeach
                </div>
            </div>

            <div class="mt-6">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Finished Transactions</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white shadow-md rounded-lg">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">ID</th>
                                <th class="py-2 px-4 border-b">Payment Date</th>
                                <th class="py-2 px-4 border-b">Customer Name</th>
                                <th class="py-2 px-4 border-b">Phone Number</th>
                                <th class="py-2 px-4 border-b">Weight</th>
                                <th class="py-2 px-4 border-b">Service</th>
                                <th class="py-2 px-4 border-b">Total Cost</th>
                                <th class="py-2 px-4 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                            <tr class="hover:bg-gray-100 transition-colors duration-200">
                                <td class="py-2 px-4 border-b">{{ $transaction->id }}</td>
                                <td class="py-2 px-4 border-b">{{ $transaction->payment_date }}</td>
                                <td class="py-2 px-4 border-b">{{ $transaction->laundry->customer_name }}</td>
                                <td class="py-2 px-4 border-b">{{ $transaction->laundry->customer_phone_number }}</td>
                                <td class="py-2 px-4 border-b">{{ $transaction->laundry->laundry_weight }}kg</td>
                                <td class="py-2 px-4 border-b">{{ $transaction->laundry->service->service_name }}</td>
                                <td class="py-2 px-4 border-b">{{ $transaction->formatted_total_price }}</td>
                                <td class="py-2 px-4 border-b">
                                    <button onclick="printReceipt({{ $transaction->id }})" class="bg-gray-500 hover:bg-gray-400 text-white font-bold py-1 px-2 rounded-md transition-colors duration-200">Print Receipt</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
                    <p class="text-sm text-gray-500">Are you sure you want to mark this transaction as paid?</p>
                </div>
                <div class="mt-4 flex justify-center">
                    <button type="button" onclick="closePaidModal()"
                        class="mr-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-200">
                        Cancel
                    </button>
                    <form id="paidForm" method="POST">
                        @csrf
                        @method('POST')
                        <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-400">
                            Confirm
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openPaidModal(id) {
            const paidModal = document.getElementById('paidModal');
            const paidForm = document.getElementById('paidForm');
            paidForm.action = `/transactions/${id}/markAsPaid`;
            paidModal.classList.remove('hidden');
        }

        function closePaidModal() {
            document.getElementById('paidModal').classList.add('hidden');
        }

        function printReceipt(id) {
            const url = `/transactions/${id}/printReceipt`;
            const printWindow = window.open(url, '_blank');
            printWindow.focus();
            printWindow.onload = function() {
            printWindow.print();
            printWindow.onafterprint = function() {
                printWindow.close();
            };
            };
        }
    </script>
</x-app-layout>