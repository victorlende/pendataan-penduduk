# API Documentation - Aplikasi Pendataan Penduduk

## Base URL

```
http://localhost/api
```

## Authentication

API menggunakan Laravel Sanctum untuk authentication. Token harus disertakan di header:

```
Authorization: Bearer {token}
```

---

## Endpoints

### 1. Login

**POST** `/login`

Login untuk petugas RT/RW

**Request Body:**

```json
{
    "email": "petugas001@example.com",
    "password": "password",
    "device_name": "Xiaomi Redmi Note 10"
}
```

**Response (200):**

```json
{
    "success": true,
    "message": "Login berhasil",
    "data": {
        "user": {
            "id": 2,
            "name": "Petugas RT 001",
            "email": "petugas001@example.com",
            "role": "petugas",
            "rt_rw": "001/001"
        },
        "token": "1|abcdefghijklmnopqrstuvwxyz"
    }
}
```

---

### 2. Logout

**POST** `/logout`

**Headers:**

```
Authorization: Bearer {token}
```

**Response (200):**

```json
{
    "success": true,
    "message": "Logout berhasil"
}
```

---

### 3. Get Current User

**GET** `/me`

**Headers:**

```
Authorization: Bearer {token}
```

**Response (200):**

```json
{
    "success": true,
    "data": {
        "id": 2,
        "name": "Petugas RT 001",
        "email": "petugas001@example.com",
        "role": "petugas",
        "rt_rw": "001/001"
    }
}
```

---

### 4. Get List Penduduk

**GET** `/penduduk`

**Headers:**

```
Authorization: Bearer {token}
```

**Query Parameters:**

-   `search` (optional): Cari berdasarkan NIK/Nama/No KK
-   `is_synced` (optional): Filter by sync status (0/1)
-   `per_page` (optional): Jumlah data per halaman (default: 20)
-   `page` (optional): Nomor halaman

