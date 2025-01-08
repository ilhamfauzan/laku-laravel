<div class="">
    <!-- Mobile Menu Button -->
    <div class="md:hidden flex items-center justify-between p-4 bg-white shadow-md">
        <a href="{{ route('dashboard') }}">
            <x-application-logo class="h-9 w-auto fill-current text-gray-800" />
        </a>
        <button id="mobile-menu-button" class="text-gray-800 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>
    </div>

    <!-- Sidebar -->
    <aside id="sidebar"
        class="fixed top-4 lg:left-4 bottom-4 w-64 transform -translate-x-full md:translate-x-0 transition-transform duration-200 ease-in-out z-40">
        <div class="bg-white h-full border border-gray-300 rounded-xl shadow-xl">
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="p-4 border-b border-gray-300">
                    <a href="#">
                        <x-application-logo class="h-9 w-auto fill-current text-gray-800 mx-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <nav class="flex-1 px-4 py-6 space-y-2">
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center w-full px-4 py-2 text-gray-800 hover:text-white hover:bg-blue-400 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-blue-500 text-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span>{{ __('Dashboard') }}</span>
                    </a>

                    <a href="{{ route('laundries.index') }}"
                        class="flex items-center w-full px-4 py-2 text-gray-800 hover:text-white hover:bg-blue-400 rounded-lg {{ request()->routeIs('laundries.index') ? 'bg-blue-500 text-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path  stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7L6 4H9C9 4.39397 9.0776 4.78407 9.22836 5.14805C9.37913 5.51203 9.6001 5.84274 9.87868 6.12132C10.1573 6.3999 10.488 6.62087 10.8519 6.77164C11.2159 6.9224 11.606 7 12 7C12.394 7 12.7841 6.9224 13.1481 6.77164C13.512 6.62087 13.8427 6.3999 14.1213 6.12132C14.3999 5.84274 14.6209 5.51203 14.7716 5.14805C14.9224 4.78407 15 4.39397 15 4H18L21 7L20.5785 11.2152C20.542 11.5801 20.1382 11.7829 19.8237 11.5942L18 10.5V18C18 19.1046 17.1046 20 16 20H8C6.89543 20 6 19.1046 6 18V10.5L4.17629 11.5942C3.86184 11.7829 3.45801 11.5801 3.42152 11.2152L3 7Z">
                        </svg>
                        <span>{{ __('Laundries') }}</span>
                    </a>

                    <a href="{{ route('transactions.index') }}"
                        class="flex items-center w-full px-4 py-2 text-gray-800 hover:text-white hover:bg-blue-400 rounded-lg {{ request()->routeIs('transactions.index') ? 'bg-blue-500 text-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ __('Transaction') }}</span>
                    </a>

                    @if(auth()->user()->role === 'owner')
                    <a href="{{ route('services') }}"
                        class="flex items-center w-full px-4 py-2 text-gray-800 hover:text-white hover:bg-blue-400 rounded-lg {{ request()->routeIs('categories.*') ? 'bg-blue-500 text-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        <span>{{ __('Services') }}</span>
                    </a>

                    <a href="{{ route('users.index') }}"
                        class="flex items-center w-full px-4 py-2 text-gray-800 hover:text-white hover:bg-blue-400 rounded-lg {{ request()->routeIs('users.index') ? 'bg-blue-500 text-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A4.992 4.992 0 0112 15a4.992 4.992 0 016.879 2.804M15 11a4 4 0 10-8 0 4 4 0 008 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>{{ __('User Management') }}</span>
                    </a>
                    @endif

                    @if(auth()->user()->role !== 'owner')
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center w-full px-4 py-2 text-gray-800 hover:text-white hover:bg-blue-400 rounded-lg {{ request()->routeIs('profile.edit') ? 'bg-blue-500 text-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>{{ __('Profile') }}</span>
                    </a>
                    @endif
                </nav>

                <!-- Settings -->
                <div class="p-4 border-t border-gray-300">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center w-full px-4 py-2 text-gray-800 hover:bg-blue-400 rounded-lg hover:text-white">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span>{{ __('Log Out') }}</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </aside>

    <!-- Overlay for Mobile Menu -->
    <div id="overlay" class="fixed inset-0 bg-black opacity-50 hidden md:hidden z-30"></div>
</div>

<script>
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    mobileMenuButton.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    });
</script>
