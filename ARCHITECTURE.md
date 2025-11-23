# Nebatech AI Academy - Architecture Documentation

## System Architecture Overview

### Technology Stack
- **Backend:** PHP 8.2+ (Custom MVC Framework)
- **Frontend:** Tailwind CSS + Alpine.js
- **Database:** MySQL 8.0+
- **Caching:** Redis (planned)
- **AI Services:** OpenAI GPT-4
- **Code Execution:** Judge0 API
- **Package Management:** Composer (PHP), npm (Frontend)

---

## Directory Structure

```
Nebatech-AI-Academy/
├── config/                    # Configuration files
│   ├── app.php               # Application settings
│   ├── database.php          # Database configuration
│   ├── ai.php                # OpenAI settings
│   ├── judge0.php            # Code execution settings
│   └── programs.php          # Available programs
│
├── database/                  # Database files
│   ├── schema.sql            # Main database schema
│   ├── migrations/           # Database migrations
│   │   └── 001_add_application_tables.sql
│   └── seeders/              # Sample data
│
├── public/                    # Web root (public access)
│   ├── index.php             # Application entry point
│   ├── .htaccess             # Apache rewrite rules
│   └── assets/               # Static assets
│       ├── css/              # Compiled CSS
│       ├── js/               # JavaScript files
│       └── images/           # Image files
│
├── routes/                    # Route definitions
│   ├── web.php               # Web routes
│   └── api.php               # API routes
│
├── src/                       # Application source code
│   ├── Controllers/          # Request handlers
│   │   ├── HomeController.php
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── FacilitatorController.php
│   │   ├── AdminController.php
│   │   ├── ApplicationController.php
│   │   ├── CourseController.php
│   │   ├── AIController.php
│   │   ├── PortfolioController.php
│   │   ├── CertificateController.php
│   │   └── CodeExecutionController.php
│   │
│   ├── Models/               # Data models
│   │   ├── User.php
│   │   ├── Course.php
│   │   ├── Module.php
│   │   ├── Lesson.php
│   │   ├── Enrollment.php
│   │   ├── Assignment.php
│   │   ├── Submission.php
│   │   ├── Application.php
│   │   ├── Cohort.php
│   │   ├── Portfolio.php
│   │   └── Certificate.php
│   │
│   ├── Services/             # Business logic
│   │   ├── AIService.php
│   │   ├── CodeExecutionService.php
│   │   ├── PortfolioService.php
│   │   └── CertificateService.php
│   │
│   ├── Repositories/         # Data access layer
│   │   ├── UserRepository.php
│   │   ├── CourseRepository.php
│   │   └── ApplicationRepository.php
│   │
│   ├── Middleware/           # Request middleware
│   │   ├── AuthMiddleware.php
│   │   └── RoleMiddleware.php
│   │
│   ├── Views/                # HTML templates
│   │   ├── layouts/          # Layout templates
│   │   ├── partials/         # Reusable components
│   │   ├── auth/             # Authentication views
│   │   ├── dashboard/        # Student dashboard
│   │   ├── facilitator/      # Facilitator views
│   │   ├── admin/            # Admin views
│   │   ├── courses/          # Course views
│   │   ├── applications/     # Application views
│   │   ├── portfolio/        # Portfolio views
│   │   ├── certificates/     # Certificate views
│   │   └── code/             # Code playground
│   │
│   ├── Core/                 # Core framework classes
│   │   ├── Router.php        # URL routing
│   │   ├── Controller.php    # Base controller
│   │   ├── Model.php         # Base model
│   │   ├── Database.php      # Database connection
│   │   └── Middleware.php    # Base middleware
│   │
│   ├── assets/               # Source assets
│   │   └── input.css         # Tailwind CSS input
│   │
│   └── helpers.php           # Helper functions
│
├── storage/                   # Application storage
│   ├── logs/                 # Log files
│   ├── cache/                # Cache files
│   └── uploads/              # User uploads
│       ├── assignments/      # Assignment submissions
│       ├── applications/     # Application documents
│       └── portfolios/       # Portfolio images
│
├── vendor/                    # Composer dependencies
│
├── .env.example              # Environment template
├── .gitignore                # Git ignore rules
├── composer.json             # PHP dependencies
├── package.json              # Node dependencies
├── tailwind.config.js        # Tailwind configuration
├── postcss.config.js         # PostCSS configuration
├── README.md                 # Project documentation
├── TECH_STACK.md            # Technology stack details
├── Roadmap.md               # Implementation roadmap
├── AI_SERVICE_README.md     # AI service guide
├── IMPLEMENTATION_STATUS.md # Current status
└── ARCHITECTURE.md          # This file
```

---

## Architectural Patterns

### 1. **MVC (Model-View-Controller)**
- **Models:** Data representation and business logic
- **Views:** HTML templates with minimal logic
- **Controllers:** Handle HTTP requests and responses

### 2. **Repository Pattern**
- Abstracts data access logic
- Provides clean interface for data operations
- Makes testing easier

