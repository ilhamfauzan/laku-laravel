@foreach ($laundries as $laundry)
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