# Security Implementation Guide

Quick reference for using the new security features in Nebatech AI Academy.

---

## 1. Output Escaping (XSS Prevention)

### Always escape user-generated content in views:

```php
<!-- ❌ WRONG - Vulnerable to XSS -->
<h1><?= $course['title'] ?></h1>
<p><?= $user['bio'] ?></p>

<!-- ✅ CORRECT - Safe from XSS -->
<h1><?= e($course['title']) ?></h1>
<p><?= e($user['bio']) ?></p>
```

### When NOT to escape:
```php
<!-- When you need to render HTML (use with caution) -->
<div class="content">
    <?= $trustedHtmlContent ?>  <!-- Only if content is sanitized server-side -->
</div>
```

---

## 2. CSRF Protection

### In Forms:
```php
<form method="POST" action="<?= url('/courses/create') ?>">
    <?= csrf_field() ?>
    
    <input type="text" name="title">
    <button type="submit">Create Course</button>
</form>
```

### In AJAX Requests:
```javascript
fetch('/api/courses', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '<?= csrf_token() ?>'
    },
    body: JSON.stringify(data)
});
```

### Excluding Routes from CSRF:
```php
// In CsrfMiddleware.php
protected array $except = [
    '/api/*',           // All API routes
    '/webhooks/*',      // Webhook endpoints
];
```

---

## 3. Input Validation

### Using ValidationService:

```php
use Nebatech\Services\ValidationService;
use Nebatech\Exceptions\ValidationException;

try {
    $validated = ValidationService::make($_POST, [
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
        'role' => 'required|in:student,facilitator,admin',
        'bio' => 'max:500'
    ]);
    
    // Use $validated data (already sanitized)
    
} catch (ValidationException $e) {
    // Handle validation errors
    $errors = $e->getErrors();
    // Returns: ['email' => ['Email is required'], ...]
}
```

### Custom Error Messages:
```php
$validated = ValidationService::make($_POST, [
    'email' => 'required|email',
    'password' => 'required|min:8'
], [
    'email.required' => 'Please provide your email address',
    'email.email' => 'The email format is invalid',
    'password.min' => 'Password must be at least 8 characters long'
]);
```

### Available Validation Rules:
- `required` - Field must be present
- `email` - Valid email format
- `url` - Valid URL format
- `min:n` - Minimum length
- `max:n` - Maximum length
- `numeric` - Must be numeric
- `integer` - Must be integer
- `alpha` - Letters only
- `alphanumeric` - Letters and numbers only
- `in:a,b,c` - Must be one of the values
- `confirmed` - Must have matching `_confirmation` field
- `same:field` - Must match another field
- `different:field` - Must differ from another field

---

## 4. Exception Handling

### In Controllers:

```php
use Nebatech\Exceptions\AuthenticationException;
use Nebatech\Exceptions\AuthorizationException;
use Nebatech\Exceptions\ValidationException;

class CourseController extends Controller
{
    public function create()
    {
        // Authentication check
        if (!isset($_SESSION['user_id'])) {
            throw new AuthenticationException();
        }
        
        // Authorization check
        if (!is_facilitator()) {
            throw new AuthorizationException('Only facilitators can create courses');
        }
        
        // Validation
        $validated = ValidationService::make($_POST, [
            'title' => 'required|min:3|max:255'
        ]);
        
        // Process...
    }
}
```

### Custom Exceptions:
```php
// Create your own
namespace Nebatech\Exceptions;

class CourseNotFoundException extends \Exception
{
    public function __construct(string $courseId)
    {
        parent::__construct("Course not found: {$courseId}", 404);
    }
}

// Use it
throw new CourseNotFoundException($courseId);
```

---

## 5. Database Security

### Table Name Validation:
```php
// ✅ SAFE - Table is whitelisted
Database::insert('users', $data);
Database::update('courses', $data, 'id = :id', ['id' => $id]);

// ❌ THROWS EXCEPTION - Table not whitelisted
Database::insert('malicious_table', $data);
```

### Adding New Tables to Whitelist:
```php
// In src/Core/Database.php
private static array $allowedTables = [
    'users', 'courses', 'modules', 'lessons',
    'your_new_table',  // Add here
];
```

### Always Use Prepared Statements:
```php
// ✅ SAFE - Uses prepared statements
$user = Database::fetch(
    'SELECT * FROM users WHERE email = :email',
    ['email' => $email]
);

// ❌ NEVER DO THIS - SQL Injection vulnerability
$user = Database::fetch("SELECT * FROM users WHERE email = '$email'");
```

---

## 6. Authentication & Authorization

### Require Authentication:
```php
class DashboardController extends Controller
{
    public function index()
    {
        $this->requireAuth();  // Throws AuthenticationException if not logged in
        
        // Your code...
    }
}
```

