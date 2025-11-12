# Nebatech Website + LMS Integration Plan

## Executive Summary

This document outlines the comprehensive plan to integrate the existing Nebatech corporate website (https://nebatech.com) with the current Nebatech AI Academy LMS platform. The goal is to create a unified platform that serves both as a corporate website showcasing IT services AND as an educational platform offering courses.

**Project Name Change:** Nebatech AI Academy → **Nebatech Platform** (or keep as Nebatech)

---

## 1. Analysis & Discovery

### 1.1 Current State Assessment

#### Existing Website (nebatech.com)
**Pages Identified:**
- Home (index.php)
- Programmes (programmes.php)
- Services (services.php)
- Projects (projects.php)
- Events/Blog (blog.php)
- About Us (about_us.php)
- Contact (contact.php)
- FAQs (faq.php)
- Admission Portal (admission_portal.php)

**Key Content:**
- **10 Training Programmes** (Introduction to AI, Basic AI in ML, Front-End Dev, Back-End Dev, Database Management, MS Office, Video Editing, Graphic Design, Digital Literacy, Hardware Technician)
- **7 IT Services** (Mobile/Web App Dev, Website Design, POS Systems, Inventory Management, Network Installation, CCTV Installation, iPhone/Laptop Repairs)
- **Company Information** (Mission, Vision, Values, Team Members)
- **Testimonials** (13+ client testimonials)
- **Project Portfolio**
- **Contact Information** (Phone, Email, Location in Tamale, Ghana)

#### Current LMS Platform
**Features:**
- AI-powered course generation
- Student dashboard with progress tracking
- Facilitator/Admin dashboards
- Course enrollment system
- Assignment submission & grading
- Certificate generation
- Portfolio showcase
- Code playground
- Application system for programs
- Cohort management

**Design Style:**
- Modern, clean UI with Tailwind CSS
- Primary color: Blue (#1e40af)
- Secondary color: Orange (#f97316)
- Responsive design
- Alpine.js for interactivity

---

## 2. Integration Strategy

### 2.1 Architectural Approach

**Unified Platform Structure:**
```
Nebatech Platform
├── Public Website (Marketing & Services)
│   ├── Home
│   ├── About Us
│   ├── IT Services
│   ├── Training Programmes (links to LMS courses)
│   ├── Projects/Portfolio
│   ├── Blog/Events
│   ├── Contact
│   └── FAQs
│
└── Learning Management System (Authenticated)
    ├── Student Dashboard
    ├── Facilitator Dashboard
    ├── Admin Dashboard
    ├── Courses
    ├── Assignments
    ├── Certificates
    └── Code Playground
```

### 2.2 Navigation Strategy

**Primary Navigation (Public):**
- Home
- About
- Services (IT Solutions)
- Programmes (Training Courses)
- Projects
- Blog
- Contact

**Secondary Navigation (Authenticated):**
- Dashboard (role-based redirect)
- My Courses
- My Progress
- Certificates
- Profile

### 2.3 Design Consistency

**Maintain Current LMS Design:**
- Keep the modern Tailwind CSS design
- Use existing color scheme (Blue & Orange)
- Apply same design patterns to new public pages
- Ensure responsive design across all pages

---

## 3. Implementation Plan

### Phase 1: Foundation & Structure (Days 1-2)

#### 1.1 Project Restructuring
- [x] Create INTEGRATION_PLAN.md
- [ ] Update README.md with new project scope
- [ ] Rename project references from "AI Academy" to "Nebatech Platform"
- [ ] Update database schema if needed
- [ ] Create new directory structure for public pages

#### 1.2 Controller Creation
- [ ] Create `PublicController.php` for public pages
- [ ] Create `ProgrammeController.php` for training programmes
- [ ] Create `ServiceController.php` for IT services
- [ ] Update `HomeController.php` for new homepage
- [ ] Update `BlogController.php` for events/blog

#### 1.3 Route Setup
- [ ] Add routes for all public pages
- [ ] Add routes for services pages
- [ ] Add routes for programme detail pages
- [ ] Ensure proper route ordering (public before authenticated)

---

### Phase 2: Public Pages Development (Days 3-5)

#### 2.1 Homepage Redesign
**Content to Include:**
- Hero section with company tagline
- Services overview (4-6 key services)
- Training programmes overview
- Testimonials carousel
- Stats section (projects completed, students trained, etc.)
- Call-to-action sections
- Why Choose Nebatech section

**Files to Create:**
- `src/Views/public/home.php`

#### 2.2 About Us Page
**Content to Include:**
- Company story
- Mission & Vision
- Core values (Integrity, Innovation, Excellence, Teamwork)
- CEO message (Abdul-Hafiz Yussif)
- Team members (6 team members with photos/avatars)

**Files to Create:**
- `src/Views/public/about.php`

#### 2.3 IT Services Pages
**Main Services Page:**
- Overview of all 7 services
- Service cards with icons
- Call-to-action buttons

**Individual Service Detail Pages:**
1. Mobile & Web Application Development
2. Website Design & Development
3. POS System Development
4. Inventory Management System
5. Network Installation & Troubleshooting
6. CCTV Camera Installation
7. iPhone & Laptop Repairs

**Files to Create:**
- `src/Views/public/services/index.php`
- `src/Views/public/services/mobile-web-development.php`
- `src/Views/public/services/website-design.php`
- `src/Views/public/services/pos-system.php`
- `src/Views/public/services/inventory-management.php`
- `src/Views/public/services/network-services.php`
- `src/Views/public/services/cctv-installation.php`
- `src/Views/public/services/device-repairs.php`

#### 2.4 Training Programmes Pages
**Main Programmes Page:**
- List all 10 training programmes
- Programme cards with pricing and duration
- Filter by category
- Link to course enrollment (LMS)

**Individual Programme Detail Pages:**
1. Introduction to AI (GHS 400, 3 weeks)
2. Basic AI in Machine Learning (GHS 1200, 5 weeks)
3. Front-End Development (GHS 3500, 16 weeks)
4. Back-End Development (GHS 4500, 20 weeks)
5. Database Management & Administration (GHS 4000, 16 weeks)
6. Microsoft Office Suite Mastery (GHS 1800, 8 weeks)
7. Video Editing & Production (GHS 3600, 12 weeks)
8. Graphic Design & Digital Arts (GHS 3200, 12 weeks)
9. Digital Literacy (GHS 1500, 4 weeks)
10. iPhone & Computer Hardware Technician (GHS 3000, 12 weeks)

**Files to Create:**
- `src/Views/public/programmes/index.php`
- `src/Views/public/programmes/[programme-slug].php` (template for all)

#### 2.5 Projects/Portfolio Page
**Content to Include:**
- Showcase of completed projects
- Project categories (Web Dev, Mobile Apps, POS Systems, etc.)
- Project cards with descriptions
- Case studies (optional)

**Files to Create:**
- `src/Views/public/projects.php`

#### 2.6 Blog/Events Page
**Content to Include:**
- List of blog posts/events
- Featured posts
- Categories/tags
- Search functionality

**Files to Create:**
- `src/Views/public/blog/index.php`
- `src/Views/public/blog/post.php`

#### 2.7 Contact Page
**Content to Include:**
- Contact form
- Contact information (Phone: 024 763 6080 / 020 678 9600)
- Email: info@nebatech.com
- Location: Choggu Yapalsi, Tamale, Northern Ghana
- Google Maps integration
- Office hours

**Files to Create:**
- `src/Views/public/contact.php`

#### 2.8 FAQ Page
**Content to Include:**
- Frequently asked questions
- Accordion/collapsible sections
- Categories (Services, Programmes, General)
- Search functionality

**Files to Create:**
- `src/Views/public/faq.php`

---

### Phase 3: Integration & Data Management (Days 6-7)

#### 3.1 Database Updates
- [ ] Create `services` table for IT services
- [ ] Create `projects` table for portfolio
- [ ] Create `blog_posts` table for blog/events
- [ ] Create `testimonials` table
- [ ] Update `courses` table to link with programmes
- [ ] Create migration files

#### 3.2 Models Creation
- [ ] Create `Service.php` model
- [ ] Create `Project.php` model
- [ ] Create `BlogPost.php` model
- [ ] Create `Testimonial.php` model
- [ ] Update `Course.php` model

#### 3.3 Data Seeding
- [ ] Seed services data (7 services)
- [ ] Seed programmes data (10 programmes)
- [ ] Seed testimonials (13 testimonials)
- [ ] Seed team members
- [ ] Seed sample projects

---

### Phase 4: Navigation & Layout Updates (Day 8)

#### 4.1 Header/Navigation Update
- [ ] Update `src/Views/partials/header.php`
- [ ] Add public navigation menu
- [ ] Add authenticated navigation menu
- [ ] Implement dropdown menus for Services & Programmes
- [ ] Add mobile responsive menu

#### 4.2 Footer Update
- [ ] Update `src/Views/partials/footer.php`
- [ ] Add company information
- [ ] Add quick links (Services, Programmes, About, Contact)
- [ ] Add social media links
- [ ] Add copyright notice
- [ ] Add privacy policy & terms links

#### 4.3 Layout Templates
- [ ] Create `src/Views/layouts/public.php` for public pages
- [ ] Keep `src/Views/layouts/main.php` for authenticated pages
- [ ] Create `src/Views/layouts/dashboard.php` for dashboards

---

### Phase 5: Features & Functionality (Days 9-10)

#### 5.1 Contact Form
- [ ] Implement contact form submission
- [ ] Add email notification
- [ ] Add form validation
- [ ] Add CSRF protection
- [ ] Add rate limiting

#### 5.2 Service Request System
- [ ] Create service request form
- [ ] Add quote request functionality
- [ ] Email notifications to admin
- [ ] Admin dashboard for service requests

#### 5.3 Programme Enrollment
- [ ] Link programmes to LMS courses
- [ ] Create enrollment flow from public page to LMS
- [ ] Add payment integration (optional)
- [ ] Add application form for programmes

#### 5.4 Blog System
- [ ] Create blog post CRUD operations
- [ ] Add categories and tags
- [ ] Add featured images
- [ ] Add comments (optional)
- [ ] Add RSS feed

#### 5.5 Search Functionality
- [ ] Global search for courses, services, blog posts
- [ ] Search results page
- [ ] Search suggestions/autocomplete

---

### Phase 6: Content Migration (Day 11)

#### 6.1 Content Extraction
- [ ] Extract all text content from old website
- [ ] Extract images and assets
- [ ] Extract testimonials
- [ ] Extract team member information
- [ ] Extract service descriptions

#### 6.2 Content Formatting
- [ ] Format content for new design
- [ ] Optimize images
- [ ] Update links and references
- [ ] Proofread and edit content

#### 6.3 Asset Management
- [ ] Create `public/assets/images/services/`
- [ ] Create `public/assets/images/team/`
- [ ] Create `public/assets/images/projects/`
- [ ] Create `public/assets/images/testimonials/`
- [ ] Optimize all images for web

---

### Phase 7: SEO & Performance (Day 12)

#### 7.1 SEO Optimization
- [ ] Add meta tags to all pages
- [ ] Create sitemap.xml
- [ ] Create robots.txt
- [ ] Add Open Graph tags
- [ ] Add Twitter Card tags
- [ ] Add structured data (Schema.org)

#### 7.2 Performance Optimization
- [ ] Optimize images (WebP format)
- [ ] Minify CSS and JavaScript
- [ ] Enable browser caching
- [ ] Add lazy loading for images
- [ ] Optimize database queries

#### 7.3 Analytics
- [ ] Add Google Analytics
- [ ] Add Facebook Pixel (optional)
- [ ] Add conversion tracking
- [ ] Add event tracking

---

### Phase 8: Testing & Quality Assurance (Days 13-14)

#### 8.1 Functional Testing
- [ ] Test all public pages
- [ ] Test all forms
- [ ] Test navigation
- [ ] Test authentication flow
- [ ] Test enrollment process
- [ ] Test service request system

#### 8.2 Responsive Testing
- [ ] Test on mobile devices
- [ ] Test on tablets
- [ ] Test on different browsers (Chrome, Firefox, Safari, Edge)
- [ ] Test on different screen sizes

#### 8.3 Security Testing
- [ ] Test CSRF protection
- [ ] Test XSS protection
- [ ] Test SQL injection protection
- [ ] Test authentication & authorization
- [ ] Test file upload security

#### 8.4 Performance Testing
- [ ] Test page load times
- [ ] Test database query performance
- [ ] Test under load (stress testing)
- [ ] Test API response times

---

### Phase 9: Documentation & Training (Day 15)

#### 9.1 Documentation
- [ ] Update README.md
- [ ] Update ARCHITECTURE.md
- [ ] Create USER_GUIDE.md
- [ ] Create ADMIN_GUIDE.md
- [ ] Document API endpoints
- [ ] Document database schema

#### 9.2 Admin Training
- [ ] Create admin user guide
- [ ] Document content management
- [ ] Document service request management
- [ ] Document blog post management

---

### Phase 10: Deployment & Launch (Day 16)

#### 10.1 Pre-Deployment
- [ ] Backup current database
- [ ] Backup current files
- [ ] Test deployment on staging server
- [ ] Final security audit

#### 10.2 Deployment
- [ ] Deploy to production server
- [ ] Run database migrations
- [ ] Configure environment variables
- [ ] Test all functionality on production

#### 10.3 Post-Deployment
- [ ] Monitor error logs
- [ ] Monitor performance
- [ ] Monitor user feedback
- [ ] Fix any critical issues

---

## 4. Technical Specifications

### 4.1 New Database Tables

```sql
-- Services table
CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    uuid VARCHAR(36) UNIQUE NOT NULL,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    short_description TEXT,
    description TEXT,
    icon VARCHAR(100),
    image VARCHAR(255),
    features JSON,
    pricing_info TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    order_index INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Projects table
CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    uuid VARCHAR(36) UNIQUE NOT NULL,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    client_name VARCHAR(255),
    category VARCHAR(100),
    technologies JSON,
    image VARCHAR(255),
    gallery JSON,
    project_url VARCHAR(255),
    completion_date DATE,
    is_featured BOOLEAN DEFAULT FALSE,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Blog posts table
CREATE TABLE blog_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    uuid VARCHAR(36) UNIQUE NOT NULL,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    excerpt TEXT,
    content TEXT,
    featured_image VARCHAR(255),
    author_id INT,
    category VARCHAR(100),
    tags JSON,
    status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
    published_at TIMESTAMP NULL,
    views INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Testimonials table
CREATE TABLE testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    uuid VARCHAR(36) UNIQUE NOT NULL,
    client_name VARCHAR(255) NOT NULL,
    client_title VARCHAR(255),
    client_company VARCHAR(255),
    testimonial TEXT NOT NULL,
    rating INT DEFAULT 5,
    avatar VARCHAR(255),
    is_featured BOOLEAN DEFAULT FALSE,
    is_active BOOLEAN DEFAULT TRUE,
    order_index INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Service requests table
CREATE TABLE service_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    uuid VARCHAR(36) UNIQUE NOT NULL,
    service_id INT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50),
    company VARCHAR(255),
    message TEXT,
    status ENUM('pending', 'contacted', 'in_progress', 'completed', 'cancelled') DEFAULT 'pending',
    assigned_to INT,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE SET NULL,
    FOREIGN KEY (assigned_to) REFERENCES users(id) ON DELETE SET NULL
);

-- Contact messages table
CREATE TABLE contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    uuid VARCHAR(36) UNIQUE NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50),
    subject VARCHAR(255),
    message TEXT NOT NULL,
    status ENUM('new', 'read', 'replied', 'archived') DEFAULT 'new',
    replied_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### 4.2 New Controllers

**PublicController.php:**
- `home()` - Homepage
- `about()` - About page
- `projects()` - Projects portfolio
- `faq()` - FAQ page

**ServiceController.php:**
- `index()` - All services
- `show($slug)` - Service detail
- `requestQuote()` - Service request form
- `submitRequest()` - Handle service request

**ProgrammeController.php:**
- `index()` - All programmes
- `show($slug)` - Programme detail
- `enroll($id)` - Enroll in programme

**BlogController.php:**
- `index()` - All blog posts
- `show($slug)` - Blog post detail
- `category($category)` - Posts by category
- `search($query)` - Search posts

### 4.3 New Routes

```php
// Public Pages
$router->get('/', [PublicController::class, 'home']);
$router->get('/about', [PublicController::class, 'about']);
$router->get('/projects', [PublicController::class, 'projects']);
$router->get('/faq', [PublicController::class, 'faq']);

// Services
$router->get('/services', [ServiceController::class, 'index']);
$router->get('/services/{slug}', [ServiceController::class, 'show']);
$router->get('/request-quote', [ServiceController::class, 'requestQuote']);
$router->post('/request-quote', [ServiceController::class, 'submitRequest']);

// Programmes
$router->get('/programmes', [ProgrammeController::class, 'index']);
$router->get('/programmes/{slug}', [ProgrammeController::class, 'show']);
$router->post('/programmes/{id}/enroll', [ProgrammeController::class, 'enroll']);

// Blog
$router->get('/blog', [BlogController::class, 'index']);
$router->get('/blog/{slug}', [BlogController::class, 'show']);
$router->get('/blog/category/{category}', [BlogController::class, 'category']);

// Contact
$router->get('/contact', [ContactController::class, 'index']);
$router->post('/contact', [ContactController::class, 'submit']);
```

---

## 5. Design Guidelines

### 5.1 Color Scheme
- **Primary:** #1e40af (Blue)
- **Secondary:** #f97316 (Orange)
- **Success:** #10b981 (Green)
- **Warning:** #fbbf24 (Yellow)
- **Danger:** #ef4444 (Red)
- **Gray Scale:** Tailwind default grays

### 5.2 Typography
- **Headings:** Font-bold, varying sizes
- **Body:** Font-normal, text-gray-600
- **Links:** text-primary hover:text-blue-700

### 5.3 Components
- **Buttons:** Rounded-lg, shadow, hover effects
- **Cards:** White background, rounded-xl, shadow-lg
- **Forms:** Clean inputs with focus states
- **Navigation:** Sticky header, dropdown menus

### 5.4 Responsive Breakpoints
- **Mobile:** < 640px
- **Tablet:** 640px - 1024px
- **Desktop:** > 1024px

---

## 6. Content Strategy

### 6.1 Homepage Content
**Hero Section:**
- Headline: "Empowering businesses and individuals with cutting-edge technology solutions"
- Subheadline: "IT Services • Training Programmes • Innovation"
- CTA: "Explore Services" | "View Programmes"

**Services Section:**
- 4 featured services with icons
- Brief descriptions
- "View All Services" button

**Programmes Section:**
- 4 featured programmes
- Pricing and duration
- "View All Programmes" button

**Why Choose Nebatech:**
- Expertise
- Reliability
- Customer-Centric
- Innovation

**Testimonials:**
- Carousel with 3-4 testimonials
- Client names and titles

**Stats:**
- Projects Completed
- Students Trained
- Years of Experience
- Client Satisfaction

### 6.2 Services Content
Each service page should include:
- Service overview
- Key features (bullet points)
- Benefits
- Technologies used
- Pricing information (optional)
- Call-to-action (Request Quote)
- Related services

### 6.3 Programmes Content
Each programme page should include:
- Programme overview
- Learning outcomes
- Curriculum outline
- Duration and schedule
- Pricing
- Prerequisites
- Certification
- Call-to-action (Enroll Now)
- Related programmes

---

## 7. Success Metrics

### 7.1 Technical Metrics
- Page load time < 3 seconds
- Mobile responsiveness score > 95
- SEO score > 90
- Security score > 95
- Uptime > 99.9%

### 7.2 Business Metrics
- Increase in service inquiries
- Increase in programme enrollments
- Improved user engagement
- Reduced bounce rate
- Increased time on site

---

## 8. Risk Management

### 8.1 Potential Risks
1. **Data Loss:** Backup all data before migration
2. **Downtime:** Deploy during off-peak hours
3. **Broken Links:** Test all links thoroughly
4. **SEO Impact:** Implement proper redirects
5. **User Confusion:** Clear navigation and onboarding

### 8.2 Mitigation Strategies
- Comprehensive testing
- Staged deployment
- Rollback plan
- User feedback collection
- Continuous monitoring

---

## 9. Post-Launch Activities

### 9.1 Monitoring
- Monitor error logs daily
- Track user analytics weekly
- Review performance metrics
- Collect user feedback

### 9.2 Maintenance
- Regular security updates
- Content updates
- Bug fixes
- Feature enhancements

### 9.3 Marketing
- Announce new platform
- Email existing users
- Social media promotion
- SEO optimization

---

## 10. Timeline Summary

**Total Duration:** 16 days (approximately 3 weeks)

- **Phase 1:** Foundation (2 days)
- **Phase 2:** Public Pages (3 days)
- **Phase 3:** Integration (2 days)
- **Phase 4:** Navigation (1 day)
- **Phase 5:** Features (2 days)
- **Phase 6:** Content Migration (1 day)
- **Phase 7:** SEO & Performance (1 day)
- **Phase 8:** Testing (2 days)
- **Phase 9:** Documentation (1 day)
- **Phase 10:** Deployment (1 day)

---

## 11. Team Responsibilities

### Developer (You/AI)
- All coding and implementation
- Database design and migration
- Testing and debugging
- Deployment

### Content Manager (Client)
- Content review and approval
- Image selection
- Final proofreading
- User acceptance testing

### Project Manager (Client)
- Decision making
- Feedback and approvals
- Timeline management
- Stakeholder communication

---

## 12. Conclusion

This integration plan transforms the Nebatech AI Academy LMS into a comprehensive platform that serves both as a corporate website and an educational platform. The unified design, seamless navigation, and integrated functionality will provide users with a cohesive experience whether they're seeking IT services or enrolling in training programmes.

**Next Steps:**
1. Review and approve this plan
2. Gather any missing content or assets
3. Begin Phase 1 implementation
4. Regular progress updates and reviews

---

**Document Version:** 1.0  
**Last Updated:** 2025-01-11  
**Status:** Awaiting Approval
