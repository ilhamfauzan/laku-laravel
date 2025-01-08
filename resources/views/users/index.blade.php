<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-8">
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

            <!-- Add User Button -->
            <div class="mb-4 flex ml-4">
                <button type="button"
                    class="bg-blue-500 hover:bg-blue-500/80 text-white font-bold py-2 px-4 rounded-md transition-colors duration-200"
                    onclick="openUserModal()">
                    Add New User
                </button>
            </div>

            <!-- Users Table -->
            <div class="mt-6">
                <h2 class="text-2xl font-semibold text-gray-900">Registered Users</h2>
                <div class="overflow-x-auto">
                    {{-- <table class="min-w-full bg-white shadow-md rounded-lg">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">Name</th>
                                <th class="py-2 px-4 border-b">Email</th>
                                <th class="py-2 px-4 border-b">Role</th>
                                <th class="py-2 px-4 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="hover:bg-gray-100 transition-colors duration-200">
                                    <td class="py-2 px-4 border-b">{{ $user->name }}</td>
                                    <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                                    <td class="py-2 px-4 border-b">{{ ucfirst($user->role) }}</td>
                                    <td class="py-2 px-4 border-b">
                                        <button onclick="openUserModal({{ $user }})"
                                            class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-1 px-2 rounded-md transition-colors duration-200">
                                            Edit
                                        </button>
                                        <button onclick="openDeleteUserModal({{ $user->id }})"
                                            class="bg-red-500 hover:bg-red-400 text-white font-bold py-1 px-2 rounded-md transition-colors duration-200">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table> --}}

                    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 m-4">
                        @foreach ($users as $user)
                            <div onclick="openUserModal({{ $user }})"
                                class="border border-gray-700 shadow-xl rounded-lg cursor-pointer hover:bg-opacity-80 transition-all duration-200"
                                style="background-color: white;" data-color="white">
                                <div class="p-4 sm:p-6 flex flex-col justify-end h-full w-full aspect-square">
                                    <div class="text-content">
                                        <p class="text-4xl sm:text-6xl mb-2 sm:mb-4">🗿</p>
                                        <!-- Tampilkan emoji -->
                                        @if (auth()->user()->id === $user->id)
                                            <h3 class="text-lg sm:text-xl font-semibold">{{ $user->name }} (You)</h3>
                                        @else
                                            <h3 class="text-lg sm:text-xl font-semibold">{{ $user->name }}</h3>
                                        @endif
                                        <p class="text-sm sm:text-base">{{ ucfirst($user->role) }} - {{ $user->email }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>

            <!-- User Modal -->
            <div id="userModal"
                class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 flex items-center justify-center">
                <div class="relative p-5 border w-full max-w-md shadow-lg rounded-md bg-white border-gray-300">
                    <div class="mt-3">
                        <form id="userForm" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="_method" value="POST" id="userFormMethod">
                            <div class="mb-2">
                                <label class="block text-gray-700 text-sm font-bold mb-1" for="name">
                                    Name
                                </label>
                                <input type="text" name="name" id="name" required placeholder="Enter name"
                                    class="w-full rounded-md bg-gray-100 border-gray-300 text-gray-700 focus:border-blue-500 focus:ring focus:ring-blue-500/50">
                            </div>
                            <div class="mb-2">
                                <label class="block text-gray-700 text-sm font-bold mb-1" for="email">
                                    Email
                                </label>
                                <input type="email" name="email" id="email" required placeholder="Enter email"
                                    class="w-full rounded-md bg-gray-100 border-gray-300 text-gray-700 focus:border-blue-500 focus:ring focus:ring-blue-500/50">
                            </div>
                            <div class="mb-2">
                                <label class="block text-gray-700 text-sm font-bold mb-1" for="password">
                                    Password
                                </label>
                                <input type="password" name="password" id="password" placeholder="Enter password"
                                    class="w-full rounded-md bg-gray-100 border-gray-300 text-gray-700 focus:border-blue-500 focus:ring focus:ring-blue-500/50">
                            </div>
                            <div class="mb-2">
                                <label class="block text-gray-700 text-sm font-bold mb-1" for="role">
                                    Role
                                </label>
                                <select name="role" id="role" required
                                    class="w-full rounded-md bg-gray-100 border-gray-300 text-gray-700 focus:border-blue-500 focus:ring focus:ring-blue-500/50">
                                    <option value="cashier">Cashier</option>
                                    <option value="owner">Owner</option>
                                </select>
                            </div>
                            <div class="flex justify-end mt-2">
                                <button type="button" onclick="closeUserModal()"
                                    class="mr-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-200">
                                    Cancel
                                </button>
                                <form id="deleteUserForm" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="mr-2 px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-400">
                                        Delete
                                    </button>
                                </form>
                                <button type="submit"
                                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-500/80">
                                    Save User
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Delete Confirmation Modal -->
            <div id="deleteUserModal"
                class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 flex items-center justify-center">
                <div class="relative p-5 border w-full max-w-md shadow-lg rounded-md bg-white border-gray-300">
                    <div class="mt-3 text-center">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Delete User</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">Are you sure you want to delete this user? This action cannot be undone.</p>
                        </div>
                        <div class="mt-4 flex justify-center">
                            <button type="button" onclick="closeDeleteUserModal()"
                                class="mr-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-200">
                                Cancel
                            </button>
                            <form id="deleteUserForm" method="POST">
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
        
        function openUserModal(user = null) {
            const modal = document.getElementById('userModal');
            const form = document.getElementById('userForm');
            const methodInput = document.getElementById('userFormMethod');
            const deleteForm = document.getElementById('deleteUserForm');

            if (user) {
                form.action = `/users/${user.id}`;
                methodInput.value = 'PUT';
                document.getElementById('name').value = user.name;
                document.getElementById('email').value = user.email;
                document.getElementById('role').value = user.role;
                document.getElementById('password').value = ''; // Clear password field
                deleteForm.classList.remove('hidden'); // Show delete button
            } else {
                form.action = '{{ route('users.store') }}';
                methodInput.value = 'POST';
                form.reset();
                deleteForm.classList.add('hidden'); // Hide delete button
            }

            modal.classList.remove('hidden');
        }

        function closeUserModal() {
            document.getElementById('userModal').classList.add('hidden');
        }

        function openDeleteUserModal(id) {
            const deleteModal = document.getElementById('deleteUserModal');
            const deleteForm = document.getElementById('deleteUserForm');
            deleteForm.action = `/users/${id}`;
            deleteModal.classList.remove('hidden');
        }

        function closeDeleteUserModal() {
            document.getElementById('deleteUserModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
