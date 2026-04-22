# ⚡ Bash Today — Fullstack Blog

![Nuxt 4](https://img.shields.io/badge/Nuxt_4-00DC82?style=for-the-badge&logo=nuxt.js&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel_13-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)

## ✨ Ключевые возможности

### 🔐 Авторизация и безопасность
* **SPA Authentication:** Безопасная авторизация через Laravel Sanctum (HttpOnly Cookies, CSRF защита) без использования уязвимых JWT-токенов в LocalStorage.
* **Route Middleware:** Глобальные проверки прав доступа во Vue (`auth`, `guest` middleware), защищающие приватные страницы от неавторизованных пользователей.

### 📝 Управление контентом (CRUD)
* **Создание и чтение:** Публикация постов с обложками, заголовками, превью и основным текстом.
* **In-place редактирование:** Плавное редактирование постов прямо на странице просмотра без перезагрузок и лишних переходов благодаря оптимистичному обновлению UI.
* **Удаление с подтверждением:** Защищенное удаление записей через модальные окна.
* **Авторизация действий:** Пользователи могут редактировать и удалять **только свои** публикации.

### 🎨 UI / UX
* **Адаптивный дизайн:** Mobile-first подход. Полноценное мобильное меню (Гамбургер), которое скрывается на десктопных разрешениях.
* **Темная/Светлая тема:** Поддержка тем.
* **Nuxt UI:** Использование готовых, доступных (a11y) компонентов (модалки, скелетоны при загрузке, формы, алерты).
* **Floating Labels:** Современный дизайн инпутов на страницах входа и регистрации.

## 🛠 Стек технологий

**Frontend:**
* [Nuxt 4](https://nuxt.com/) (SSR / SPA)
* [Nuxt UI](https://ui.nuxt.com/) & [Tailwind CSS](https://tailwindcss.com/)
* `useFetch` для взаимодействия с API

**Backend:**
* [Laravel 13](https://laravel.com/) (API)
* [Laravel Sanctum](https://laravel.com/docs/sanctum)
* PostgreSQL (База данных)

## 📸 Галерея (Скриншоты)

> **Заметка:** *Здесь представлены скриншоты интерфейса приложения на разных устройствах.*

<details>
<summary><b>Показать скриншоты проекта</b></summary>
<br>

| Главная страница (Светлая тема) | Главная страница (Темная тема) |
| :---: | :---: |
| <img width="2650" height="1662" src="https://github.com/user-attachments/assets/b20ee5b7-575b-43f2-865a-00a3e90bdf92" alt="Home Light" /> | <img width="2650" height="1662" src="https://github.com/user-attachments/assets/0e792251-374e-4164-be44-ab5afce4563f" alt="Home Dark"/> |

| Просмотр поста | In-place редактирование |
| :---: | :---: |
| <img width="2650" height="1662" alt="Post View" src="https://github.com/user-attachments/assets/9703df37-e0e3-4627-a899-5a9a4c24086e" /> | <img width="2650" height="1662" alt="Post Edit" src="https://github.com/user-attachments/assets/4c15326d-6679-43d9-ae04-05ee3a6b587f" /> |

| Мобильное меню | Форма авторизации |
| :---: | :---: |
| <img width="738" height="840" alt="Mobile Menu" src="https://github.com/user-attachments/assets/c5cf5cf5-c59c-42ef-bb44-feac34826e17" /> | <img width="738" height="840" alt="Auth Form" src="https://github.com/user-attachments/assets/08f65e06-920b-46dd-8a26-135161d37cf3" /> |

</details>

