<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-8">
            <!-- Add Laundry Button -->
            <div class="mb-4 flex ml-4">
                <button type="button"
                    class="bg-[#FCD535] hover:bg-[#FCD535]/80 text-gray-900 font-bold py-2 px-4 rounded-md transition-colors duration-200"
                    onclick="openModal()">
                    Add New Laundry
                </button>
            </div>

            <!-- Laundries Grid -->
            @if ($laundries->isEmpty())
                <div class="mt-10 ml-4 text-white/70 text-xl">
                    You have no laundry orders. Click "Add New Laundry" to create one.
                </div>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 m-4">
                    @foreach ($laundries as $laundry)
                        <div onclick="window.location='{{ route('laundries.show', $laundry->id) }}'"
                            class="border border-gray-700 shadow-xl rounded-lg cursor-pointer hover:bg-opacity-80 transition-all duration-200 bg-gray-800">
                            <div class="p-4 sm:p-6 flex flex-col justify-end h-full w-full aspect-square">
                                <div class="text-content">
                                    <h3 class="text-lg sm:text-xl font-semibold">{{ $laundry->customer_name }}</h3>
                                    <p class="text-sm sm:text-base">Weight: {{ $laundry->laundry_weight }} kg</p>
                                    <p class="text-sm sm:text-base">Status: {{ $laundry->status }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Existing notification blocks remain the same -->

            <!-- Modal -->
            <div id="laundryModal"
                class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 flex items-center justify-center">
                <div class="relative p-5 border w-full max-w-md shadow-lg rounded-md bg-gray-800 border-gray-700">
                    <div class="mt-3">
                        <form action="{{ route('laundries.store') }}" method="POST" class="mt-4">
                            @csrf
                            <div class="mb-2">
                                <label class="block text-gray-200 text-sm font-bold mb-1" for="customer_name">
                                    Customer Name
                                </label>
                                <input type="text" name="customer_name" id="customer_name" required placeholder="Enter customer name"
                                    class="w-full rounded-md bg-gray-700 border-gray-600 text-gray-200 focus:border-[#FCD535] focus:ring focus:ring-[#FCD535]/50">
                            </div>
                            <div class="mb-2">
                                <label class="block text-gray-200 text-sm font-bold mb-1" for="customer_phone_number">
                                    Customer Phone Number
                                </label>
                                <input type="text" name="customer_phone_number" id="customer_phone_number" placeholder="Enter customer phone number"
                                    class="w-full rounded-md bg-gray-700 border-gray-600 text-gray-200 focus:border-[#FCD535] focus:ring focus:ring-[#FCD535]/50">
                            </div>
                            <div class="mb-2">
                                <label class="block text-gray-200 text-sm font-bold mb-1" for="laundry_weight">
                                    Weight (kg)
                                </label>
                                <input type="number" step="0.1" name="laundry_weight" id="laundry_weight" required placeholder="Enter laundry weight"
                                    class="w-full rounded-md bg-gray-700 border-gray-600 text-gray-200 focus:border-[#FCD535] focus:ring focus:ring-[#FCD535]/50">
                            </div>
                            <div class="mb-2">
                                <label class="block text-gray-200 text-sm font-bold mb-1" for="laundry_date">
                                    Laundry Date
                                </label>
                                <input type="date" name="laundry_date" id="laundry_date" required
                                    class="w-full rounded-md bg-gray-700 border-gray-600 text-gray-200 focus:border-[#FCD535] focus:ring focus:ring-[#FCD535]/50">
                            </div>
                            <div class="mb-2">
                                <label class="block text-gray-200 text-sm font-bold mb-1" for="service_id">
                                    Service Type
                                </label>
                                <select name="service_id" id="service_id" required
                                    class="w-full rounded-md bg-gray-700 border-gray-600 text-gray-200 focus:border-[#FCD535] focus:ring focus:ring-[#FCD535]/50">
                                    
                                    @php
                                        // dd($services);
                                    @endphp
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}">{{ $service->service_name }} (Rp{{ $service->service_price }}/kg)</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="block text-gray-200 text-sm font-bold mb-1" for="status">
                                    Status
                                </label>
                                <select name="status" id="status" required
                                    class="w-full rounded-md bg-gray-700 border-gray-600 text-gray-200 focus:border-[#FCD535] focus:ring focus:ring-[#FCD535]/50">
                                    <option value="Unfinished">Unfinished</option>
                                    <option value="Finished">Finished</option>
                                </select>
                            </div>
                            <div class="flex justify-end">
                                <button type="button" onclick="closeModal()"
                                    class="mr-2 px-4 py-2 bg-gray-700 text-gray-200 rounded-md hover:bg-gray-600">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 bg-[#FCD535] text-gray-900 rounded-md hover:bg-[#FCD535]/80">
                                    Add Laundry
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('laundryModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('laundryModal').classList.add('hidden');
        }
    </script>
</x-app-layout>