<x-app-layout>
    <div class="flex items-center justify-center min-h-screen py-12 relative m-5">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            {{-- Notifications --}}
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

            <div class="bg-white shadow-xl sm:rounded-lg border border-gray-300 mx-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Services</h2>
                        <button onclick="openModal()"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-500/80 transition-colors duration-200">
                            Add Service
                        </button>
                    </div>

                    <!-- Services Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                        Name</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                        Price</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($services as $service)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-800">{{ $service->service_name }}</td>
                                        <td class="px-6 py-4 text-gray-800">{{ $service->formatted_service_price }}/kg</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            <button
                                                onclick="openEditModal({{ $service->id }}, '{{ $service->service_name }}', {{ $service->service_price }})"
                                                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-500/80">
                                                Edit
                                            </button>
                                            <button onclick="openDeleteModal({{ $service->id }})"
                                                class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-400">
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
        </div>

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
    </div>

        <!-- Modal -->
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
                        placeholder="Enter service name"
                        class="w-full rounded-md bg-gray-100 border-gray-300 text-gray-800 focus:border-yellow-500 focus:ring focus:ring-yellow-200">
                    </div>
                    <div class="mb-4">
                    <label class="block text-gray-800 text-sm font-bold mb-2">Price</label>
                    <input type="number" name="service_price" id="servicePrice" required
                        placeholder="Enter service price"
                        class="w-full rounded-md bg-gray-100 border-gray-300 text-gray-800 focus:border-yellow-500 focus:ring focus:ring-yellow-200">
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

        <!-- Delete Confirmation Modal -->
        <div id="deleteModal"
            class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 flex items-center justify-center">
            <div class="relative p-5 border w-full max-w-md shadow-lg rounded-md bg-white border-gray-300">
                <div class="mt-3 text-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Delete Service</h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">Are you sure you want to delete this service? This action cannot be undone.</p>
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
                document.getElementById('serviceForm').insertAdjacentHTML('beforeend',
                    '<input type="hidden" name="_method" value="PUT">');
                document.getElementById('serviceId').value = id;
                document.getElementById('serviceName').value = name;
                document.getElementById('servicePrice').value = price;
                document.getElementById('serviceModal').classList.remove('hidden');
            }
    
            function closeModal() {
                document.getElementById('serviceModal').classList.add('hidden');
            }

            function openDeleteModal(id) {
                const deleteModal = document.getElementById('deleteModal');
                const deleteForm = document.getElementById('deleteForm');
                deleteForm.action = `/services/${id}`;
                deleteModal.classList.remove('hidden');
            }

            function closeDeleteModal() {
                document.getElementById('deleteModal').classList.add('hidden');
            }
    
            // Show notifications with animation
            document.addEventListener('DOMContentLoaded', () => {
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
            });
        </script>

</x-app-layout>
