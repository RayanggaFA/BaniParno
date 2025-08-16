<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bani Parno</title>
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
            background: linear-gradient(rgba(0, 0, 139, 1 ), rgba(15, 62, 164, 0.7)), 
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
            background: rgba(37, 99, 235, 0.8);
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
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Montserrat', sans-serif;
        }
        
        p, span, div, a, button {
            font-family: 'Montserrat', sans-serif;
        }
        
        .blue-gradient {
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 50%, #60a5fa 100%);
        }
        
        .section-bg {
            background: linear-gradient(135deg, #1e40af 0%, #2563eb 100%);
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(37, 99, 235, 0.3);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-200 text-slate-800">

    <!-- Hero Section -->
    <section class="hero-bg min-h-screen flex items-center justify-center relative">
        <div class="text-center max-w-4xl mx-auto px-4">
            <h1 class="text-5xl md:text-7xl font-bold mb-8 leading-tight text-white drop-shadow-lg">
                Bani Parno
            </h1>
            <p class="text-xl md:text-2xl text-blue-100 mb-12 max-w-2xl mx-auto">
                Website Database Bani Parno
            </p>
            
            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{ route('families.index') }}" class="bg-white text-blue-600 px-8 py-4 rounded-lg font-bold hover:bg-blue-50 transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <i class="fas fa-users mr-2"></i>
                    LIHAT KELUARGA
                </a>
                <a href="{{ route('members.index') }}" class="border-2 border-white text-white px-8 py-4 rounded-lg font-bold hover:bg-white hover:text-blue-600 transition-all duration-300 shadow-lg">
                    <i class="fas fa-user-friends mr-2"></i>
                    DAFTAR ANGGOTA
                </a>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <i class="fas fa-chevron-down text-white text-2xl drop-shadow-lg"></i>
        </div>
    </section>

    <!-- Families Overview Section -->
    <section class="py-20 section-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-white mb-4">Bani Parno</h2>
            </div>

                <div class="text-center bg-white bg-opacity-10 backdrop-blur-lg rounded-xl p-8 card-hover">
                    <div class="text-4xl font-bold text-white mb-2">{{ $totalMembers ?? 0 }}</div>
                    <div class="text-blue-100">Total Anggota</div>
                </div>
                <div class="text-center bg-white bg-opacity-10 backdrop-blur-lg rounded-xl p-8 card-hover">
                    <div class="text-4xl font-bold text-white mb-2">{{ $totalGenerations ?? 5 }}</div>
                    <div class="text-blue-100">Generasi</div>
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