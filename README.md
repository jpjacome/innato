
# Innato: Ecuadorian Community Tourism Platform

![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)
![Alpine.js](https://img.shields.io/badge/alpine.js-%2334D399.svg?style=for-the-badge&logo=alpine.js&logoColor=white)

## 🌎 About the Project

**Innato** is a modern web platform designed to empower small Ecuadorian communities to showcase their unique tourism experiences. Community leaders can create dedicated pages to present their local projects—such as fishing with a coastal village, cultural immersion, or nature tours—allowing travelers to discover, learn, and reserve authentic experiences directly.

---

## 🏞️ Key Features

- **Community Showcase:**
  - Each community can create a custom page with images, descriptions, and highlights.
  - Dynamic content management for local leaders.

- **Tourist Reservation System:**
  - Visitors can browse available experiences and reserve tours online.
  - Reservation management for both users and community leaders.


- **Admin Panel & CMS:**
  - Role-based access (Admin, Community Leader (Editor), Visitor).
  - Community Leaders (Editors) manage their own community pages and reservations.
  - Dynamic theming and dashboard customization.
  - User and role management.

- **Responsive Design:**
  - Mobile-first, accessible, and visually appealing for all users.

- **Security & Privacy:**
  - Secure authentication, CSRF protection, and role-based permissions.

---

## 🗂️ Project Structure

- `app/Models/` — Eloquent models for communities, reservations, users, and settings
- `app/Http/Controllers/` — Route controllers for public, admin, and reservation flows
- `resources/views/` — Blade templates for all UI (community pages, admin, reservations)
- `public/assets/` — Images, icons, and uploads
- `public/css/` — Custom CSS for theming and layout
- `routes/web.php` — Main web routes
- `database/migrations/` — Schema migrations
- `database/seeders/` — Demo and initial data

---

## � Getting Started

### Local Development

1. **Clone the repository:**
   ```bash
   git clone https://github.com/jpjacome/innato.git
   cd innato
   ```
2. **Install dependencies:**
   ```bash
   composer install
   ```
3. **Set up environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. **Configure your database in `.env`**
5. **Run migrations and seeders:**
   ```bash
   php artisan migrate --seed
   ```
6. **Start the development server:**
   ```bash
   php artisan serve
   ```

---

## 🧩 Technologies Used

- [Laravel](https://laravel.com) — PHP framework
- [Alpine.js](https://alpinejs.dev) — Lightweight JS for interactivity
- [MySQL](https://www.mysql.com) — Database (SQLite supported for local dev)
- Custom CSS — Modern, responsive design system

---

## 📖 Example Use Case

> **A local fishing community creates a page describing their unique fishing tour. Travelers can view details, see photos, and reserve a spot for an authentic experience, supporting local livelihoods.**

---

## 📝 License

This project is licensed under the MIT License.

---

## 🤝 Contributing

Contributions are welcome! Please open an issue or submit a pull request.

---

## 📫 Contact

Juan Pablo Jacome — [@jpjacome](https://github.com/jpjacome)

Website: [https://drpixel.it.nf/](https://drpixel.it.nf/)

Project Link: [https://github.com/jpjacome/innato](https://github.com/jpjacome/innato)