**Response (200):**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "uuid": "550e8400-e29b-41d4-a716-446655440000",
            "nik": "3201010101010001",
            "no_kk": "3201010101010001",
            "nama_lengkap": "Budi Santoso",
            "jenis_kelamin": "L",
            "tempat_lahir": "Jakarta",
            "tanggal_lahir": "1990-01-01",
            "agama": "Islam",
            "pendidikan_terakhir": "S1",
            "pekerjaan": "Karyawan Swasta",
            "status_perkawinan": "Kawin",
            "rt_rw": "001/001",
            "alamat_lengkap": "Jl. Merdeka No. 123",
            "no_telp": "08123456789",
            "photo_ktp": "ktp/abc123.jpg",
            "is_synced": true,
            "synced_at": "2025-11-01T10:30:00.000000Z",
            "creator": {
                "id": 2,
                "name": "Petugas RT 001"
            }
        }
    ],
    "meta": {
        "current_page": 1,
        "last_page": 5,
        "per_page": 20,
        "total": 100
    }
}
```

---

### 5. Create Penduduk

**POST** `/penduduk`

**Headers:**

```
Authorization: Bearer {token}
```

**Request Body:**

```json
{
    "nik": "3201010101010001",
    "no_kk": "3201010101010001",
    "nama_lengkap": "Budi Santoso",
    "jenis_kelamin": "L",
    "tempat_lahir": "Jakarta",
    "tanggal_lahir": "1990-01-01",
    "agama": "Islam",
    "pendidikan_terakhir": "S1",
    "pekerjaan": "Karyawan Swasta",
    "status_perkawinan": "Kawin",
    "rt_rw": "001/001",
    "alamat_lengkap": "Jl. Merdeka No. 123",
    "no_telp": "08123456789",
    "photo_ktp": "data:image/jpeg;base64,/9j/4AAQSkZJRg..."
}
```

**Response (201):**

```json
{
  "success": true,
  "message": "Data penduduk berhasil ditambahkan",
  "data": {
    "id": 1,
    "uuid": "550e8400-e29b-41d4-a716-446655440000",
    "nik": "3201010101010001",
    ...
  }
}
```

---

### 6. **Sync Penduduk (FITUR INTI!)**

**POST** `/sync/penduduk`

Endpoint ini untuk sinkronisasi data dari mobile (SQLite) ke server (MySQL)

**Headers:**

```
Authorization: Bearer {token}
```

**Request Body:**

```json
{
    "device_id": "unique-device-identifier-123",
    "sync_items": [
        {
            "uuid": "550e8400-e29b-41d4-a716-446655440000",
            "action": "create",
            "data": {
                "nik": "3201010101010001",
                "no_kk": "3201010101010001",
                "nama_lengkap": "Budi Santoso",
                "jenis_kelamin": "L",
                "tempat_lahir": "Jakarta",
                "tanggal_lahir": "1990-01-01",
                "agama": "Islam",
                "pekerjaan": "Karyawan Swasta",
                "status_perkawinan": "Kawin",
                "rt_rw": "001/001",
                "alamat_lengkap": "Jl. Merdeka No. 123",
                "no_telp": "08123456789",
                "photo_ktp": "data:image/jpeg;base64,..."
            }
        },
        {
            "uuid": "660e8400-e29b-41d4-a716-446655440001",
            "action": "update",
            "data": {
                "nama_lengkap": "Siti Aminah Updated",
                "no_telp": "08129999999"
            }
        }
    ]
}
```

**Response (200):**

```json
{
    "success": true,
    "message": "Sinkronisasi selesai: 2 berhasil, 0 gagal",
    "data": {
        "total": 2,
        "success_count": 2,
        "failed_count": 0,
        "results": [
            {
                "uuid": "550e8400-e29b-41d4-a716-446655440000",
                "success": true,
                "message": "Data berhasil disinkronkan",
                "server_id": 123,
                "synced_at": "2025-11-01T10:35:00+00:00"
            },
            {
                "uuid": "660e8400-e29b-41d4-a716-446655440001",
                "success": true,
                "message": "Data berhasil diupdate",
                "server_id": 124,
                "synced_at": "2025-11-01T10:35:01+00:00"
            }
        ]
    }
}
```

---

### 7. Get Sync Logs

**GET** `/sync/logs`

**Headers:**

```
Authorization: Bearer {token}
```

**Response (200):**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "user_id": 2,
            "device_id": "unique-device-123",
            "action": "sync",
            "table_name": "penduduk",
            "record_count": 5,
            "success_count": 5,
            "failed_count": 0,
            "errors": null,
            "created_at": "2025-11-01T10:35:00.000000Z",
            "user": {
                "id": 2,
                "name": "Petugas RT 001",
                "rt_rw": "001/001"
            }
        }
    ],
    "meta": {
        "current_page": 1,
        "last_page": 1,
        "per_page": 20,
        "total": 1
    }
}
```

---

## Error Responses

### 401 Unauthorized

```json
{
    "message": "Unauthenticated."
}
```

### 403 Forbidden

```json
{
    "success": false,
    "message": "Hanya petugas RT/RW yang dapat login di aplikasi mobile."
}
```

### 422 Validation Error

```json
{
    "success": false,
    "message": "Validasi gagal",
    "errors": {
        "nik": ["The nik field is required."]
    }
}
```

### 404 Not Found

```json
{
    "success": false,
    "message": "Data penduduk tidak ditemukan"
}
```

---

## Testing dengan Postman

### 1. Login

```
POST http://localhost/api/login
Body (JSON):
{
  "email": "petugas001@example.com",
  "password": "password",
  "device_name": "My Phone"
}
```

### 2. Copy token dari response

### 3. Test endpoint lain dengan token

```
GET http://localhost/api/penduduk
Headers:
Authorization: Bearer {paste-token-here}
```

---

## Database Seeder

Untuk testing, jalankan seeder:

```bash
php artisan migrate:fresh --seed
```

Akun dummy:

-   Admin: admin@example.com / password
-   Petugas RT 001: petugas001@example.com / password
-   Petugas RT 002: petugas002@example.com / password
-   Petugas RT 003: petugas003@example.com / password
