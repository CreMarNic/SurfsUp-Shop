# 🏄‍♂️ SurfsUp Shop - E-Commerce Platform

A modern, full-stack e-commerce solution built with **Sylius** (Symfony-based) featuring a Quiksilver-inspired design for surf gear and lifestyle products.

## 🌟 Features

- **Modern E-Commerce Platform**: Built on Sylius framework
- **Responsive Design**: Mobile-first approach with Bootstrap 5
- **Product Categories**: Surfboards, Clothing, Accessories
- **User Authentication**: Login/Register system
- **Shopping Cart**: Full cart functionality with localStorage
- **Brand Integration**: O'Neill, Quiksilver, Billabong, Rip Curl, Volcom, Oakley
- **Custom Templates**: Tailored homepage and product pages
- **Admin Panel**: Complete backend management

## 🛠️ Tech Stack

- **Backend**: PHP 8.2+, Symfony 6.x, Sylius
- **Frontend**: Twig, Bootstrap 5, JavaScript ES6+
- **Database**: MySQL/PostgreSQL
- **Server**: XAMPP/Apache
- **Version Control**: Git

## 🚀 Getting Started

### Prerequisites

- PHP 8.2 or higher
- Composer
- MySQL/PostgreSQL
- XAMPP (for local development)

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/cremarnic/surfsup-shop.git
   cd surfsup-shop
   ```

2. **Install dependencies**
   ```bash
   composer install
   yarn install
   ```

3. **Configure environment**
   ```bash
   cp .env .env.local
   # Edit .env.local with your database credentials
   ```

4. **Setup database**
   ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   php bin/console sylius:fixtures:load
   ```

5. **Build assets**
   ```bash
   yarn encore dev
   ```

6. **Start development server**
   ```bash
   php -S localhost:8000 -t public
   ```

## 📁 Project Structure

```
sylius/
├── config/                 # Configuration files
├── public/                 # Web root
├── src/                    # Application source code
├── templates/              # Twig templates
│   ├── bundles/           # Custom templates
│   └── shop/              # Shop templates
├── var/                   # Cache and logs
└── vendor/               # Composer dependencies
```

## 🎨 Custom Features

### Homepage Design
- **Hero Section**: Dynamic background with surf imagery
- **Product Navigation**: Dropdown menus for categories
- **Brand Showcase**: Partner brand integration
- **Responsive Layout**: Mobile-optimized design

### Product Pages
- **Category Pages**: Longboards, Shortboards, Windboards
- **Clothing**: Men's/Women's apparel
- **Accessories**: Caps, Wetsuits, Gear

### User Experience
- **Smooth Animations**: CSS transitions and hover effects
- **Interactive Elements**: Dynamic cart updates
- **Form Validation**: Client and server-side validation

## 🔧 Development

### Code Standards
- **PHP**: PSR-12 coding standards
- **Twig**: Modern template syntax
- **JavaScript**: ES6+ features
- **CSS**: SCSS with Bootstrap utilities

### Testing
```bash
# Run PHPUnit tests
vendor/bin/phpunit

# Run Behat scenarios
vendor/bin/behat

# Code style checks
vendor/bin/ecs check
```

## 📱 Responsive Design

The shop is fully responsive and optimized for:
- **Desktop**: Full feature experience
- **Tablet**: Touch-friendly navigation
- **Mobile**: Streamlined mobile experience

## 🌐 Browser Support

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

## 📄 License

This project is open source and available under the [MIT License](LICENSE).

## 👨‍💻 Author

**Marius Cretu** - Software & Web Developer
- Portfolio: [cremarnic.github.io/Portfolio](https://cremarnic.github.io/Portfolio/)
- Email: marius14cretu@gmail.com
- Location: Konstanz, Germany

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📞 Support

If you have any questions or need help, feel free to reach out:
- Email: marius14cretu@gmail.com
- Phone: +49 157 54497440

---

**Built with ❤️ by [Marius Cretu](https://cremarnic.github.io/Portfolio/)**