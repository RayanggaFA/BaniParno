<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bani Parno</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .loading {
            pointer-events: none;
            opacity: 0.6;
        }
    </style>
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

        <!-- Families Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($families as $family)
            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-4 h-4 rounded-full" style="background-color: {{ $family->color }}"></div>
                        <span class="text-sm text-gray-500">{{ $family->branch }}</span>
                    </div>
                    
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $family->name }}</h3>
                    
                    @if($family->description)
                    <p class="text-gray-500 text-sm mb-4 line-clamp-2">{{ $family->description }}</p>
                    @endif
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-gray-500">
                            <i class="fas fa-users mr-1"></i>
                            <span class="text-sm">{{ $family->members_count ?? 0 }} Anggota</span>
                        </div>
                        
                        <div class="flex space-x-2">
                            <a href="{{ route('families.show', $family) }}" class="text-blue-600 hover:text-blue-800 p-2 rounded-full hover:bg-blue-50" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button onclick="editFamily({{ $family->id }})" class="text-green-600 hover:text-green-800 p-2 rounded-full hover:bg-green-50" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="deleteFamily({{ $family->id }})" class="text-red-600 hover:text-red-800 p-2 rounded-full hover:bg-red-50" title="Hapus">
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
            {{ $families->links() }}
        </div>
    </div>

    <!-- Add Family Modal -->
    <div id="addFamilyModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-900">Tambah Keluarga Baru</h3>
                </div>
                
                <form method="POST" action="{{ route('families.store') }}">
                    @csrf
                    <div class="px-6 py-4 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Keluarga</label>
                            <input type="text" name="name" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Cabang</label>
                            <input type="text" name="branch" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Warna Identitas</label>
                            <input type="color" name="color" value="#3B82F6"
                                   class="w-full h-10 border border-gray-300 rounded-md">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                            <textarea name="description" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>
                    </div>
                    
                    <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                        <button type="button" onclick="closeAddModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            <i class="fas fa-save mr-1"></i>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Family Modal -->
    <div id="editFamilyModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-900">Edit Keluarga</h3>
                </div>
                
                <form id="editFamilyForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="px-6 py-4 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Keluarga</label>
                            <input type="text" name="name" id="editFamilyName" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Cabang</label>
                            <input type="text" name="branch" id="editFamilyBranch" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Warna Identitas</label>
                            <input type="color" name="color" id="editFamilyColor"
                                   class="w-full h-10 border border-gray-300 rounded-md">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                            <textarea name="description" id="editFamilyDescription" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
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

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex items-center">
                <i class="fas fa-spinner fa-spin text-blue-600 text-xl mr-3"></i>
                <span class="text-gray-700">Memuat data...</span>
            </div>
        </div>
    </div>

    <script>
        // Get CSRF token
        function getCSRFToken() {
            return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        }

        // Show loading
        function showLoading() {
            document.getElementById('loadingOverlay').classList.remove('hidden');
        }

        // Hide loading
        function hideLoading() {
            document.getElementById('loadingOverlay').classList.add('hidden');
        }

        // Show alert message
        function showAlert(message, type = 'error') {
            const alertClass = type === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700';
            const alertHTML = `
                <div class="${alertClass} px-4 py-3 rounded mb-4 fixed top-4 right-4 z-50 max-w-md shadow-lg" role="alert">
                    <span class="block sm:inline">${message}</span>
                    <button onclick="this.parentElement.remove()" class="float-right ml-2 text-lg leading-none">&times;</button>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', alertHTML);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                const alert = document.querySelector('.fixed.top-4.right-4');
                if (alert) alert.remove();
            }, 5000);
        }

        // Add Modal Functions
        function openAddModal() {
            document.getElementById('addFamilyModal').classList.remove('hidden');
        }

        function closeAddModal() {
            document.getElementById('addFamilyModal').classList.add('hidden');
        }

        // Edit Modal Functions
        function editFamily(id) {
            // Show loading
            showLoading();
            
            // Get family data from DOM as fallback
            const button = event.target.closest('button');
            const familyCard = button.closest('.bg-white');
            
            if (familyCard) {
                // Extract data from DOM
                const name = familyCard.querySelector('h3').textContent.trim();
                const branch = familyCard.querySelector('.text-gray-500').textContent.trim();
                const colorElement = familyCard.querySelector('.rounded-full');
                
                // Get color from style attribute or computed style
                let hexColor = '#3B82F6';
                if (colorElement) {
                    const styleColor = colorElement.style.backgroundColor;
                    if (styleColor) {
                        if (styleColor.startsWith('#')) {
                            hexColor = styleColor;
                        } else if (styleColor.startsWith('rgb')) {
                            const rgb = styleColor.match(/\d+/g);
                            if (rgb && rgb.length >= 3) {
                                hexColor = `#${parseInt(rgb[0]).toString(16).padStart(2, '0')}${parseInt(rgb[1]).toString(16).padStart(2, '0')}${parseInt(rgb[2]).toString(16).padStart(2, '0')}`;
                            }
                        }
                    }
                }
                
                // Populate form with DOM data
                document.getElementById('editFamilyName').value = name;
                document.getElementById('editFamilyBranch').value = branch;
                document.getElementById('editFamilyColor').value = hexColor;
                document.getElementById('editFamilyDescription').value = '';
                
                // Set form action
                document.getElementById('editFamilyForm').action = `/families/${id}`;
                
                hideLoading();
                
                // Show modal
                document.getElementById('editFamilyModal').classList.remove('hidden');
                
                // Try to fetch full data via AJAX in background
                fetchFamilyDataBackground(id);
            } else {
                hideLoading();
                showAlert('Gagal mengambil data keluarga. Silakan refresh halaman dan coba lagi.');
            }
        }

        // Background fetch for complete data
        function fetchFamilyDataBackground(id) {
            // Try to get complete data via AJAX
            fetch(`/families/${id}/edit`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': getCSRFToken()
                }
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                }
                throw new Error('Network response was not ok');
            })
            .then(data => {
                // Update form with complete data if modal is still open
                if (!document.getElementById('editFamilyModal').classList.contains('hidden')) {
                    if (data.name) document.getElementById('editFamilyName').value = data.name;
                    if (data.branch) document.getElementById('editFamilyBranch').value = data.branch;
                    if (data.color) document.getElementById('editFamilyColor').value = data.color;
                    if (data.description) document.getElementById('editFamilyDescription').value = data.description;
                }
            })
            .catch(error => {
                // Silently fail - we already have basic data from DOM
                console.log('Background fetch failed, using DOM data:', error);
            });
        }

        function closeEditModal() {
            document.getElementById('editFamilyModal').classList.add('hidden');
        }

        // Delete Function
        function deleteFamily(id) {
            if (confirm('Apakah Anda yakin ingin menghapus keluarga ini? Semua anggota keluarga juga akan ikut terhapus.')) {
                showLoading();
                
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/families/${id}`;
                
                form.innerHTML = `
                    <input type="hidden" name="_token" value="${getCSRFToken()}">
                    <input type="hidden" name="_method" value="DELETE">
                `;
                
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Close modals when clicking outside
        document.getElementById('addFamilyModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAddModal();
            }
        });

        document.getElementById('editFamilyModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });

        // Close modals with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAddModal();
                closeEditModal();
            }
        });

        // Auto-open modal if there are validation errors
        @if($errors->any())
            document.getElementById('addFamilyModal').classList.remove('hidden');
        @endif

        // Form submission with loading state
        document.getElementById('editFamilyForm').addEventListener('submit', function() {
            showLoading();
        });

        document.querySelector('#addFamilyModal form').addEventListener('submit', function() {
            showLoading();
        });
    </script>
</body>
</html>