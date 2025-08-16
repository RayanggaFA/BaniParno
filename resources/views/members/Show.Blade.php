<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $member->name }} - Profil Anggota</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .profile-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .social-link {
            transition: all 0.3s ease;
        }
        .social-link:hover {
            transform: translateY(-2px);
        }
        .info-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
        .badge {
            background: linear-gradient(45deg, #667eea, #764ba2);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('families.show', $member->family) }}" class="flex items-center text-gray-600 hover:text-blue-600">
                        <i class="fas fa-arrow-left mr-2"></i>
                        <span>Kembali ke {{ $member->family->name }}</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('families.index') }}" class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">
                        <i class="fas fa-home mr-1"></i> Keluarga
                    </a>
                    <a href="{{ route('members.index') }}" class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">
                        <i class="fas fa-user-friends mr-1"></i> Anggota
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Sidebar - Profile Card -->
            <div class="lg:col-span-1">
                <div class="profile-card rounded-xl shadow-2xl overflow-hidden">
                    <div class="p-8 text-center text-white">
                        <!-- Profile Photo -->
                        <div class="mb-6">
                            <div class="w-32 h-32 mx-auto rounded-full overflow-hidden border-4 border-white shadow-lg">
                                @if($member->photo)
                                <img src="{{ asset('storage/' . $member->photo_url) }}" alt="{{ $member->name }}" 
                                     class="w-full h-full object-cover">
                                @else
                                <div class="w-full h-full bg-white bg-opacity-20 flex items-center justify-center">
                                    <i class="fas fa-user text-white text-4xl"></i>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Basic Info -->
                        <h1 class="text-3xl font-bold mb-2">{{ $member->name }}</h1>
                        <p class="text-lg opacity-90 mb-1">{{ $member->nickname ?? $member->name }}</p>
                        <p class="text-sm opacity-75 mb-4">{{ $member->job ?? 'Pekerjaan tidak disebutkan' }}</p>

                        <!-- Status Badge -->
                        <div class="mb-6">
                            <span class="px-4 py-2 rounded-full text-sm font-medium
                                {{ $member->status == 'active' ? 'bg-green-500 bg-opacity-20 text-green-100 border border-green-400' : 
                                   ($member->status == 'inactive' ? 'bg-yellow-500 bg-opacity-20 text-yellow-100 border border-yellow-400' : 'bg-gray-500 bg-opacity-20 text-gray-100 border border-gray-400') }}">
                                <i class="fas fa-circle text-xs mr-1"></i>
                                {{ $member->status == 'active' ? 'Aktif' : 
                                   ($member->status == 'inactive' ? 'Tidak Aktif' : 'Almarhum') }}
                            </span>
                        </div>

                        <!-- Quick Stats -->
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="bg-white bg-opacity-10 rounded-lg p-3">
                                <div class="text-2xl font-bold">{{ $member->age }}</div>
                                <div class="text-sm opacity-75">Tahun</div>
                            </div>
                            <div class="bg-white bg-opacity-10 rounded-lg p-3">
                                <div class="text-2xl font-bold">
                                    <i class="fas fa-{{ $member->gender == 'male' ? 'mars text-blue-300' : 'venus text-pink-300' }}"></i>
                                </div>
                                <div class="text-sm opacity-75">{{ $member->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</div>
                            </div>
                        </div>

                        <!-- Edit Button -->
                        <a href="{{ route('members.edit', $member) }}" 
                           class="inline-flex items-center px-6 py-3 bg-white bg-opacity-20 hover:bg-opacity-30 text-white font-medium rounded-lg transition-all duration-300 backdrop-blur-sm">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Profil
                        </a>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-address-card mr-2 text-blue-500"></i>
                        Informasi Kontak
                    </h3>
                    
                    <div class="space-y-3">
                        @if($member->phone)
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-phone w-5 text-center mr-3 text-green-500"></i>
                            <span>{{ $member->phone }}</span>
                        </div>
                        @endif
                        
                        @if($member->email)
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-envelope w-5 text-center mr-3 text-red-500"></i>
                            <a href="mailto:{{ $member->email }}" class="hover:text-blue-600">{{ $member->email }}</a>
                        </div>
                        @endif
                        
                        @if($member->address)
                        <div class="flex items-start text-gray-600">
                            <i class="fas fa-map-marker-alt w-5 text-center mr-3 text-purple-500 mt-1"></i>
                            <span>{{ $member->address }}</span>
                        </div>
                        @endif
                        
                        @if($member->domicile_city)
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-city w-5 text-center mr-3 text-indigo-500"></i>
                            <span>{{ $member->domicile_city }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Social Links -->
                @if($member->socialLinks && $member->socialLinks->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-share-alt mr-2 text-blue-500"></i>
                        Media Sosial
                    </h3>
                    
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($member->socialLinks as $link)
                        <a href="{{ $link->url }}" target="_blank" 
                           class="social-link flex items-center p-3 rounded-lg border-2 border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-all duration-300">
                            <i class="fab fa-{{ $link->platform }} text-xl mr-3 
                                {{ $link->platform == 'facebook' ? 'text-blue-600' : 
                                   ($link->platform == 'instagram' ? 'text-pink-600' : 
                                   ($link->platform == 'twitter' ? 'text-blue-400' : 
                                   ($link->platform == 'linkedin' ? 'text-blue-700' : 'text-gray-600'))) }}"></i>
                            <span class="text-sm font-medium capitalize">{{ $link->platform }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Content Area -->
            <div class="lg:col-span-2">
                <!-- Family Information -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                            <i class="fas fa-users mr-3 text-blue-500"></i>
                            Informasi Keluarga
                        </h2>
                        <a href="{{ route('families.show', $member->family) }}" 
                           class="text-blue-600 hover:text-blue-800 font-medium">
                            Lihat Keluarga <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="info-card rounded-lg p-4 border-l-4 border-blue-500">
                            <div class="flex items-center mb-2">
                                <div class="w-4 h-4 rounded-full mr-3" style="background-color: {{ $member->family->color }}"></div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $member->family->name }}</h3>
                            </div>
                            <p class="text-gray-600">{{ $member->family->branch }}</p>
                            <div class="mt-3 flex items-center text-sm text-gray-500">
                                <i class="fas fa-users mr-1"></i>
                                {{ $member->family->members->count() }} Anggota
                            </div>
                        </div>

                        @if($member->family->description)
                        <div class="info-card rounded-lg p-4 border-l-4 border-green-500">
                            <h4 class="font-semibold text-gray-900 mb-2">Deskripsi Keluarga</h4>
                            <p class="text-gray-600 text-sm">{{ $member->family->description }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Personal Details -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-id-card mr-3 text-green-500"></i>
                        Detail Personal
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Personal Information -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Informasi Dasar</h3>
                            
                            @if($member->birth_date)
                            <div class="flex justify-between py-2 border-b border-gray-100">
                                <span class="text-gray-600">Tanggal Lahir:</span>
                                <span class="font-medium">{{ \Carbon\Carbon::parse($member->birth_date)->format('d F Y') }}</span>
                            </div>
                            @endif

                            @if($member->birth_place)
                            <div class="flex justify-between py-2 border-b border-gray-100">
                                <span class="text-gray-600">Tempat Lahir:</span>
                                <span class="font-medium">{{ $member->birth_place }}</span>
                            </div>
                            @endif

                            <div class="flex justify-between py-2 border-b border-gray-100">
                                <span class="text-gray-600">Jenis Kelamin:</span>
                                <span class="font-medium">{{ $member->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</span>
                            </div>

                            <div class="flex justify-between py-2 border-b border-gray-100">
                                <span class="text-gray-600">Usia:</span>
                                <span class="font-medium">{{ $member->age }} tahun</span>
                            </div>
                        </div>

                        <!-- Professional Information -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Informasi Profesi</h3>
                            
                            @if($member->job)
                            <div class="flex justify-between py-2 border-b border-gray-100">
                                <span class="text-gray-600">Pekerjaan:</span>
                                <span class="font-medium">{{ $member->job }}</span>
                            </div>
                            @endif

                            @if($member->education)
                            <div class="flex justify-between py-2 border-b border-gray-100">
                                <span class="text-gray-600">Pendidikan:</span>
                                <span class="font-medium">{{ $member->education }}</span>
                            </div>
                            @endif

                            @if($member->skills)
                            <div class="py-2">
                                <span class="text-gray-600 block mb-2">Keahlian:</span>
                                <div class="flex flex-wrap gap-2">
                                    @foreach(explode(',', $member->skills) as $skill)
                                    <span class="badge text-white px-3 py-1 rounded-full text-sm">{{ trim($skill) }}</span>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Biography/Notes -->
                @if($member->biography || $member->notes)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-book mr-3 text-purple-500"></i>
                        Tentang {{ $member->name }}
                    </h2>

                    @if($member->biography)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Biografi</h3>
                        <div class="prose max-w-none text-gray-700">
                            {!! nl2br(e($member->biography)) !!}
                        </div>
                    </div>
                    @endif

                    @if($member->notes)
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Catatan</h3>
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                            <div class="text-gray-700">
                                {!! nl2br(e($member->notes)) !!}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-6 py-3 rounded-lg shadow-lg z-50" id="successMessage">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <span>{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <script>
        // Auto hide success message
        const successMessage = document.getElementById('successMessage');
        if (successMessage) {
            setTimeout(() => {
                successMessage.style.transition = 'opacity 0.5s ease-out';
                successMessage.style.opacity = '0';
                setTimeout(() => {
                    successMessage.remove();
                }, 500);
            }, 3000);
        }

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>