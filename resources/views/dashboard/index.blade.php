<x-app-layout>
    <div class="flex items-center justify-center min-h-screen py-12 relative m-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Laundry Overview</h2>
                <p class="text-gray-400">Monitor your laundry services and performance</p>
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

            {{-- Summary Card v2 --}}
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 mb-6">
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gradient-to-br from-blue-600 to-blue-400 rounded-lg p-6 shadow-lg h-40 flex items-center justify-center">
                        <div class="text-center">
                            <p class="text-blue-100 text-sm">Today Income</p>
                            <div class="flex items-baseline justify-center">
                                <p class="text-white text-auto font-bold">Rp{{ number_format($incomeToday, 2) }}</p>
                            </div>
                        </div>
                    </div>
    
                    {{-- Income Card --}}
                    <div class="bg-gradient-to-br from-emerald-600 to-emerald-400 rounded-lg p-6 shadow-lg h-40 flex items-center justify-center">
                        <div class="text-center">
                            <p class="text-emerald-100 text-sm">Monthly Income</p>
                            <div class="flex items-baseline justify-center">
                                <p class="text-white text-auto font-bold">Rp{{ number_format($incomeThisMonth, 2) }}</p>
                            </div>
                        </div>
                    </div>
    
                    {{-- Unfinished Laundry Card --}}
                    <div class="bg-gradient-to-br from-rose-600 to-rose-400 rounded-lg p-6 shadow-lg h-40 flex items-center justify-center">
                        <div class="text-center">
                            <p class="text-rose-100 text-sm">Unfinished Laundries</p>
                            <div class="flex items-baseline justify-center">
                                <p class="text-white text-auto font-bold">{{ $unfinishedLaundries->count() }}</p>
                            </div>
                        </div>
                    </div>
    
                    {{-- Total Laundry Today Card --}}
                    <div class="bg-gradient-to-br from-violet-600 to-violet-400 rounded-lg p-6 shadow-lg h-40 flex items-center justify-center">
                        <div class="text-center">
                            <p class="text-violet-100 text-sm">Total Laundries Today</p>
                            <div class="flex items-baseline justify-center">
                                <p class="text-white text-auto font-bold">{{ $totalLaundriesToday }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-1 gap-4 mb-6 col-span-2">
                    <div class="bg-white shadow-xl sm:rounded-lg border border-gray-300 rounded-lg p-6 lg:col-span-1">
                        <h3 class="text-lg font-semibold text-gray-800 mb-0">Weekly Income</h3>
                        <p class="text-s font-semibold text-gray-600 mb-5">this week</p>
                        <canvas id="weeklyIncomeChart" class="w-full" height="200"></canvas>
                    </div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-1 gap-4 mb-6">
                    <div class="bg-white shadow-xl sm:rounded-lg border border-gray-300 rounded-lg p-6 lg:col-span-1">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Laundry Status Distribution</h3>
                        <canvas id="laundryStatusChart" class="w-full" height="200"></canvas>
                    </div>
                </div>
            </div>
            
            {{-- Recent Laundries Section --}}
            <div class="bg-white shadow-xl sm:rounded-lg border border-gray-300 rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Laundries</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Weight</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($laundries->sortByDesc('laundry_date')->take(5) as $laundry)
                        <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $laundry->laundry_date }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $laundry->customer_name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $laundry->laundry_weight }}kg</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-3 inline-flex text-xs leading-5 font-semibold rounded-full {{ $laundry->status === 'Finished' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $laundry->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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

        document.addEventListener('DOMContentLoaded', function() {
            // Data for Weekly Income Chart
            const weeklyIncomeCtx = document.getElementById('weeklyIncomeChart').getContext('2d');
            const weeklyIncomeChart = new Chart(weeklyIncomeCtx, {
                type: 'bar',
                data: {
                    labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                    datasets: [{
                        label: 'Income',
                        data: [
                            parseFloat("{{ $weeklyIncome['monday'] ?? 0 }}"),
                            parseFloat("{{ $weeklyIncome['tuesday'] ?? 0 }}"),
                            parseFloat("{{ $weeklyIncome['wednesday'] ?? 0 }}"),
                            parseFloat("{{ $weeklyIncome['thursday'] ?? 0 }}"),
                            parseFloat("{{ $weeklyIncome['friday'] ?? 0 }}"),
                            parseFloat("{{ $weeklyIncome['saturday'] ?? 0 }}"),
                            parseFloat("{{ $weeklyIncome['sunday'] ?? 0 }}")
                        ],
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Data for Laundry Status Distribution Chart
            const laundryStatusCtx = document.getElementById('laundryStatusChart').getContext('2d');
            const laundryStatusChart = new Chart(laundryStatusCtx, {
                type: 'pie',
                data: {
                    labels: ['Finished', 'Unfinished'],
                    datasets: [{
                        label: 'Laundry Status',
                        data: [
                            {{ $finishedLaundries->count() }},
                            {{ $unfinishedLaundries->count() }}
                        ],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 99, 132, 0.6)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.label + ': ' + tooltipItem.raw;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
