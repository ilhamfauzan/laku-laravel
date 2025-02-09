<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-8">
            <!-- Add Laundry Button -->
            <div class="mb-4 flex justify-between items-center mr-4">
                <button type="button"
                    class="bg-blue-500 hover:bg-blue-500/80 text-white font-bold py-2 px-4 rounded-md transition-colors duration-200"
                    onclick="openModal()">
                    Add New Laundry
                </button>
                <form action="{{ route('laundries.index') }}" method="get" class="flex items-center">
                    <input type="text" name="keyword" placeholder="Search by name or phone..."
                        class="rounded-md bg-gray-100 border-gray-300 text-gray-700 focus:ring py-2 px-4">
                    <button type="submit"
                        class="ml-2 bg-blue-500 hover:bg-blue-500/80 text-white font-bold py-2 px-4 rounded-md transition-colors duration-200">
                        Search
                    </button>
                </form>
            </div>
            

            <!-- Notifications -->
            @if (session('success'))
            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 mt-4 bg-green-500 text-white p-4 rounded-lg shadow-lg notification opacity-0 transition-opacity duration-500">
                {{ session('success') }}
            </div>
            @endif

            @if (session('error'))
                <div class="absolute top-0 left-1/2 transform -translate-x-1/2 mt-4 bg-red-500 text-white p-4 rounded-lg shadow-lg notification opacity-0 transition-opacity duration-500">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('delete'))
                <div class="absolute top-0 left-1/2 transform -translate-x-1/2 mt-4 bg-red-500 text-white p-4 rounded-lg shadow-lg notification opacity-0 transition-opacity duration-500">
                    {{ session('delete') }}
                </div>
            @endif

            <!-- Unfinished Laundries Table -->
            @if ($laundries->where('status', 'Unfinished')->isEmpty())
                <div class="mt-10 ml-4 text-gray-700 text-xl">
                    You have no unfinished laundry orders.
                </div>
            @else
                <div class="mt-6">
                    <h2 class="text-2xl font-semibold text-gray-900">Unfinished Laundries</h2>
                    <p class="text-sm text-gray-500 mb-4">The following laundry orders are still in progress and have not been completed yet.</p>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white shadow-md rounded-lg">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b text-left">Customer Name</th>
                                    <th class="py-2 px-4 border-b text-left">Phone Number</th>
                                    <th class="py-2 px-4 border-b text-left">Weight (kg)</th>
                                    <th class="py-2 px-4 border-b text-left">Date</th>
                                    <th class="py-2 px-4 border-b text-left">Service</th>
                                    <th class="py-2 px-4 border-b text-left">Total Cost</th>
                                    <th class="py-2 px-4 border-b text-left">Status</th>
                                    <th class="py-2 px-4 border-b">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($laundries->where('status', 'Unfinished') as $laundry)
                                    <tr class="hover:bg-gray-100 transition-colors duration-200">
                                        <td class="py-2 px-4 border-b">{{ $laundry->customer_name }}</td>
                                        <td class="py-2 px-4 border-b">{{ $laundry->customer_phone_number }}</td>
                                        <td class="py-2 px-4 border-b">{{ $laundry->laundry_weight }} kg</td>
                                        <td class="py-2 px-4 border-b">{{ $laundry->laundry_date }}</td>
                                        <td class="py-2 px-4 border-b">{{ $laundry->service->service_name }}</td>
                                        <td class="py-2 px-4 border-b">Rp{{ number_format($laundry->laundry_weight * $laundry->service->service_price, 0, ',', '.') }}</td>
                                        <td class="py-2 px-4 border-b">{{ $laundry->status }}</td>
                                        <td class="py-2 px-4 border-b">
                                            <button onclick="openModal({{ $laundry }})"
                                                class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-1 px-2 rounded-md transition-colors duration-200">
                                                Edit
                                            </button>
                                            <button onclick="openFinishModal({{ $laundry->id }})"
                                                class="bg-green-500 hover:bg-green-400 text-white font-bold py-1 px-2 rounded-md transition-colors duration-200">
                                                Finish
                                            </button>
                                            <button onclick="openDeleteModal({{ $laundry->id }})"
                                                class="bg-red-500 hover:bg-red-400 text-white font-bold py-1 px-2 rounded-md transition-colors duration-200">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- Finished Laundries Table -->
            @if ($laundries->where('status', 'Finished')->isEmpty())
                <div class="mt-10 ml-4 text-gray-700 text-xl">
                    You have no finished laundry orders.
                </div>
            @else
                <div class="mt-6">
                    <h2 class="text-2xl font-semibold text-gray-900">Finished Laundries</h2>
                    <p class="text-sm text-gray-500 mb-4">The following laundry orders are finished but have not been picked up yet.</p>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white shadow-xl rounded-xl border-gray-300">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b text-left">Customer Name</th>
                                    <th class="py-2 px-4 border-b text-left">Phone Number</th>
                                    <th class="py-2 px-4 border-b text-left">Weight (kg)</th>
                                    <th class="py-2 px-4 border-b text-left">Date</th>
                                    <th class="py-2 px-4 border-b text-left">Service</th>
                                    <th class="py-2 px-4 border-b text-left">Total Cost</th>
                                    <th class="py-2 px-4 border-b text-left">Status</th>
                                    <th class="py-2 px-4 border-b">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="Content">
                                @foreach ($laundries->where('status', 'Finished') as $laundry)
                                    @if (!$transactions->contains('laundry_id', $laundry->id))
                                        <tr class="hover:bg-gray-100 transition-colors duration-200">
                                            <td class="py-2 px-4 border-b">{{ $laundry->customer_name }}</td>
                                            <td class="py-2 px-4 border-b">{{ $laundry->customer_phone_number }}</td>
                                            <td class="py-2 px-4 border-b">{{ $laundry->laundry_weight }} kg</td>
                                            <td class="py-2 px-4 border-b">{{ $laundry->laundry_date }}</td>
                                            <td class="py-2 px-4 border-b">{{ $laundry->service->service_name }}</td>
                                            <td class="py-2 px-4 border-b">Rp{{ number_format($laundry->laundry_weight * $laundry->service->service_price, 0, ',', '.') }}</td>
                                            <td class="py-2 px-4 border-b">{{ $laundry->status }}</td>
                                            <td class="py-2 px-4 border-b">
                                                <button onclick="openPaidModal({{ $laundry->id }})"
                                                    class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-1 px-2 rounded-md transition-colors duration-200">
                                                    Set as Paid
                                                </button>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- Existing notification blocks remain the same -->

            <!-- Modal -->
            <!-- Paid Confirmation Modal -->
            <div id="paidModal"
            class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 flex items-center justify-center">
            <div class="relative p-5 border w-full max-w-md shadow-lg rounded-md bg-white border-gray-300">
                <div class="mt-3 text-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Confirm Payment</h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">Are you sure you want to mark this transaction as paid? This action cannot be undone.</p>
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

            <div id="laundryModal"
                class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 flex items-center justify-center">
                <div class="relative p-5 border w-full max-w-md shadow-lg rounded-md bg-white border-gray-300">
                    <div class="mt-3">
                        <form id="laundryForm" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="_method" value="POST" id="formMethod">
                            <div class="mb-2">
                                <label class="block text-gray-700 text-sm font-bold mb-1" for="customer_name">
                                    Customer Name
                                </label>
                                <input type="text" name="customer_name" id="customer_name" required placeholder="Enter customer name"
                                    class="w-full rounded-md bg-gray-100 border-gray-300 text-gray-700 focus:ring">
                            </div>
                            <div class="mb-2">
                                <label class="block text-gray-700 text-sm font-bold mb-1" for="customer_phone_number">
                                    Customer Phone Number
                                </label>
                                <input type="number" name="customer_phone_number" id="customer_phone_number" placeholder="Enter customer phone number"
                                    class="w-full rounded-md bg-gray-100 border-gray-300 text-gray-700 focus:ring">
                            </div>
                            <div class="mb-2">
                                <label class="block text-gray-700 text-sm font-bold mb-1" for="laundry_weight">
                                    Weight (kg)
                                </label>
                                <input type="number" step="0.1" name="laundry_weight" id="laundry_weight" required placeholder="Enter laundry weight"
                                    class="w-full rounded-md bg-gray-100 border-gray-300 text-gray-700 focus:ring" oninput="updateTotalCost()">
                            </div>
                            <div class="mb-2">
                                <label class="block text-gray-700 text-sm font-bold mb-1" for="laundry_date">
                                    Laundry Date
                                </label>
                                <input type="date" name="laundry_date" id="laundry_date" required
                                    class="w-full rounded-md bg-gray-100 border-gray-300 text-gray-700 focus:ring">
                            </div>
                            <div class="mb-2">
                                <label class="block text-gray-700 text-sm font-bold mb-1" for="service_id">
                                    Service Type
                                </label>
                                <select name="service_id" id="service_id" required
                                    class="w-full rounded-md bg-gray-100 border-gray-300 text-gray-700 focus:ring" onchange="updateTotalCost()">
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" data-price="{{ $service->service_price }}">{{ $service->service_name }} (Rp{{ $service->service_price }}/kg)</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-1">
                                    Total Cost
                                </label>
                                <p id="totalCost" class="text-lg font-semibold text-gray-900">Rp0</p>
                            </div>
                            <div class="flex justify-end">
                                <button type="button" onclick="closeModal()"
                                    class="mr-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-200">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-500/80">
                                    Save Laundry
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal"
        class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 flex items-center justify-center">
        <div class="relative p-5 border w-full max-w-md shadow-lg rounded-md bg-white border-gray-300">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Delete Laundry</h3>
                <div class="mt-2">
                    <p class="text-sm text-gray-500">Are you sure you want to delete this laundry? This action cannot be undone.</p>
                </div>
                <div class="mt-4 flex justify-center">
                    <button type="button" onclick="closeDeleteModal()"
                        class="mr-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-200">
                        Cancel
                    </button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-400">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Finish Confirmation Modal -->
    <div id="finishModal"
        class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 flex items-center justify-center">
        <div class="relative p-5 border w-full max-w-md shadow-lg rounded-md bg-white border-gray-300">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Finish Laundry</h3>
                <div class="mt-2">
                    <p class="text-sm text-gray-500">Are you sure you want to mark this laundry as finished? This action cannot be undone.</p>
                </div>
                <div class="mt-4 flex justify-center">
                    <button type="button" onclick="closeFinishModal()"
                        class="mr-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-200">
                        Cancel
                    </button>
                    <form id="finishForm" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit"
                            class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-400">
                            Finish
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
            paidForm.action = `/laundries/${id}/markAsPaid`;
            paidModal.classList.remove('hidden');
        }

        function closePaidModal() {
            document.getElementById('paidModal').classList.add('hidden');
        }


        // Show notifications with animation
        document.addEventListener('DOMContentLoaded', function () {
        // Show notifications if they exist
        setTimeout(() => {
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
        }, 200);
    });
            
        function openModal(laundry = null) {
            const modal = document.getElementById('laundryModal');
            const form = document.getElementById('laundryForm');
            const methodInput = document.getElementById('formMethod');
            const laundryDateInput = document.getElementById('laundry_date');

            if (laundry) {
                form.action = `/laundries/${laundry.id}`;
                methodInput.value = 'PUT';
                document.getElementById('customer_name').value = laundry.customer_name;
                document.getElementById('customer_phone_number').value = laundry.customer_phone_number;
                document.getElementById('laundry_weight').value = laundry.laundry_weight;
                laundryDateInput.value = laundry.laundry_date;
                document.getElementById('service_id').value = laundry.service_id;
                updateTotalCost();
            } else {
                form.action = '{{ route('laundries.store') }}';
                methodInput.value = 'POST';
                form.reset();
                document.getElementById('totalCost').innerText = 'Rp0';
                laundryDateInput.value = new Date().toISOString().split('T')[0]; // Set default date to today
            }

            modal.classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('laundryModal').classList.add('hidden');
        }

        function updateTotalCost() {
            const weight = parseFloat(document.getElementById('laundry_weight').value) || 0;
            const serviceSelect = document.getElementById('service_id');
            const servicePrice = parseFloat(serviceSelect.options[serviceSelect.selectedIndex].getAttribute('data-price')) || 0;
            const totalCost = weight * servicePrice;
            document.getElementById('totalCost').innerText = 'Rp' + totalCost.toLocaleString('id-ID');
        }

        function openDeleteModal(id) {
            const deleteModal = document.getElementById('deleteModal');
            const deleteForm = document.getElementById('deleteForm');
            deleteForm.action = `/laundries/${id}`;
            deleteModal.classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        function deleteLaundry(id) {
            if (confirm('Are you sure you want to delete this laundry?')) {
                fetch(`/laundries/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                }).then(response => {
                    if (response.ok) {
                        location.reload();
                    } else {
                        response.json().then(data => {
                            alert('Failed to delete laundry: ' + data.message);
                        });
                    }
                }).catch(error => {
                    console.error('Error:', error);
                    alert('Failed to delete laundry.');
                });
            }
        }

        function openFinishModal(id) {
            const finishModal = document.getElementById('finishModal');
            const finishForm = document.getElementById('finishForm');
            finishForm.action = `/laundries/${id}/finish`;
            finishModal.classList.remove('hidden');
        }

        function closeFinishModal() {
            document.getElementById('finishModal').classList.add('hidden');
        }
    </script>
</x-app-layout>