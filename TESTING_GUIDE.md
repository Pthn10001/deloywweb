# 📋 Hướng Dẫn Kiểm Thử Tự Động WebClothing

## 📌 Thứ Tự Kiểm Thử

---

## ✅ **1. KIỂM THỬ HOMEPAGE**

### 1.1 Kiểm Thử Tải Trang
- [ ] Mở http://localhost:8090
- [ ] Trang load thành công (HTTP 200)
- [ ] Không có lỗi JavaScript trong console

**Kết quả mong đợi:** 
- Trang hiển thị bình thường
- Header, navbar, footer hiển thị đúng

---

### 1.2 Kiểm Thử Hiển Thị Sản Phẩm
- [ ] Kiểm tra sản phẩm hiển thị đầy đủ trong carousel
- [ ] Mỗi sản phẩm có: tên, giá, hình ảnh
- [ ] Số lượng sản phẩm hiển thị = số sản phẩm trong DB

**Kiểm tra cụ thể:**
```
SELECT COUNT(*) FROM tbl_product WHERE product_status = 0;
```

**Kết quả mong đợi:** 
- Số sản phẩm trên trang = số trong DB

---

### 1.3 Kiểm Thử Danh Mục (Categories)
- [ ] 4 danh mục hiển thị đúng
- [ ] Mỗi danh mục có tên và icon
- [ ] Click danh mục → chuyển sang trang danh mục

**Kết quả mong đợi:**
- Danh mục hiển thị, không có lỗi

---

### 1.4 Kiểm Thử Meta Tags & SEO
- [ ] Kiểm tra HTML source:
  - `<title>` tag
  - `<meta name="description">`
  - `<meta name="keywords">`

**Cách kiểm tra:** Nhấn Ctrl+U xem source code

**Kết quả mong đợi:**
```html
<title>WebClothing - Cửa hàng thời trang</title>
<meta name="description" content="...">
<meta name="keywords" content="...">
```

---

## ✅ **2. KIỂM THỬ CHI TIẾT SẢN PHẨM**

### 2.1 Truy Cập Trang Chi Tiết
- [ ] Click một sản phẩm trên homepage
- [ ] URL: http://localhost:8090/details-product/{id}
- [ ] Trang load thành công

**Kết quả mong đợi:**
- Trang hiển thị chi tiết sản phẩm
- Không có lỗi 404

---

### 2.2 Kiểm Thử Thông Tin Sản Phẩm
- [ ] Tên sản phẩm hiển thị đúng
- [ ] Giá hiển thị đúng
- [ ] Hình ảnh sản phẩm load đúng
- [ ] Tồn kho (Quantity) hiển thị đúng

**Kết quả mong đợi:**
- Tất cả thông tin khớp với DB

---

### 2.3 Kiểm Thử Chọn Size
- [ ] 4 option size: S, M, L, XL đều có
- [ ] Click mỗi size - có visual feedback
- [ ] Default size được chọn

**Kết quả mong đợi:**
```
Radio button selected/unselected hoạt động
```

---

### 2.4 Kiểm Thử Hover Effects
- [ ] Hover vào hình ảnh → zoom in
- [ ] Hover vào button → color change
- [ ] Smooth animation (không bị giật)

**Kết quả mong đợi:**
- Hover effects chạy mượt mà

---

### 2.5 Kiểm Thử Thêm Vào Giỏ Hàng
- [ ] Nhập số lượng (1-10)
- [ ] Chọn size
- [ ] Click "Thêm vào giỏ"
- [ ] Alert/Toast hiển thị: "Thêm vào giỏ thành công"

**Kiểm tra Session:**
```php
Session()->get('cart')  // Phải có item mới
```

**Kết quả mong đợi:**
- Sản phẩm được thêm vào session cart

---

### 2.6 Kiểm Thử Sản Phẩm Liên Quan
- [ ] Hiển thị 4-6 sản phẩm liên quan
- [ ] Click sản phẩm → chuyển sang chi tiết

**Kết quả mong đợi:**
- Sản phẩm liên quan hiển thị đúng category

---

## ✅ **3. KIỂM THỬ GIỎ HÀNG**

