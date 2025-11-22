# API Documentation - Nebatech AI Academy
## RESTful API Endpoints Reference

**Base URL:** `https://nebatech.com`  
**API Version:** v1  
**Last Updated:** January 2025

---

## 📋 TABLE OF CONTENTS

1. [Authentication](#authentication)
2. [Blog System](#blog-system)
3. [Newsletter](#newsletter)
4. [Contact](#contact)
5. [Drafts](#drafts)
6. [Admin Notes](#admin-notes)
7. [Courses](#courses)
8. [Submissions](#submissions)
9. [Error Codes](#error-codes)

---

## 🔐 AUTHENTICATION

All authenticated endpoints require a valid session or API token.

### Check Authentication Status
```http
GET /api/auth/status
```

**Response:**
```json
{
  "authenticated": true,
  "user": {
    "id": 123,
    "email": "user@example.com",
    "role": "student"
  }
}
```

---

## 📝 BLOG SYSTEM

### 1. Get Blog Posts
```http
GET /blog?category={slug}&tag={tag}&search={query}
```

**Query Parameters:**
- `category` (optional) - Filter by category slug
- `tag` (optional) - Filter by tag
- `search` (optional) - Search in title/excerpt/content

**Example:**
```
GET /blog?category=tutorials&search=python
```

### 2. Get Single Blog Post
```http
GET /blog/{slug}
```

**Example:**
```
GET /blog/getting-started-python-ai
```

**Response:** HTML page with post content

### 3. Submit Comment
```http
POST /blog/comment
```

**Headers:**
```
Content-Type: application/x-www-form-urlencoded
```

**Body Parameters:**
- `post_id` (required) - Integer
- `content` (required) - String
- `parent_id` (optional) - Integer (for nested replies)

**Authentication:** Required (must be logged in)

**Example Request:**
```bash
curl -X POST https://nebatech.com/blog/comment \
  -H "Cookie: session=xxx" \
  -d "post_id=5&content=Great article!"
```

**Response:** Redirect to post with success message

**Error Responses:**
- `401 Unauthorized` - Not logged in
- `400 Bad Request` - Missing required fields
- `404 Not Found` - Post doesn't exist

---

## 📧 NEWSLETTER

### 1. Subscribe to Newsletter
```http
POST /newsletter/subscribe
```

**Body Parameters:**
- `email` (required) - Valid email address
- `source` (optional) - String (e.g., "footer", "blog_page")

**Example Request:**
```bash
curl -X POST https://nebatech.com/newsletter/subscribe \
  -d "email=user@example.com&source=footer"
```

**Response:** Redirect with flash message

**Flash Messages:**
- Success: "Thank you for subscribing!"
- Error: "Invalid email address"
- Info: "You're already subscribed"

### 2. Unsubscribe from Newsletter
```http
GET /newsletter/unsubscribe?token={token}
```

**Query Parameters:**
- `token` (required) - 64-character unsubscribe token

**Example:**
```
GET /newsletter/unsubscribe?token=abc123...xyz789
```

**Response:** Unsubscribed confirmation page

---

## 📞 CONTACT

### 1. Submit Contact Form
```http
POST /contact
```

**Body Parameters:**
- `name` (required) - String
- `email` (required) - Valid email
- `phone` (optional) - String
- `subject` (required) - String
- `message` (required) - Text

**Example Request:**
```bash
curl -X POST https://nebatech.com/contact \
  -d "name=John Doe" \
  -d "email=john@example.com" \
  -d "subject=Inquiry" \
  -d "message=I would like to know more..."
```

**Response:** Redirect to `/contact?success=1`

**Validation Rules:**
- Name: Required, max 100 characters
- Email: Required, valid email format
- Subject: Required, max 200 characters
- Message: Required, max 5000 characters

---

## 💾 DRAFTS

### 1. Save Draft
```http
POST /api/drafts/save
```

**Headers:**
```
Content-Type: application/json
```

**Body (JSON):**
```json
{
  "type": "discussion",
  "title": "My Draft Title",
  "content": "Draft content here...",
  "category_id": 3,
  "tags": ["javascript", "tutorial"],
  "metadata": {
    "source": "web",
    "draft_version": 2
  }
}
```

**Authentication:** Required

**Response:**
```json
{
  "success": true,
  "message": "Draft saved successfully",
  "draft_id": 42
}
```

**Draft Types:**
- `discussion`
- `blog`
- `question`
- `resource`

### 2. List User's Drafts
```http
GET /api/drafts?type={type}
```

**Query Parameters:**
- `type` (optional) - Filter by draft type

**Authentication:** Required

**Response:**
```json
{
  "success": true,
  "drafts": [
    {
      "id": 42,
      "type": "discussion",
      "title": "My Draft",
      "content": "...",
      "tags": ["javascript"],
      "created_at": "2025-01-15 10:30:00",
      "updated_at": "2025-01-15 12:45:00"
    }
  ]
}
```

### 3. Delete Draft
```http
DELETE /api/drafts/{id}
```

**Alternative (for browsers without DELETE support):**
```http
POST /api/drafts/{id}/delete
```

**Authentication:** Required

**Response:**
```json
{
  "success": true,
  "message": "Draft deleted successfully"
}
```

---

## 📋 ADMIN NOTES

### 1. Save Application Notes
```http
POST /admin/applications/notes
```

**Headers:**
```
Content-Type: application/json
```

**Body (JSON):**
```json
{
  "application_id": "550e8400-e29b-41d4-a716-446655440000",
  "notes": "Internal notes about this application..."
}
```

**Authentication:** Required (admin/instructor/staff only)

**Response:**
```json
{
  "success": true,
  "message": "Notes saved successfully",
  "note_id": 15
}
```

**Permissions:**
- Allowed roles: `admin`, `instructor`, `staff`
- Returns `403 Forbidden` for unauthorized users

### 2. Get Application Notes
```http
GET /admin/applications/notes?application_id={uuid}
```

**Query Parameters:**
- `application_id` (required) - Application UUID

**Authentication:** Required (admin/instructor/staff only)

**Response:**
```json
{
  "success": true,
  "notes": {
    "id": 15,
    "notes": "Internal notes...",
    "created_by_first_name": "John",
    "created_by_last_name": "Doe",
    "created_at": "2025-01-15 10:00:00",
    "updated_at": "2025-01-15 12:00:00"
  }
}
```

**If no notes exist:**
```json
{
  "success": true,
  "notes": null
}
```

---

## 🎓 COURSES

### 1. List Courses
```http
GET /api/courses
```

**Response:**
```json
{
  "success": true,
  "courses": [
    {
      "id": 1,
      "uuid": "...",
      "title": "AI Fundamentals",
      "slug": "ai-fundamentals",
      "level": "beginner"
    }
  ]
}
```

### 2. Get Course Details
```http
GET /api/courses/{id}
```

### 3. Create Course (Admin only)
```http
POST /api/courses
```

### 4. Update Course (Admin only)
```http
PUT /api/courses/{id}
```

### 5. Delete Course (Admin only)
```http
DELETE /api/courses/{id}
```

---

## 📤 SUBMISSIONS

### 1. Submit Assignment
```http
POST /api/submissions
```

**Body (Multipart form-data):**
```
assignment_id: 5
file: [binary file data]
comment: "My submission notes"
```

### 2. Get Submission
```http
GET /api/submissions/{id}
```

### 3. Grade Submission (Instructor only)
```http
POST /api/submissions/{id}/grade
```

**Body (JSON):**
```json
{
  "grade": 85,
  "feedback": "Excellent work!"
}
```

---

## 🗺️ SEO ENDPOINTS

### 1. XML Sitemap
```http
GET /sitemap.xml
```

**Response:** XML document with all public URLs

**Content-Type:** `application/xml`

### 2. Robots.txt
```http
GET /robots.txt
```

**Response:**
```
User-agent: *
Allow: /
Disallow: /admin/
Disallow: /api/
Disallow: /dashboard/

Sitemap: https://nebatech.com/sitemap.xml
```

---

## ❌ ERROR CODES

### HTTP Status Codes

| Code | Meaning | Description |
|------|---------|-------------|
| 200 | OK | Request successful |
| 201 | Created | Resource created successfully |
| 400 | Bad Request | Invalid request parameters |
| 401 | Unauthorized | Authentication required |
| 403 | Forbidden | Insufficient permissions |
| 404 | Not Found | Resource doesn't exist |
| 405 | Method Not Allowed | Wrong HTTP method |
| 422 | Unprocessable Entity | Validation error |
| 500 | Internal Server Error | Server error |

### Error Response Format

```json
{
  "success": false,
  "message": "Error description",
  "errors": {
    "field_name": ["Error message 1", "Error message 2"]
  }
}
```

### Common Error Messages

**Authentication Errors:**
- `"Authentication required"` - User not logged in
- `"Insufficient permissions"` - User lacks required role
- `"Invalid credentials"` - Wrong username/password

**Validation Errors:**
- `"Email is required"` - Missing required field
- `"Invalid email format"` - Email validation failed
- `"Field must be at least X characters"` - Length validation

**Resource Errors:**
- `"Resource not found"` - Requested item doesn't exist
- `"Duplicate entry"` - Unique constraint violation

---

## 🔧 TESTING

### Example: Test Draft Save (cURL)

```bash
curl -X POST https://nebatech.com/api/drafts/save \
  -H "Content-Type: application/json" \
  -H "Cookie: session=your_session_cookie" \
  -d '{
    "type": "discussion",
    "title": "Test Draft",
    "content": "This is a test draft",
    "tags": ["test"]
  }'
```

### Example: Test Newsletter Subscribe (JavaScript)

```javascript
async function subscribe() {
  const formData = new FormData();
  formData.append('email', 'test@example.com');
  formData.append('source', 'footer');
  
  const response = await fetch('/newsletter/subscribe', {
    method: 'POST',
    body: formData
  });
  
  // Follow redirect
  window.location.href = response.url;
}
```

### Example: Test Admin Notes (Fetch API)

```javascript
async function saveNotes() {
  const response = await fetch('/admin/applications/notes', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      application_id: 'uuid-here',
      notes: 'Internal admin notes...'
    })
  });
  
  const data = await response.json();
  console.log(data);
}
```

---

## 📚 ADDITIONAL RESOURCES

- **Postman Collection:** Download from `/docs/api/postman-collection.json`
- **OpenAPI Spec:** View at `/docs/api/openapi.yaml`
- **Rate Limits:** 1000 requests/hour per IP
- **Support:** api-support@nebatech.com

---

**Version History:**
- v1.0 (2025-01-15) - Initial API documentation
- Draft/Notes endpoints added
- SEO endpoints documented

**Maintained by:** Nebatech Development Team