### Require Specific Role:
```php
class FacilitatorController extends Controller
{
    public function studio()
    {
        $this->requireRole('facilitator');  // Throws AuthorizationException if not facilitator
        
        // Your code...
    }
}
```

### Check Roles in Views:
```php
<?php if (is_facilitator()): ?>
    <a href="<?= url('/facilitator/studio') ?>">Facilitator Studio</a>
<?php endif; ?>

<?php if (is_admin()): ?>
    <a href="<?= url('/admin/dashboard') ?>">Admin Dashboard</a>
<?php endif; ?>

<?php if (has_any_role(['facilitator', 'admin'])): ?>
    <a href="<?= url('/courses/create') ?>">Create Course</a>
<?php endif; ?>
```

---

## 7. Rate Limiting

### Apply to Routes:
```php
// In routes/web.php
use Nebatech\Middleware\RateLimitMiddleware;

$router->middleware(RateLimitMiddleware::class, function($router) {
    $router->post('/login', [AuthController::class, 'login']);
    $router->post('/register', [AuthController::class, 'register']);
});
```

### Customize Limits:
```php
// Create custom rate limiter
class StrictRateLimitMiddleware extends RateLimitMiddleware
{
    protected int $maxAttempts = 10;  // 10 requests
    protected int $decayMinutes = 5;   // per 5 minutes
}
```

---

## 8. Logging

### Manual Logging:
```php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$logger = new Logger('app');
$logger->pushHandler(new StreamHandler(__DIR__ . '/../../storage/logs/app.log', Logger::INFO));

// Log levels
$logger->debug('Debug information');
$logger->info('Informational message');
$logger->warning('Warning message');
$logger->error('Error message', ['user_id' => $userId]);
$logger->critical('Critical issue');
```

### Automatic Request Logging:
```php
// Apply LoggingMiddleware to routes
use Nebatech\Middleware\LoggingMiddleware;

$router->middleware(LoggingMiddleware::class, function($router) {
    // All routes here will be logged
});
```

---

## 9. Error Handling Best Practices

### In Production:
```env
APP_ENV=production
APP_DEBUG=false
```

### In Development:
```env
APP_ENV=development
APP_DEBUG=true
```

### Log Errors, Don't Display:
```php
try {
    // Risky operation
} catch (\Exception $e) {
    // ✅ CORRECT - Log and show generic message
    error_log('Operation failed: ' . $e->getMessage());
    throw new \Exception('Operation failed. Please try again.');
    
    // ❌ WRONG - Exposes internal details
    throw new \Exception('Database error: ' . $e->getMessage());
}
```

---

## 10. Security Checklist

### Before Every Commit:
- [ ] All user input is validated
- [ ] All output is escaped with `e()`
- [ ] CSRF tokens in all forms
- [ ] No sensitive data in error messages
- [ ] Database queries use prepared statements
- [ ] Authentication checks on protected routes
- [ ] Authorization checks for role-specific actions

### Before Deployment:
- [ ] `APP_DEBUG=false` in production
- [ ] All tests passing
- [ ] Security headers configured
- [ ] HTTPS enabled
- [ ] Database backups configured
- [ ] Error logging configured
- [ ] Rate limiting on sensitive endpoints

---

## Common Vulnerabilities to Avoid

### 1. XSS (Cross-Site Scripting)
```php
// ❌ Vulnerable
echo $userInput;

// ✅ Safe
echo e($userInput);
```

### 2. SQL Injection
```php
// ❌ Vulnerable
$query = "SELECT * FROM users WHERE id = $userId";

// ✅ Safe
$query = "SELECT * FROM users WHERE id = :id";
Database::fetch($query, ['id' => $userId]);
```

### 3. CSRF (Cross-Site Request Forgery)
```php
// ❌ Vulnerable - No CSRF protection
<form method="POST">
    <input name="email">
</form>

// ✅ Safe - CSRF token included
<form method="POST">
    <?= csrf_field() ?>
    <input name="email">
</form>
```

### 4. Insecure Direct Object Reference
```php
// ❌ Vulnerable - No ownership check
$course = Course::find($_GET['id']);
$course->delete();

// ✅ Safe - Verify ownership
$course = Course::find($_GET['id']);
if ($course['facilitator_id'] !== $_SESSION['user_id']) {
    throw new AuthorizationException();
}
$course->delete();
```

### 5. Sensitive Data Exposure
```php
// ❌ Vulnerable - Returns password
return json_encode($user);

// ✅ Safe - Remove sensitive fields
unset($user['password']);
return json_encode($user);
```

---

## Quick Reference Commands

### Run Tests:
```bash
vendor/bin/phpunit
vendor/bin/phpunit --testsuite Unit
vendor/bin/phpunit --coverage-html coverage
```

### Check Logs:
```bash
tail -f storage/logs/app.log
```

### Clear Cache:
```bash
rm -rf storage/cache/*
```

---

**Remember:** Security is not a one-time task. Review and update regularly!
