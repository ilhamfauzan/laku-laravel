<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-8">
            <!-- Search & Add Service Button -->
            <div class="mb-4 flex justify-between items-center ml-4 mr-4">
                <h2 class="text-2xl font-semibold text-gray-900">Services</h2>
                <button onclick="openModal()"
                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-500/80 transition-colors duration-200">
                    Add Service
                </button>
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

            <!-- Services Table -->
            <div class="overflow-x-auto bg-white shadow-md rounded-lg">
                <table class="min-w-full bg-white shadow-md rounded-lg">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b text-left">Name</th>
                            <th class="py-2 px-4 border-b text-left">Price</th>
                            <th class="py-2 px-4 border-b text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($services as $service)
                            <tr class="hover:bg-gray-100 transition-colors duration-200">
                                <td class="py-2 px-4 border-b">{{ $service->service_name }}</td>
                                <td class="py-2 px-4 border-b">{{ $service->formatted_service_price }}/kg</td>
                                <td class="py-2 px-4 border-b text-center">
                                    <button onclick="openEditModal({{ $service->id }}, '{{ $service->service_name }}', {{ $service->service_price }})"
                                        class="bg-gray-500 hover:bg-gray-400 text-white font-bold py-1 px-2 rounded-md transition-colors duration-200">
                                        Edit
                                    </button>
                                    <button onclick="openDeleteModal({{ $service->id }})"
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
    </div>

    <!-- Modal: Add/Edit Service -->
    <div id="serviceModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 flex items-center justify-center">
        <div class="relative mx-auto p-5 border w-96 shadow-lg rounded-md bg-white border-gray-300">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-800" id="modalTitle">Add Service</h3>
                <form id="serviceForm" method="POST" action="{{ route('services.store') }}" class="mt-4">
                    @csrf
                    <div class="mt-2">
                        <input type="hidden" id="serviceId" name="service_id">
                        <div class="mb-4">
                            <label class="block text-gray-800 text-sm font-bold mb-2">Name</label>
                            <input type="text" name="service_name" id="serviceName" required
                                class="w-full rounded-md bg-gray-100 border-gray-300 text-gray-800 focus:ring">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-800 text-sm font-bold mb-2">Price (per Kg)</label>
                            <input type="number" name="service_price" id="servicePrice" required
                                class="w-full rounded-md bg-gray-100 border-gray-300 text-gray-800 focus:ring">
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="button" onclick="closeModal()"
                            class="mr-2 px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-500/80">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal: Delete Confirmation -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 flex items-center justify-center">
        <div class="relative p-5 border w-full max-w-md shadow-lg rounded-md bg-white border-gray-300">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Delete Service</h3>
                <p class="text-sm text-gray-500">Are you sure you want to delete this service? This action cannot be undone.</p>
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

    <!-- JavaScript for Modals & Notifications -->
    <script>
        function openModal() {
            document.getElementById('modalTitle').textContent = 'Add Service';
            document.getElementById('serviceForm').action = "{{ route('services.store') }}";
            document.getElementById('serviceId').value = '';
            document.getElementById('serviceName').value = '';
            document.getElementById('servicePrice').value = '';
            document.getElementById('serviceModal').classList.remove('hidden');
        }

        function openEditModal(id, name, price) {
            document.getElementById('modalTitle').textContent = 'Edit Service';
            document.getElementById('serviceForm').action = `/services/${id}`;
            document.getElementById('serviceId').value = id;
            document.getElementById('serviceName').value = name;
            document.getElementById('servicePrice').value = price;
            document.getElementById('serviceModal').classList.remove('hidden');

            // Ensure the form uses the PUT method
            let methodInput = document.getElementById('methodInput');
            if (!methodInput) {
                methodInput = document.createElement('input');
                methodInput.setAttribute('type', 'hidden');
                methodInput.setAttribute('name', '_method');
                methodInput.setAttribute('value', 'PUT');
                methodInput.setAttribute('id', 'methodInput');
                document.getElementById('serviceForm').appendChild(methodInput);
            }
        }

        function closeModal() {
            document.getElementById('serviceModal').classList.add('hidden');
        }

        function openDeleteModal(id) {
            document.getElementById('deleteForm').action = `/services/${id}`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

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
    </script>

</x-app-layout>
