<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $family->name }} - Detail Keluarga</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-blue-600 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <i class="fas fa-users text-white text-2xl mr-3"></i>
                    <h1 class="text-white text-xl font-bold">Silsilah Keluarga</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('families.index') }}" class="text-white hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium">
                        <i class="fas fa-home mr-1"></i> Keluarga
                    </a>
                    <a href="{{ route('members.index') }}" class="text-white hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium">
                        <i class="fas fa-user-friends mr-1"></i> Anggota
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="{{ route('families.index') }}" class="hover:text-blue-600">Keluarga</a></li>
                <li><i class="fas fa-chevron-right"></i></li>
                <li class="text-gray-900">{{ $family->name }}</li>
            </ol>
        </nav>

        <!-- Success Message -->
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        <!-- Error Messages -->
        @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Family Header -->
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full mr-4" style="background-color: {{ $family->color }}"></div>
                        <div>
                            <h2 class="text-3xl font-bold text-gray-900">{{ $family->name }}</h2>
                            <p class="text-lg text-gray-600">{{ $family->branch }}</p>
                            <div class="flex items-center mt-2">
                                <span class="text-sm text-gray-500">
                                    <i class="fas fa-users mr-1"></i>
                                    {{ $family->members->count() }} Anggota
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex space-x-3">
                        <a href="{{ route('members.create') }}?family_id={{ $family->id }}" 
                           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                            <i class="fas fa-user-plus mr-2"></i>
                            Tambah Anggota
                        </a>
                        <button onclick="editFamily({{ $family->id }})" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                            <i class="fas fa-edit mr-2"></i>
                            Edit
                        </button>
                    </div>
                </div>
                
                @if($family->description)
                <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                    <p class="text-gray-700">{{ $family->description }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                    <div class="flex-1 max-w-lg">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" id="searchInput" placeholder="Cari anggota keluarga..." 
                                   class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <select id="statusFilter" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500">
                            <option value="">Semua Status</option>
                            <option value="active">Aktif</option>
                            <option value="inactive">Tidak Aktif</option>
                            <option value="deceased">Almarhum</option>
                        </select>
                        
                        <select id="genderFilter" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500">
                            <option value="">Semua Jenis Kelamin</option>
                            <option value="male">Laki-laki</option>
                            <option value="female">Perempuan</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Members Grid -->
        <div id="membersGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($members as $member)
            <div class="member-card bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300" 
                 data-name="{{ strtolower($member->name) }}" 
                 data-status="{{ $member->status }}" 
                 data-gender="{{ $member->gender }}">
                <div class="p-6">
                    <!-- Member Photo -->
                    <div class="flex justify-center mb-4">
                        <div class="w-20 h-20 rounded-full overflow-hidden bg-gray-200">
                            @if($member->photo)
                            <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}" 
                                 class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fas fa-user text-gray-400 text-2xl"></i>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Member Info -->
                    <div class="text-center">
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $member->name }}</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ $member->job }}</p>
                        
                        <div class="flex items-center justify-center space-x-4 text-xs text-gray-500 mb-3">
                            <span>
                                <i class="fas fa-{{ $member->gender == 'male' ? 'mars' : 'venus' }}"></i>
                                {{ $member->gender == 'male' ? 'L' : 'P' }}
                            </span>
                            <span>{{ $member->age }} tahun</span>
                        </div>
                        
                        <div class="flex items-center justify-center mb-3">
                            <span class="px-2 py-1 text-xs rounded-full 
                                {{ $member->status == 'active' ? 'bg-green-100 text-green-800' : 
                                   ($member->status == 'inactive' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ $member->status == 'active' ? 'Aktif' : 
                                   ($member->status == 'inactive' ? 'Tidak Aktif' : 'Almarhum') }}
                            </span>
                        </div>
                        
                        <p class="text-xs text-gray-500 mb-3">
                            <i class="fas fa-map-marker-alt mr-1"></i>
                            {{ $member->domicile_city }}
                        </p>
                        
                        <!-- Social Links -->
                        @if($member->socialLinks->count() > 0)
                        <div class="flex justify-center space-x-2 mb-3">
                            @foreach($member->socialLinks as $link)
                            <a href="{{ $link->url }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                <i class="fab fa-{{ $link->platform }}"></i>
                            </a>
                            @endforeach
                        </div>
                        @endif
                        
                        <!-- Actions -->
                        <div class="flex justify-center space-x-2">
                            <a href="{{ route('members.show', $member) }}" 
                               class="text-blue-600 hover:text-blue-800 p-2 rounded-full hover:bg-blue-50">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('members.edit', $member) }}" 
                               class="text-green-600 hover:text-green-800 p-2 rounded-full hover:bg-green-50">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="deleteMember({{ $member->id }})" 
                                    class="text-red-600 hover:text-red-800 p-2 rounded-full hover:bg-red-50">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $members->links() }}
        </div>
    </div>

    <!-- Edit Family Modal -->
    <div id="editFamilyModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-900">Edit Keluarga</h3>
                </div>
                
                <form id="editFamilyForm" method="POST" action="{{ route('families.update', $family) }}">
                    @csrf
                    @method('PUT')
                    <div class="px-6 py-4 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Keluarga</label>
                            <input type="text" name="name" id="editFamilyName" value="{{ old('name', $family->name) }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Cabang</label>
                            <input type="text" name="branch" id="editFamilyBranch" value="{{ old('branch', $family->branch) }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('branch') border-red-500 @enderror">
                            @error('branch')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                            <textarea name="description" id="editFamilyDescription" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror">{{ old('description', $family->description) }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                        <button type="button" onclick="closeEditModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            <i class="fas fa-save mr-1"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Search and Filter functionality
        document.getElementById('searchInput').addEventListener('input', filterMembers);
        document.getElementById('statusFilter').addEventListener('change', filterMembers);
        document.getElementById('genderFilter').addEventListener('change', filterMembers);

        function filterMembers() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value;
            const genderFilter = document.getElementById('genderFilter').value;
            const memberCards = document.querySelectorAll('.member-card');

            memberCards.forEach(card => {
                const name = card.dataset.name;
                const status = card.dataset.status;
                const gender = card.dataset.gender;

                const matchesSearch = name.includes(searchTerm);
                const matchesStatus = !statusFilter || status === statusFilter;
                const matchesGender = !genderFilter || gender === genderFilter;

                if (matchesSearch && matchesStatus && matchesGender) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Modal functions
        function editFamily(id) {
            document.getElementById('editFamilyModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editFamilyModal').classList.add('hidden');
        }

        function deleteMember(id) {
            if (confirm('Apakah Anda yakin ingin menghapus anggota ini?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/members/${id}`;
                
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                form.innerHTML = `
                    <input type="hidden" name="_token" value="${csrfToken}">
                    <input type="hidden" name="_method" value="DELETE">
                `;
                
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Close modal when clicking outside
        document.getElementById('editFamilyModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });

        // Auto-open modal if there are validation errors
        @if($errors->any())
            document.getElementById('editFamilyModal').classList.remove('hidden');
        @endif
    </script>
</body>
</html>