### 3.1 Truy Cập Giỏ Hàng
- [ ] Click icon giỏ hàng trên header
- [ ] URL: http://localhost:8090/cart
- [ ] Trang load thành công

**Kết quả mong đợi:**
- Giỏ hàng hiển thị danh sách sản phẩm

---

### 3.2 Kiểm Thử Hiển Thị Sản Phẩm Trong Giỏ
- [ ] Hiển thị tên sản phẩm
- [ ] Hiển thị giá
- [ ] Hiển thị số lượng
- [ ] Hiển thị size đã chọn
- [ ] Hiển thị tổng tiền mỗi sản phẩm (giá × số lượng)

**Kiểm tra:**
```
Tổng tiền = product_price × product_qty
```

**Kết quả mong đợi:**
- Tính toán giá đúng

---

### 3.3 Kiểm Thử Cập Nhật Số Lượng
- [ ] Thay đổi số lượng sản phẩm
- [ ] Nhấn "Cập nhật"
- [ ] Giá tổng cộng tự động cập nhật

**Kết quả mong đợi:**
```
Tổng tiền mới = product_price × new_qty
```

---

### 3.4 Kiểm Thử Xóa Sản Phẩm
- [ ] Click nút xóa sản phẩm
- [ ] Sản phẩm bị xóa khỏi giỏ
- [ ] Alert xác nhận

**Kết quả mong đợi:**
- Sản phẩm được xóa khỏi session cart

---

### 3.5 Kiểm Thử Tính Toán Tóm Tắt Đơn Hàng
- [ ] **Tạm tính** = tổng giá tất cả sản phẩm
- [ ] **Phí ship** = 0 (miễn phí) hoặc giá trị cụ thể
- [ ] **Tổng tiền** = Tạm tính + Phí ship

**Kết quả mong đợi:**
```
Tổng tiền = Tạm tính + Phí ship
```

---

### 3.6 Kiểm Thử Giỏ Hàng Trống
- [ ] Xóa tất cả sản phẩm
- [ ] Giỏ trống → hiển thị thông báo "Giỏ hàng trống"
- [ ] Nút "Tiếp tục mua sắm" → về homepage

**Kết quả mong đợi:**
- Trạng thái giỏ trống hiển thị đúng

---

## ✅ **4. KIỂM THỬ CHECKOUT**

### 4.1 Truy Cập Trang Checkout
- [ ] Click "Thanh toán" từ giỏ hàng
- [ ] URL: http://localhost:8090/checkout
- [ ] Form checkout hiển thị

**Điều kiện:** Giỏ hàng phải có sản phẩm

**Kết quả mong đợi:**
- Trang checkout load thành công

---

### 4.2 Kiểm Thử Form Validation - Email
- [ ] Bỏ trống email → lỗi "Email là bắt buộc"
- [ ] Email không hợp lệ → lỗi "Email không hợp lệ"
- [ ] Email hợp lệ → không có lỗi

**Kiểm tra:**
```
Nhập: "abc@example.com" → ✓ hợp lệ
Nhập: "abc@" → ✗ lỗi
Bỏ trống → ✗ lỗi
```

**Kết quả mong đợi:**
- Validation hoạt động đúng

---

### 4.3 Kiểm Thử Form Validation - Phone
- [ ] Bỏ trống → lỗi "Điện thoại là bắt buộc"
- [ ] Nhập < 10 số → lỗi "10-11 chữ số"
- [ ] Nhập > 11 số → lỗi "10-11 chữ số"
- [ ] Nhập 10-11 số → ✓ hợp lệ

**Kiểm tra:**
```
Nhập: "0912345678" (10 số) → ✓ hợp lệ
Nhập: "09123456789" (11 số) → ✓ hợp lệ
Nhập: "09" (2 số) → ✗ lỗi
```

**Kết quả mong đợi:**
- Pattern validation hoạt động

---

### 4.4 Kiểm Thử Form Validation - Required Fields
- [ ] Bỏ trống Tên → lỗi
- [ ] Bỏ trống Địa chỉ → lỗi
- [ ] Bỏ trống Phương thức thanh toán → lỗi

**Kết quả mong đợi:**
- Tất cả field required được validate

---

