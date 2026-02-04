# TODO - Staff Access Restriction - COMPLETED

## Task: Staff hanya bisa VIEW, tidak bisa CREATE/EDIT/DELETE

### 1. Routes Configuration ✓
- [x] Modifikasi routes/web.php - pisahkan route owner-only dan shared

### 2. Items Module ✓
- [x] Update view admin/items/index.blade.php - sembunyikan tombol CRUD
- [x] Update view admin/items/create.blade.php - dilindungi middleware owner
- [x] Update view admin/items/edit.blade.php - dilindungi middleware owner
- [x] Update controller Admin/ItemController.php - tambahkan middleware owner-only

### 3. Categories Module ✓
- [x] Update view admin/categories/index.blade.php
- [x] Update view admin/categories/create.blade.php - dilindungi middleware owner
- [x] Update view admin/categories/edit.blade.php - dilindungi middleware owner
- [x] Update controller Admin/CategoryController.php

### 4. Units Module ✓
- [x] Update view admin/units/index.blade.php
- [x] Update view admin/units/create.blade.php - dilindungi middleware owner
- [x] Update view admin/units/edit.blade.php - dilindungi middleware owner
- [x] Update controller Admin/UnitController.php

### 5. Locations Module ✓
- [x] Update view admin/locations/index.blade.php
- [x] Update view admin/locations/create.blade.php - dilindungi middleware owner
- [x] Update view admin/locations/edit.blade.php - dilindungi middleware owner
- [x] Update controller Admin/LocationController.php

### 6. Suppliers Module ✓
- [x] Update view admin/suppliers/index.blade.php
- [x] Update view admin/suppliers/create.blade.php - dilindungi middleware owner
- [x] Update view admin/suppliers/edit.blade.php - dilindungi middleware owner
- [x] Update controller Admin/SupplierController.php

### 7. Stock In/Out Module ✓
- [x] Update view admin/stock-in/index.blade.php
- [x] Update view admin/stock-out/index.blade.php
- [x] Update controller Admin/StockInController.php
- [x] Update controller Admin/StockOutController.php

### 8. Borrowings Module ✓
- [x] Update view admin/borrowings/index.blade.php
- [x] Update controller Admin/BorrowingController.php

### 9. Notifications Module ✓
- [x] Update view admin/notifications/index.blade.php
- [x] Update controller Admin/NotificationController.php

### 10. Sandbox Module ✓
- [x] Update view admin/sandbox/index.blade.php
- [x] Update view admin/sandbox/show.blade.php
- [x] Update controller Admin/SandboxController.php

---

## Ringkasan Perubahan:

### Implementasi Role-Based Access Control:

1. **Middleware**: Semua controller admin (Items, Categories, Units, Locations, Suppliers, StockIn, StockOut, Borrowings, Notifications, Sandbox) sudah ditambahkan middleware `role:owner` pada method create, store, edit, update, dan destroy.

2. **Routes**: Routes sudah dipisahkan menjadi:
   - **Shared Routes** (bisa diakses owner & staff): index, show
   - **Owner-only Routes** (hanya owner): create, store, edit, update, delete

3. **Views**: Semua halaman index sudah dilengkapi dengan pengecekan `@if(auth()->user()->isOwner())` untuk menyembunyikan tombol aksi (Tambah, Edit, Hapus) dari staff.

### Hasil:
- **Owner (Admin)**: Akses penuh (Create, Read, Update, Delete)
- **Staff**: Hanya bisa melihat data saja (Read-only), tidak bisa Create/Edit/Delete

