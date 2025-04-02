# DR Pixel CMS - Modern Laravel Admin Panel

![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)

A sleek and powerful Content Management System built with Laravel, featuring a modern admin panel with dynamic theming and user management capabilities.

## ✨ Features

### 🎨 Dynamic Theming System
- Customizable color schemes for the admin panel
- Real-time theme updates without page refresh
- Persistent theme settings across sessions
- Custom CSS-based styling system

### 👥 Advanced User Management
- Multi-role system (Admin, Editor, Regular)
- User creation and management interface
- Role-based access control
- Secure user authentication

### 🎯 Dashboard Customization
- Customizable dashboard title
- Hero section settings for the welcome page
- Dynamic content management
- Responsive design for all devices

### 🔒 Security Features
- Role-based authentication
- CSRF protection
- Secure password handling
- Admin-only access to sensitive areas

## 🚀 Getting Started

### Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js and NPM
- MySQL or PostgreSQL

### Installation

1. Clone the repository:
```bash
git clone https://github.com/jpjacome/drpixelcms.git
cd drpixelcms
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install NPM dependencies:
```bash
npm install
```

4. Create environment file:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Configure your database in `.env` file

7. Run migrations and seeders:
```bash
php artisan migrate --seed
```

8. Compile assets:
```bash
npm run build
```

9. Start the development server:
```bash
php artisan serve
```

## 🛠️ Built With

- [Laravel](https://laravel.com) - The PHP framework
- [Alpine.js](https://alpinejs.dev) - Minimal JavaScript framework
- [MySQL](https://www.mysql.com) - Database management system
- Custom CSS - Modern and responsive styling system

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👏 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📫 Contact

Juan Pablo Jacome - [@jpjacome](https://github.com/jpjacome)

Project Link: [https://github.com/jpjacome/drpixelcms](https://github.com/jpjacome/drpixelcms)
