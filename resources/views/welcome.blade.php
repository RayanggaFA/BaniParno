<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Silsilah Keluarga - Daftar Keluarga</title>
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
        <!-- Header -->
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Daftar Keluarga</h2>
                        <p class="text-gray-600 mt-1">Kelola informasi cabang keluarga</p>
                    </div>
                    <button onclick="openAddModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Keluarga
                    </button>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        <!-- Families Grid -->
        @if(isset($families) && $families->count() > 0)
        <!-- Families Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($families as $family)
        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-4 h-4 rounded-full" style="background-color: {{ $family->color ?? '#000' }}"></div>
                    <span class="text-sm text-gray-500">Generasi {{ $family->generation ?? 'N/A' }}</span>
                </div>
                    
                    @if($family->description)
                    <p class="text-gray-500 text-sm mb-4 line-clamp-2">{{ $family->description }}</p>
                    @endif
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-gray-500">
                            <i class="fas fa-users mr-1"></i>
                            <span class="text-sm">{{ $family->members_count }} Anggota</span>
                        </div>
                        
                        <div class="flex space-x-2">
                            <a href="{{ route('families.show', $family) }}" class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button onclick="editFamily({{ $family->id }})" class="text-green-600 hover:text-green-800">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="deleteFamily({{ $family->id }})" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
    </div>
@else
    <div class="text-center py-8">
        <p class="text-gray-500">Belum ada data family.</p>
        <a href="{{ route('families.create') }}" class="btn btn-primary mt-4">Tambah Family Pertama</a>
    </div>
@endif

        @if(isset($families))
    <!-- Families Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($families as $family)
        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
            <!-- konten family card -->
        </div>
        @empty
        <div class="col-span-full text-center py-8">
            <p class="text-gray-500">Belum ada data family.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($families->hasPages())
    <div class="mt-6">
        {{ $families->links() }}
    </div>
    @endif
@else
    <div class="text-center py-8">
        <p class="text-red-500">Error: Data families tidak ditemukan.</p>
    </div>
@endif

    <!-- Add/Edit Modal -->
    <div id="familyModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="px-6 py-4 border-b">
                    <h3 id="modalTitle" class="text-lg font-semibold text-gray-900">Tambah Keluarga</h3>
                </div>
                
                <form id="familyForm" method="POST">
                    @csrf
                    <div class="px-6 py-4 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Keluarga</label>
                            <input type="text" name="name" id="familyName" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Cabang</label>
                            <input type="text" name="branch" id="familyBranch" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Generasi</label>
                            <input type="number" name="generation" id="familyGeneration" min="1" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Warna Identitas</label>
                            <input type="color" name="color" id="familyColor" value="#3B82F6"
                                   class="w-full h-10 border border-gray-300 rounded-md">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                            <textarea name="description" id="familyDescription" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>
                    </div>
                    
                    <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                        <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Modal functions
        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Tambah Keluarga';
            document.getElementById('familyForm').action = '{{ route("families.store") }}';
            document.getElementById('familyForm').method = 'POST';
            document.getElementById('familyModal').classList.remove('hidden');
            resetForm();
        }
        
        function closeModal() {
            document.getElementById('familyModal').classList.add('hidden');
        }
        
        function resetForm() {
            document.getElementById('familyName').value = '';
            document.getElementById('familyBranch').value = '';
            document.getElementById('familyGeneration').value = '';
            document.getElementById('familyColor').value = '#3B82F6';
            document.getElementById('familyDescription').value = '';
        }
        
        async function editFamily(id) {
            try {
                const response = await fetch(`/api/families/${id}`);
                const family = await response.json();
                
                document.getElementById('modalTitle').textContent = 'Edit Keluarga';
                document.getElementById('familyForm').action = `/families/${id}`;
                
                // Add method spoofing for PUT
                let methodInput = document.querySelector('input[name="_method"]');
                if (!methodInput) {
                    methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    document.getElementById('familyForm').appendChild(methodInput);
                }
                methodInput.value = 'PUT';
                
                document.getElementById('familyName').value = family.name;
                document.getElementById('familyBranch').value = family.branch;
                document.getElementById('familyGeneration').value = family.generation;
                document.getElementById('familyColor').value = family.color;
                document.getElementById('familyDescription').value = family.description || '';
                
                document.getElementById('familyModal').classList.remove('hidden');
            } catch (error) {
                alert('Gagal memuat data keluarga');
            }
        }
        
        function deleteFamily(id) {
            if (confirm('Apakah Anda yakin ingin menghapus keluarga ini?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/families/${id}`;
                
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
        document.getElementById('familyModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>
</html>