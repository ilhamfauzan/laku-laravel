<x-app-layout>
    <div class="flex items-center justify-center min-h-screen py-12 relative m-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Laundry Overview</h2>
                <p class="text-gray-400">Monitor your laundry services and performance</p>
            </div>

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                {{-- Services Card --}}
                <div class="bg-gradient-to-br from-blue-600 to-blue-400 rounded-lg p-6 shadow-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-blue-100 text-sm">Today Income</p>
                            <div class="flex items-baseline">
                                <p class="text-white text-2xl font-bold">Rp{{ number_format($incomeThisMonth, 2) }}</p>
                            </div>
                        </div>
                        <div class="p-2 bg-blue-500/30 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 6v18h18V6H3zm0-4a2 2 0 012-2h14a2 2 0 012 2v4H3V2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Income Card --}}
                <div class="bg-gradient-to-br from-emerald-600 to-emerald-400 rounded-lg p-6 shadow-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-emerald-100 text-sm">Monthly Income</p>
                            <div class="flex items-baseline">
                                <p class="text-white text-2xl font-bold">Rp{{ number_format($incomeThisMonth, 2) }}</p>
                            </div>
                        </div>
                        <div class="p-2 bg-emerald-500/30 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Unfinished Laundry Card --}}
                <div class="bg-gradient-to-br from-rose-600 to-rose-400 rounded-lg p-6 shadow-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-rose-100 text-sm">Unfinished Laundries</p>
                            <div class="flex items-baseline">
                                <p class="text-white text-2xl font-bold">{{ $unfinishedLaundries->count() }}</p>
                            </div>
                        </div>
                        <div class="p-2 bg-rose-500/30 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Total Laundry Today Card --}}
                <div class="bg-gradient-to-br from-violet-600 to-violet-400 rounded-lg p-6 shadow-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-violet-100 text-sm">Total Laundries Today</p>
                            <div class="flex items-baseline">
                                <p class="text-white text-2xl font-bold">{{ $totalLaundriesToday }}</p>
                            </div>
                        </div>
                        <div class="p-2 bg-violet-500/30 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 14l9-5-9-5-9 5 9 5z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Charts Section --}}
            
            
        </div>
    </div>
</x-app-layout>