### 4.5 Kiểm Thử Chọn Phương Thức Thanh Toán
- [ ] Radio button 1: "COD (Thanh toán khi nhận hàng)" → ✓
- [ ] Radio button 2: "Chuyển khoản" → ✓
- [ ] Radio button 3: "Thẻ tín dụng" → ✓
- [ ] Chỉ 1 method được chọn tại 1 thời điểm

**Kết quả mong đợi:**
- Radio buttons hoạt động đúng

---

### 4.6 Kiểm Thử Ghi Chú Đơn Hàng (Optional)
- [ ] Bỏ trống ghi chú → vẫn submit được
- [ ] Nhập ghi chú → submit được
- [ ] Ghi chú được lưu vào DB

**Kiểm tra DB:**
```sql
SELECT shipping_notes FROM tbl_shipping 
WHERE shipping_id = (last_shipping_id);
```

**Kết quả mong đợi:**
- Ghi chú được lưu đúng (hoặc rỗng)

---

### 4.7 Kiểm Thử Submit Form (Tạo Đơn Hàng)
- [ ] Điền đầy đủ thông tin hợp lệ
- [ ] Click "Đặt hàng"
- [ ] Đợi response từ server
- [ ] Alert hiển thị: "Đơn hàng được tạo thành công"

**Kiểm tra DB:**
```sql
SELECT * FROM tbl_order ORDER BY created_at DESC LIMIT 1;
SELECT * FROM tbl_order_details WHERE order_code = 'xxx';
SELECT * FROM tbl_shipping WHERE shipping_id = xxx;
```

**Kết quả mong đợi:**
- Đơn hàng được tạo
- Order details được lưu
- Shipping info được lưu

---

### 4.8 Kiểm Thử Dữ Liệu Đơn Hàng
- [ ] Order code được generate (5 ký tự random)
- [ ] Customer ID đúng
- [ ] Tất cả sản phẩm trong giỏ được lưu vào order_details
- [ ] Quantity và size được lưu đúng
- [ ] Timestamp created_at được set

**Kết quả mong đợi:**
```
order_code: "abc12" (hoặc tương tự)
customer_id: xxx
order_status: 1 (new order)
product_sales_qty: đúng
product_size: đúng
```

---

### 4.9 Kiểm Thử Xóa Giỏ Hàng Sau Checkout
- [ ] Sau khi đặt hàng thành công
- [ ] Session cart được xóa
- [ ] Quay lại homepage → giỏ hàng trống

**Kiểm tra:**
```php
Session()->get('cart') // NULL hoặc []
```

**Kết quả mong đợi:**
- Giỏ hàng được xóa

---

## ✅ **5. KIỂM THỬ ADMIN - QUẢN LÝ ĐƠN HÀNG**

### 5.1 Truy Cập Admin Panel
- [ ] Mở http://localhost:8090/admin
- [ ] Hiển thị form login
- [ ] Email: `admin@example.com` (hoặc từ DB)
- [ ] Password: `admin123` (hoặc từ DB)

**Kiểm tra credential từ DB:**
```sql
SELECT admin_email, admin_password FROM tbl_admin;
```

**Kết quả mong đợi:**
- Login thành công → chuyển sang dashboard

---

### 5.2 Kiểm Thử Dashboard - Hiển Thị Stats
- [ ] **Tổng đơn hàng** = COUNT(*) từ tbl_order
- [ ] **Đơn hàng mới** = COUNT(WHERE order_status = 1)
- [ ] **Đã hoàn thành** = COUNT(WHERE order_status = 2)
- [ ] **Đã hủy** = COUNT(WHERE order_status = 3)

**Kiểm tra DB:**
```sql
SELECT COUNT(*) FROM tbl_order;
SELECT COUNT(*) FROM tbl_order WHERE order_status = 1;
SELECT COUNT(*) FROM tbl_order WHERE order_status = 2;
SELECT COUNT(*) FROM tbl_order WHERE order_status = 3;
```

**Kết quả mong đợi:**
- Stats hiển thị đúng

---

### 5.3 Kiểm Thử Bảng Đơn Hàng
- [ ] Bảng hiển thị tất cả đơn hàng
- [ ] Cột: STT, Mã đơn, Ngày đặt, Trạng thái, Hành động
- [ ] Mã đơn được highlight/bold
- [ ] Ngày được format (dd/mm/yyyy HH:mm)

