# Laravel CRUD dengan JWT Authentication
# PT Uniktif Media Indonesia

## Deskripsi Proyek

Proyek ini merupakan aplikasi sederhana berbasis Laravel yang mengimplementasikan fitur CRUD (Create, Read, Update, Delete) untuk data User. Setiap User memiliki relasi one-to-many dengan Hobi. Aplikasi ini menggunakan Blade untuk tampilan UI dan menyediakan API endpoints untuk operasi CRUD yang dilindungi oleh JWT Authentication.

## Fitur Utama

* **CRUD User:**
    * Menambahkan User baru beserta daftar hobinya
    * Memperbarui data User (termasuk menambah atau menghapus hobi)
    * Menghapus User beserta hobinya
* **Relasi One-to-Many:** Setiap User dapat memiliki banyak Hobi
* **Autentikasi:** JWT Authentication untuk mengamankan akses ke API endpoints
* **Tampilan:**
    * Form input data User dan daftar hobi
    * Tabel daftar User dan hobinya
    * Tombol aksi Edit dan Delete untuk setiap User
* **API:**
    * Endpoints untuk operasi CRUD User
    * Menggunakan JWT Authentication untuk keamanan

## Cara Penggunaan

### Persyaratan
* PHP (versi sesuai dengan Laravel)
* Composer
* Node.js (untuk asset compilation, jika menggunakan frontend framework)

### Instalasi
1. **Clone repository:**
   ```bash
   git clone [https://github.com/sidikimamsetiyawan/unictive-users.git](https://github.com/sidikimamsetiyawan/unictive-users.git)
   ```
2. **Install dependencies:**
   ```bash
   cd your-project
    npm install
   ```
4. **Generate key:**
   ```bash
   php artisan key:generate
   ```
6. **Database migration:**
   ```bash
   php artisan migrate
   ```
8. **Start development server:**
   ```bash
   npm run dev
   ```
## Screenshots
### Screen Login
![image](https://github.com/user-attachments/assets/7f8123dd-391b-4c11-adfd-15bc11fe8240)

### Dashboard
![image](https://github.com/user-attachments/assets/9d015e83-67e9-499a-9387-a984bb5cf95c)

### User Management
![image](https://github.com/user-attachments/assets/93f8831d-e27a-47e8-8576-481b1d4e58d0)

### Role Management
![image](https://github.com/user-attachments/assets/009aca4f-ea2b-455f-9aa1-bc6c789d6a87)

### Hobby Management
