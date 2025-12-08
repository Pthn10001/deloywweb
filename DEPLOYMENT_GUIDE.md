# WebClothing - Hướng Dẫn Triển Khai và Sử Dụng

## 🎯 Tổng Quan

WebClothing là một nền tảng bán quần áo thời trang trực tuyến được xây dựng bằng **Laravel 8** với giao diện người dùng được thiết kế chuyên nghiệp sử dụng **Bootstrap** và **jQuery**.

### Công Nghệ Sử Dụng
- **Framework**: Laravel 8.54
- **PHP**: 8.0
- **Database**: MySQL 5.7
- **Frontend**: Bootstrap 4, jQuery, Blade Templates
- **Containerization**: Docker & Docker Compose
- **Web Server**: Nginx (Alpine)

---

## 🚀 Bắt Đầu Nhanh

### 1. Yêu Cầu Tiên Quyết
- Docker Desktop (đã cài đặt)
- Git (tuỳ chọn)

### 2. Khởi Động Hệ Thống

```bash
# Chuyển đến thư mục dự án
cd c:\xampp\WebClothing\WebClothing-1

# Khởi động toàn bộ các container
docker-compose up -d

# Hoặc nếu cần rebuild
docker-compose up -d --build
```

### 3. Truy Cập Ứng Dụng

| Dịch Vụ | URL | Thông Tin |
|---------|-----|----------|
| **Website Chính** | http://localhost:8090 | Cửa hàng trực tuyến |
| **Admin Panel** | http://localhost:8090/admin | Quản lý đơn hàng |
| **PhpMyAdmin** | http://localhost:8081 | Quản lý CSDL |

---

## 📋 Tính Năng Chính

### Dành Cho Khách Hàng
✅ **Homepage**: Hiển thị banner, danh mục sản phẩm, sản phẩm nổi bật  
✅ **Chi Tiết Sản Phẩm**: Xem chi tiết, hình ảnh, giá, review sao  
✅ **Giỏ Hàng**: Thêm, xóa, cập nhật số lượng sản phẩm  
✅ **Checkout**: Thanh toán COD hoặc Chuyển khoản  
✅ **Lịch Sử Đơn Hàng**: Xem các đơn hàng đã mua  
✅ **Đăng Nhập/Đăng Ký**: Hệ thống xác thực khách hàng  

### Dành Cho Admin
✅ **Dashboard**: Xem thống kê đơn hàng (Tổng, Mới, Hoàn thành, Hủy)  
✅ **Quản Lý Đơn Hàng**: Tìm kiếm, lọc theo trạng thái, xem chi tiết  
✅ **Xem Chi Tiết Đơn**: Thông tin khách, sản phẩm, địa chỉ giao  

---

## 🎨 Cải Tiến Giao Diện (Mới)

### Homepage
- 🎨 **Banner Hero**: Gradient màu tím đẹp mắt
- 📂 **Danh Mục**: 4 danh mục sản phẩm với gradients độc đáo
- ⭐ **Sản Phẩm Nổi Bật**: Grid hiển thị sản phẩm với hover effects
- 🎁 **Features**: 4 lợi ích chính (Giao hàng nhanh, An toàn, Hoàn tiền, Hỗ trợ 24/7)

### Trang Chi Tiết Sản Phẩm
- 🖼️ **Hình Ảnh**: Zoom khi hover, hiển thị full size
- 💰 **Thông Tin Giá**: Hiệu ứng gradient, trạng thái tồn kho
- 📏 **Chọn Size**: Radio buttons với S, M, L, XL
- 🛒 **Nút Thêm Giỏ**: Gradient button với hover effects
- 📱 **Chia Sẻ**: Facebook, Twitter, Instagram links
- 🔗 **Sản Phẩm Liên Quan**: Hiển thị grid tương tự

### Giỏ Hàng
- 📊 **Bảng Giỏ Hàng**: Hiệu ứng hover trên hàng
- 💵 **Tóm Tắt Đơn Hàng**: Sticky sidebar với tổng tiền
- 🎯 **Gợi Ý Sản Phẩm**: Section cho sản phẩm liên quan
- 📦 **Trạng Thái Rỗng**: Hình ảnh đẹp khi giỏ trống

### Thanh Toán
- 📋 **Form Rõ Ràng**: 4 section (Khách hàng, Địa chỉ, Ghi chú, Thanh toán)
- 💳 **Phương Thức Thanh Toán**: 3 lựa chọn (COD, Chuyển khoản, Thẻ)
- 📱 **Sidebar Tóm Tắt**: Sticky sidebar với danh sách sản phẩm
- ✔️ **Validation**: Client-side & server-side validation