**Kết quả mong đợi:**
- Bảng hiển thị đúng format

---

### 5.4 Kiểm Thử Filter Theo Trạng Thái
- [ ] Dropdown "Trạng thái": Tất cả, Mới, Hoàn thành, Hủy
- [ ] Chọn "Mới" → hiển thị chỉ đơn order_status = 1
- [ ] Chọn "Hoàn thành" → hiển thị chỉ order_status = 2
- [ ] Chọn "Tất cả" → hiển thị tất cả

**Kết quả mong đợi:**
```
Filter hoạt động - chỉ hiển thị đơn hàng theo status
```

---

### 5.5 Kiểm Thử Search Theo Mã Đơn
- [ ] Nhập mã đơn vào ô search
- [ ] Click "Tìm kiếm"
- [ ] Bảng chỉ hiển thị đơn hàng khớp

**Ví dụ:**
```
Nhập: "abc12" → hiển thị order có order_code = "abc12"
Nhập: "xyz99" → không có kết quả
```

**Kết quả mong đợi:**
- Search hoạt động (LIKE query)

---

### 5.6 Kiểm Thử Reset Filter
- [ ] Sau khi filter/search
- [ ] Click nút "Reset"
- [ ] Trở lại hiển thị tất cả đơn hàng

**Kết quả mong đợi:**
- Filter được reset, hiển thị tất cả

---

### 5.7 Kiểm Thử Hiển Thị Badge Status
- [ ] **Mới** → badge xanh (badge-info)
- [ ] **Hoàn thành** → badge xanh nhạt (badge-success)
- [ ] **Hủy** → badge đỏ (badge-danger)

**Kết quả mong đợi:**
- Badge hiển thị đúng màu

---

### 5.8 Kiểm Thử Nút "Xem" (View Order)
- [ ] Click nút xem (👁️ icon)
- [ ] Chuyển sang trang xem chi tiết
- [ ] URL: /view-order/{order_code}

**Kết quả mong đợi:**
- Trang chi tiết đơn hàng load thành công

---

### 5.9 Kiểm Thử Xóa Đơn Hàng
- [ ] Click nút xóa (🗑️ icon)
- [ ] Confirm dialog: "Bạn chắc là muốn xóa?"
- [ ] Click "Xóa" → xóa khỏi DB
- [ ] Alert: "Xóa thành công"
- [ ] Bảng update - không còn đơn hàng

**Kiểm tra DB:**
```sql
SELECT * FROM tbl_order WHERE order_id = xxx;  -- Phải rỗng
```

**Kết quả mong đợi:**
- Đơn hàng được xóa từ DB

---

### 5.10 Kiểm Thử Empty State
- [ ] Xóa tất cả đơn hàng
- [ ] Trang đơn → hiển thị "Không có đơn hàng nào"

**Kết quả mong đợi:**
- Empty state message hiển thị

---

## ✅ **6. KIỂM THỬ VALIDATION & ERROR HANDLING**

### 6.1 Null Check - Admin Login
- [ ] Nếu admin không tồn tại trong DB
- [ ] Alert: "Mật khẩu hoặc tài khoản sai!"
- [ ] Redirect lại /admin

**Kết quả mong đợi:**
- Null check hoạt động

---

### 6.2 Validation - Checkout Order
- [ ] Bỏ trống form → lỗi "Field required"
- [ ] Invalid email → lỗi email
- [ ] Invalid phone → lỗi phone pattern
- [ ] Không chọn payment → lỗi "payment_method required"

**Kết quả mong đợi:**
```
return response()->json(['error' => 'message'], 422);
```

---

### 6.3 Exception Handling - Order History
- [ ] Database error → caught by try-catch
- [ ] Hiển thị empty cart (không crash)
- [ ] Log error vào storage/logs/laravel.log

**Kiểm tra:**
```
tail -f storage/logs/laravel.log
```

**Kết quả mong đợi:**
- Error được log, app không crash

---

## ✅ **7. KIỂM THỬ PERFORMANCE**

