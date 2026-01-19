# Nebatech Software Solutions Ltd

AI-powered, competency-based eLearning platform designed to empower students and professionals with hands-on IT skills for the future of work.

**Tagline:** Learn by Doing, Master by Practicing

## Features

- 🤖 AI-powered course generation and personalization
- 💻 Hands-on practical projects with automated feedback
- 📊 Competency-based learning and assessment
- 🎓 Verified certificates and digital portfolios
- 🔄 Adaptive learning paths
- 🌍 Scalable and multilingual support

## Tech Stack

### Backend
- PHP 8.2+
- MySQL 8.0+
- Redis (caching)
- Composer (dependency management)

### Frontend
- Tailwind CSS
- Alpine.js
- Vanilla JavaScript

### AI Services
- OpenAI API (GPT-4)
- Judge0 (code execution)

## Installation

### Prerequisites
- PHP 8.2 or higher
- MySQL 8.0 or higher
- Composer
- Node.js & npm
- XAMPP/WAMP/MAMP (for local development)

### Setup Instructions

1. **Clone the repository**
```bash
git clone <repository-url>
cd Nebatech-AI-Academy
```

2. **Install PHP dependencies**
```bash
composer install
```

3. **Install frontend dependencies**
```bash
npm install
```

4. **Set up environment variables**
```bash
copy .env.example .env
```
Edit `.env` file with your database credentials and API keys.

5. **Create database**
```sql
CREATE DATABASE nebatech_ai_academy CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

6. **Import database schema**
```bash
mysql -u root -p nebatech_ai_academy < database/schema.sql
```

7. **Build Tailwind CSS**
```bash
npm run build:css
```

For development with live reload:
```bash
npm run dev
```

8. **Configure Apache (XAMPP)**

Update your `httpd-vhosts.conf` or `.htaccess` to point to the `public` directory.

Example virtual host:
```apache
<VirtualHost *:80>
    DocumentRoot "c:/xampp/Nebatech-AI-Academy/public"
    ServerName nebatech.local
    <Directory "c:/xampp/Nebatech-AI-Academy/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Add to your hosts file:
```
127.0.0.1 nebatech.local
```

9. **Start the server**

Start Apache and MySQL from XAMPP control panel, then visit:
```
http://nebatech.local
```

or

```
http://localhost/Nebatech-AI-Academy/public
```

## Project Structure

```
Nebatech-AI-Academy/
├── config/              # Configuration files
│   ├── app.php
│   ├── database.php
│   └── ai.php
├── database/            # Database schemas and migrations
│   └── schema.sql
├── public/              # Public web root
│   ├── assets/
│   │   ├── css/
│   │   ├── js/
│   │   └── images/
│   ├── index.php        # Application entry point
│   └── .htaccess
├── routes/              # Route definitions
│   ├── web.php
│   └── api.php
├── src/                 # Application source code
│   ├── Controllers/     # Request handlers
│   ├── Models/          # Data models
│   ├── Services/        # Business logic (AI, Email, etc.)
│   ├── Repositories/    # Data access layer
│   ├── Middleware/      # Request middleware
│   ├── Views/           # HTML templates
│   └── Core/            # Core framework classes
├── storage/             # Application storage
│   ├── logs/
│   ├── cache/
│   └── uploads/
├── vendor/              # Composer dependencies
├── .env.example         # Environment template
├── composer.json
├── package.json
├── tailwind.config.js
└── README.md
```

## Development

### Running Tests
```bash
composer test
```

### Code Quality
```bash
# Check code style
composer cs-check

# Fix code style
composer cs-fix

# Static analysis
composer phpstan
```

### Watch Tailwind CSS
```bash
npm run dev
```

## API Documentation

API endpoints are available at `/api/*`. All API responses are in JSON format.

### Authentication
```
POST /api/auth/login
POST /api/auth/register
```

### Courses
```
GET    /api/courses
GET    /api/courses/{id}
POST   /api/courses
PUT    /api/courses/{id}
DELETE /api/courses/{id}
```

## Roadmap

See [Roadmap.md](Roadmap.md) for the complete AI integration plan and implementation phases.

See [TECH_STACK.md](TECH_STACK.md) for detailed technology recommendations.

## License

Proprietary - Nebatech

## Support

For support, email info@nebatech.com
