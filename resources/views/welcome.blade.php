<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Silsilah Keluarga</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            font-family: 'Montserrat', sans-serif;
        }
        
        .hero-bg {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                        url('https://images.unsplash.com/photo-1511895426328-dc8714191300?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        
        .signature-font {
            font-family: 'Montserrat', sans-serif;
            font-style: italic;
            font-weight: 300;
        }
        
        .close-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Montserrat', sans-serif;
        }
        
        p, span, div, a, button {
            font-family: 'Montserrat', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-900 text-white">

    <!-- Hero Section -->
    <section class="hero-bg min-h-screen flex items-center justify-center relative">
        <div class="text-center max-w-4xl mx-auto px-4">
            <h1 class="text-5xl md:text-7xl font-bold mb-8 leading-tight">
                Bani Parno
            </h1>
            <p class="text-xl md:text-2xl text-gray-300 mb-12 max-w-2xl mx-auto">
                Website Database Bani Parno
            </p>
            
            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{ route('families.index') }}" class="bg-yellow-400 text-black px-8 py-4 rounded-lg font-bold hover:bg-yellow-300 transition-colors duration-300 transform hover:scale-105">
                    <i class="fas fa-users mr-2"></i>
                    LIHAT KELUARGA
                </a>
                <a href="{{ route('members.index') }}" class="border-2 border-white text-white px-8 py-4 rounded-lg font-bold hover:bg-white hover:text-black transition-colors duration-300">
                    <i class="fas fa-user-friends mr-2"></i>
                    DAFTAR ANGGOTA
                </a>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <i class="fas fa-chevron-down text-white text-2xl"></i>
        </div>
    </section>

    <!-- Families Overview Section -->
    <section class="py-20 bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-white mb-4">Cabang Keluarga</h2>
                <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                    Temukan berbagai cabang keluarga dan jelajahi sejarah serta anggota dari setiap generasi
                </p>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <div class="text-center">
                    <div class="text-4xl font-bold text-yellow-400 mb-2">{{ $totalFamilies ?? 0 }}</div>
                    <div class="text-gray-400">Cabang Keluarga</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-yellow-400 mb-2">{{ $totalMembers ?? 0 }}</div>
                    <div class="text-gray-400">Total Anggota</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-yellow-400 mb-2">{{ $totalGenerations ?? 5 }}</div>
                    <div class="text-gray-400">Generasi</div>
                </div>
            </div>


        </div>
    </section>

    <!-- JavaScript -->
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Placeholder functions for modal (you'll need to implement these)
        function openAddModal() {
            alert('Modal tambah keluarga akan dibuka di sini');
            // Implement your modal logic here
        }

        function editFamily(id) {
            alert('Edit keluarga ID: ' + id);
            // Implement your edit logic here
        }

        function deleteFamily(id) {
            if (confirm('Apakah Anda yakin ingin menghapus keluarga ini?')) {
                // Implement your delete logic here
                alert('Hapus keluarga ID: ' + id);
            }
        }
    </script>
</body>
</html>