### Header
- 🎨 **Gradient Header**: Màu tím gradient chuyên nghiệp
- 📞 **Thông Tin Liên Hệ**: Phone & Email hiển thị trên top
- 👤 **User Menu**: Đăng nhập, giỏ hàng, đơn hàng, đăng xuất
- 📱 **Responsive**: Tự động điều chỉnh trên mobile

### Footer
- 📝 **Về Cửa Hàng**: Mô tả và social links
- 🛍️ **Menu Cửa Hàng**: Liên kết đến các trang chính
- 💬 **Hỗ Trợ**: FAQ, Chính sách, Điều khoản
- 📱 **Thông Tin Liên Hệ**: Phone, Email, Địa chỉ
- 💳 **Payment Methods**: Hiển thị các phương thức thanh toán

---

## 🔧 Cấu Hình

### Database
```
Host: db (trong Docker) hoặc 127.0.0.1:3307 (từ host)
Username: root
Password: root
Database: clothing
Port: 3307
```

### Biến Môi Trường (.env)
```
APP_NAME=WebClothing
APP_URL=http://localhost:8090
DB_HOST=db
DB_PORT=3307
DB_DATABASE=clothing
DB_USERNAME=root
DB_PASSWORD=root
```

### Ports
- **8090**: Nginx (Web Server)
- **3307**: MySQL Database
- **8081**: PhpMyAdmin
- **3000**: Node.js

---

## 🐛 Các Lỗi Đã Fix

| Lỗi | Nguyên Nhân | Giải Pháp |
|-----|-----------|---------|
| Null Customer | Không kiểm tra khách hàng | Thêm null check & validation |
| Double Submit | Không disable button | Thêm flag `isSubmitting` |
| Lỗi Đầu Vào | Không validate form | Thêm validation client & server |
| Database Error | Host 127.0.0.1 không hoạt động | Đổi sang 'db' trong Docker |
| Order History Error | Không catch exception | Thêm try-catch exception handling |

---

## 📊 Database Schema

### Bảng Chính
```
- tbl_customer: Thông tin khách hàng
- tbl_product: Danh sách sản phẩm
- tbl_order: Đơn hàng
- tbl_order_details: Chi tiết đơn hàng
- tbl_shipping: Thông tin giao hàng
- tbl_brand: Thương hiệu sản phẩm
- tbl_category: Danh mục sản phẩm
```

---

## 🔐 Bảo Mật

✅ CSRF Protection - Tất cả form có CSRF token  
✅ SQL Injection Prevention - Sử dụng Eloquent ORM  
✅ XSS Prevention - Blade template escaping  
✅ Validation - Server-side validation trên tất cả endpoints  
✅ Session Management - Secure session handling  

---

## 📱 Responsive Design

- 📱 **Mobile**: Tối ưu cho màn hình < 768px
- 📱 **Tablet**: Tối ưu cho 768px - 1024px
- 🖥️ **Desktop**: Tối ưu cho > 1024px
- ⚡ **Performance**: Images optimized, CSS minified

---

## 🚨 Troubleshooting

### Problem: Docker containers không chạy
```bash
# Kiểm tra status
docker-compose ps

# View logs
docker-compose logs laravel_app

# Restart
docker-compose restart
```

### Problem: Không kết nối được database
```bash
# Kiểm tra connection
docker-compose exec laravel_app php artisan tinker
# Trong tinker shell: DB::connection()->getPdo()
```

### Problem: Assets/CSS không tải
```bash
# Rebuild assets
docker-compose exec laravel_app npm run dev
```

---

## 📚 API Routes

### Checkout Routes
- `POST /order` - Tạo đơn hàng mới
- `POST /add-cart-ajax` - Thêm sản phẩm vào giỏ
- `POST /update-cart` - Cập nhật giỏ hàng
- `GET /delete-cart/{id}` - Xóa sản phẩm khỏi giỏ

### Customer Routes
- `GET /login-checkout` - Trang đăng nhập
- `POST /login_customer` - Xác thực khách hàng
- `GET /orders` - Lịch sử đơn hàng
- `GET /order/{id}` - Chi tiết đơn hàng

### Admin Routes
- `GET /admin` - Dashboard
- `GET /admin/order/manager` - Quản lý đơn hàng

---

## 🎯 Next Steps

1. **Payment Gateway**: Tích hợp Stripe/Paypal
2. **Product Search**: Thêm full-text search
3. **Reviews/Ratings**: Hệ thống đánh giá sản phẩm
4. **Notifications**: Email notifications cho đơn hàng
5. **Analytics**: Dashboard analytics cho admin
6. **Wishlist**: Danh sách yêu thích cho khách hàng

---

## 📞 Support

- **Email**: NgoMtien@gmail.com
- **Phone**: +0993282493
- **Available**: 24/7

---

## 📄 License

WebClothing © 2024. All rights reserved.

---

**Last Updated**: December 2024  
**Version**: 1.0.0
