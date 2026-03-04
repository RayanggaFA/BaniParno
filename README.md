# 👨‍👩‍👧‍👦 Family Management System

![Laravel](https://img.shields.io/badge/Laravel-10.x-red?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.1+-blue?style=flat-square&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0-orange?style=flat-square&logo=mysql)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)
![Tests](https://img.shields.io/badge/Tests-Passing-brightgreen?style=flat-square)

Sistem manajemen keluarga berbasis web yang memungkinkan keluarga untuk mengelola data anggota keluarga, membuat pohon keluarga (family tree), dan melacak silsilah keluarga dengan mudah.

## 📋 Daftar Isi

- [Fitur Utama](#-fitur-utama)
- [Demo](#-demo)
- [Teknologi](#-teknologi)
- [Persyaratan](#-persyaratan)
- [Instalasi](#-instalasi)
- [Konfigurasi](#-konfigurasi)
- [Testing](#-testing)
- [Struktur Database](#-struktur-database)
- [API Documentation](#-api-documentation)
- [Kontribusi](#-kontribusi)
- [Lisensi](#-lisensi)
- [Kontak](#-kontak)

## ✨ Fitur Utama

### 🏠 **Manajemen Keluarga**
- ✅ Registrasi dan autentikasi keluarga
- ✅ Profil keluarga dengan foto dan deskripsi
- ✅ Update informasi keluarga
- ✅ Hapus keluarga (dengan cascade delete anggota)

### 👥 **Manajemen Anggota**
- ✅ Tambah anggota keluarga
- ✅ Edit data anggota (nama, foto, tempat/tanggal lahir, pekerjaan, dll)
- ✅ Hapus anggota dengan validasi (tidak bisa hapus jika punya anak)
- ✅ Upload foto profil anggota
- ✅ Relasi parent-child untuk silsilah

### 🌳 **Pohon Keluarga**
- ✅ Visualisasi pohon keluarga interaktif
- ✅ Generasi keluarga (generation tracking)
- ✅ Relasi orang tua dan anak

### 📊 **Riwayat Aktivitas**
- ✅ Log aktivitas CRUD keluarga dan anggota
- ✅ Tracking perubahan data

### 🔒 **Keamanan**
- ✅ Authentication dengan custom guard
- ✅ Authorization (family hanya bisa manage data sendiri)
- ✅ CSRF protection
- ✅ Password hashing (bcrypt)

## 🎬 Demo

**Screenshot:**

![Dashboard](docs/screenshots/dashboard.png)
![Family Tree](docs/screenshots/family-tree.png)
![Member Management](docs/screenshots/members.png)

**Live Demo:** [Coming Soon]

## 🛠 Teknologi

### **Backend**
- **Framework:** Laravel 10.x
- **Language:** PHP 8.1+
- **Database:** MySQL 8.0
- **Authentication:** Laravel Custom Guard
- **Storage:** Laravel Storage (Public Disk)

### **Frontend**
- **Template Engine:** Blade
- **CSS Framework:** Tailwind CSS / Bootstrap
- **JavaScript:** Alpine.js / Vanilla JS

### **Testing**
- **Framework:** PHPUnit
- **Coverage:** 100% for CRUD operations

## 📦 Persyaratan

Pastikan sistem Anda memiliki:

- **PHP** >= 8.1
- **Composer** >= 2.0
- **MySQL** >= 8.0 atau **MariaDB** >= 10.3
- **Node.js** >= 16.x (untuk asset compilation)
- **NPM** atau **Yarn**