### 7.1 Tốc Độ Tải Trang
- [ ] Homepage: < 3 giây
- [ ] Chi tiết sản phẩm: < 3 giây
- [ ] Giỏ hàng: < 2 giây
- [ ] Checkout: < 2 giây
- [ ] Admin dashboard: < 3 giây

**Cách kiểm tra:** DevTools (F12) → Network tab

**Kết quả mong đợi:**
- Tất cả trang load nhanh

---

### 7.2 Kiểm Thử JavaScript Console
- [ ] Mở F12 → Console tab
- [ ] Không có red errors
- [ ] Không có warning quan trọng

**Kết quả mong đợi:**
- Console sạch sẽ

---

### 7.3 Kiểm Thử Responsive Design
- [ ] Mở DevTools (F12)
- [ ] Toggle device toolbar (Ctrl+Shift+M)
- [ ] Kiểm tra trên: iPhone SE, iPad, Desktop

**Các điểm kiểm tra:**
- [ ] Header responsive
- [ ] Carousel responsive
- [ ] Form fields responsive
- [ ] Table responsive (giỏ hàng, admin)

**Kết quả mong đợi:**
- Layout hiện thị đúng trên tất cả devices

---

## 📊 **BẢNG TÓM TẮT KỲ VỌNG**

| Chức Năng | Status | Lỗi? | Ghi Chú |
|-----------|--------|------|---------|
| Homepage hiển thị | ✅ | ❌ | |
| Chi tiết sản phẩm | ✅ | ❌ | |
| Giỏ hàng tính toán | ✅ | ❌ | |
| Checkout validation | ✅ | ❌ | |
| Tạo đơn hàng | ✅ | ❌ | |
| Admin filter | ✅ | ❌ | |
| Admin search | ✅ | ❌ | |
| Error handling | ✅ | ❌ | |
| Performance | ✅ | ❌ | |
| Responsive design | ✅ | ❌ | |

---

## 🎯 **HƯỚNG DẪN CHẠY TEST**

### Cách 1: Manual Testing (Đơn Giản)
1. Mở trình duyệt
2. Theo từng bước trong guide này
3. Ghi lại kết quả (✅ Pass / ❌ Fail)

### Cách 2: Chạy Unit Tests (Nâng Cao)
```bash
cd c:\xampp\WebClothing\WebClothing-1\CothingNew

# Chạy tất cả test
php artisan test

# Chạy riêng 1 file
php artisan test tests/Feature/HomePageTest.php

# Chạy với verbose output
php artisan test --verbose
```

---

## 📝 **TEMPLATE BÁO CÁO**

```
BÁNG CÁO KIỂM THỬ WEBCLOTHING
=====================================

Ngày: 06/12/2025
Phiên bản: v1.0.0
Tester: [Tên]

1. HOMEPAGE
   [ ] Load trang: ✅ Pass
   [ ] Hiển thị sản phẩm: ✅ Pass
   [ ] Meta tags: ✅ Pass
   [ ] Carousel: ✅ Pass
   Kết luận: ✅ PASS

2. CHI TIẾT SẢN PHẨM
   [ ] Tải trang: ✅ Pass
   [ ] Thông tin: ✅ Pass
   [ ] Chọn size: ✅ Pass
   [ ] Hover effects: ✅ Pass
   [ ] Thêm giỏ: ✅ Pass
   Kết luận: ✅ PASS

3. GIỎ HÀNG
   [...]
   Kết luận: ✅ PASS

4. CHECKOUT
   [...]
   Kết luận: ⚠️ FAIL - Lỗi validation email

5. ADMIN
   [...]
   Kết luận: ✅ PASS

TỔNG KẾT:
✅ 4/5 modules PASS
⚠️ 1/5 modules FAIL - Cần fix email validation

ISSUES CẦN FIX:
1. Email validation không hoạt động đúng
2. [Các issue khác...]
```

---

## 🚀 **LƯU Ý QUAN TRỌNG**

1. **Chạy test theo đúng thứ tự** (1 → 2 → 3 → 4 → 5)
2. **Ghi lại từng bước** có issue
3. **Kiểm tra database** nếu cần xác nhận dữ liệu
4. **Xóa dữ liệu test** sau khi hoàn thành
5. **Báo cáo chi tiết** tất cả findings