### 3. **Service Layer**
- Contains complex business logic
- Orchestrates multiple models/repositories
- Handles external API integrations

### 4. **Middleware Pattern**
- Request filtering and validation
- Authentication and authorization
- Cross-cutting concerns

---

## Data Flow

### Request Lifecycle

```
1. HTTP Request
   ↓
2. public/index.php (Entry Point)
   ↓
3. Router (routes/web.php or routes/api.php)
   ↓
4. Middleware (Auth, Role checks)
   ↓
5. Controller (Process request)
   ↓
6. Service/Repository (Business logic, Data access)
   ↓
7. Model (Database operations)
   ↓
8. View (Render HTML) or JSON Response
   ↓
9. HTTP Response
```

### Example: Student Application Flow

```
1. Student fills application form
   ↓
2. POST /apply → ApplicationController::submitApplication()
   ↓
3. AuthMiddleware checks authentication
   ↓
4. ApplicationRepository::create() saves to database
   ↓
5. Email notification sent (planned)
   ↓
6. Redirect to /my-applications
```

---

## Database Schema

### Core Tables

#### Users
- Stores user accounts (students, facilitators, admins)
- Fields: id, uuid, email, password, role, status

#### Courses
- Course information and metadata
- Fields: id, uuid, title, slug, description, facilitator_id

#### Modules
- Course modules/sections
- Fields: id, uuid, course_id, title, order_index

#### Lessons
- Individual lessons within modules
- Fields: id, uuid, module_id, title, content, type

#### Enrollments
- Student course enrollments
- Fields: id, user_id, course_id, progress, status

#### Assignments
- Project assignments for lessons
- Fields: id, uuid, lesson_id, title, rubric

#### Submissions
- Student assignment submissions
- Fields: id, uuid, assignment_id, user_id, content, ai_score

#### Applications
- Student program applications
- Fields: id, uuid, user_id, program, status, reviewed_by

#### Cohorts
- Student cohorts/groups
- Fields: id, name, program, facilitator_id, start_date

#### Portfolios
- Student portfolio entries
- Fields: id, user_id, submission_id, title, is_public

#### Certificates
- Course completion certificates
- Fields: id, uuid, user_id, course_id, certificate_number

---

## API Integration

### OpenAI Integration
- **Purpose:** AI-powered course generation
- **Endpoints Used:** Chat Completions API
- **Models:** GPT-4 Turbo
- **Features:**
  - Course outline generation
  - Lesson content creation
  - Project brief generation
  - Quiz generation

### Judge0 Integration
- **Purpose:** Code execution sandbox
- **API:** Judge0 CE (RapidAPI)
- **Features:**
  - Execute code in 40+ languages
  - Run test cases
  - Capture output and errors
  - Time and memory limits

---

## Security Measures

### Authentication
- Password hashing with Argon2ID
- Session-based authentication
- JWT tokens (planned for API)

### Authorization
- Role-based access control (RBAC)
- Middleware protection for routes
- User permission checks

### Data Protection
- Environment variables for secrets
- SQL injection prevention (prepared statements)
- XSS protection (output escaping)
- CSRF protection (planned)

### API Security
- Rate limiting (planned)
- API key validation
- Input sanitization
- Error message sanitization

---

## Scalability Considerations

### Current Architecture
- Monolithic PHP application
- Single MySQL database
- Session-based state

### Future Enhancements (Phase B+)
- Redis caching layer
- Queue system for background jobs
- CDN for static assets
- Database read replicas
- Microservices for AI operations
- Horizontal scaling with load balancer

---

## Development Workflow

### Local Development
1. Clone repository
2. Run `composer install`
3. Run `npm install`
4. Copy `.env.example` to `.env`
5. Configure database
6. Import `database/schema.sql`
7. Run `npm run dev` (Tailwind watch)
8. Start Apache/Nginx

### Code Standards
- PSR-12 coding standard
- PHPStan level 5 static analysis
- PHPUnit for testing
- Git flow branching strategy

---

## Deployment Architecture

### Production Environment
```
Internet
   ↓
Cloudflare CDN (SSL, DDoS protection)
   ↓
Load Balancer (planned)
   ↓
Web Servers (Nginx + PHP-FPM)
   ↓
MySQL Database (Primary + Replica)
   ↓
Redis Cache (planned)
   ↓
S3 Storage (file uploads)
```

---

## Monitoring & Logging

### Logging
- Monolog PSR-3 logger
- File-based logging
- Error tracking with Sentry (planned)

### Monitoring
- Application performance monitoring (planned)
- Database query monitoring (planned)
- API usage tracking (planned)

---

## Testing Strategy

### Unit Tests
- Model methods
- Service logic
- Helper functions

### Integration Tests
- Controller actions
- API endpoints
- Database operations

### End-to-End Tests
- User workflows
- Critical paths
- Payment flows

---

**Last Updated:** 2025-01-08
**Version:** 1.0.0
