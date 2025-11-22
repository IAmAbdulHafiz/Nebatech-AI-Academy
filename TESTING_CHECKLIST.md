# Testing Checklist - Nebatech AI Academy
## Feature Implementation Verification

---

## ✅ TESTING CHECKLIST

### 1. Blog System Testing

#### Database Setup:
- [ ] Run `database/schema.sql` to create new tables
- [ ] Verify tables exist: `blog_posts`, `blog_categories`, `blog_comments`, `blog_likes`
- [ ] Check table structure matches schema

#### Blog Listing Page (`/blog`):
- [ ] Page loads without errors
- [ ] Categories display in sidebar
- [ ] Featured post displays (if exists)
- [ ] Blog posts list displays (empty or with data)
- [ ] Search box functional
- [ ] Filter by category works
- [ ] Filter by tag works

#### Individual Blog Post (`/blog/{slug}`):
- [ ] Post displays with title, content, author
- [ ] Featured image displays
- [ ] Category badge shows
- [ ] Meta info displays (date, read time, views)
- [ ] View counter increments on page load
- [ ] Tags display as clickable links
- [ ] Social share buttons present
- [ ] Author bio section displays
- [ ] Related articles show (3 items)

#### Blog Comments:
- [ ] Comment form displays
- [ ] Requires login to submit comment
- [ ] Comment submission successful
- [ ] Comment appears in list (if status = 'approved')
- [ ] Nested replies supported (parent_id)

#### Test SQL for Sample Data:
```sql
-- Insert sample category
INSERT INTO blog_categories (name, slug, color, status) 
VALUES ('Tutorials', 'tutorials', '#002060', 'active');

-- Insert sample post
INSERT INTO blog_posts (uuid, title, slug, content, author_id, category_id, status, is_featured, created_at) 
VALUES (UUID(), 'Getting Started with AI', 'getting-started-with-ai', '<p>This is a sample blog post about AI...</p>', 1, 1, 'published', 1, NOW());
```

---

### 2. Newsletter System Testing

#### Newsletter Subscription:
- [ ] Footer newsletter form displays
- [ ] Email validation works (invalid email rejected)
- [ ] Valid email submission successful
- [ ] Success flash message appears
- [ ] Duplicate subscription shows info message
- [ ] Database record created in `newsletter_subscriptions`
- [ ] Unsubscribe token generated (64 characters)

#### Newsletter Unsubscription:
- [ ] Unsubscribe link works: `/newsletter/unsubscribe?token=xxx`
- [ ] Token validation successful
- [ ] Status updated to 'unsubscribed' in database
- [ ] Confirmation page displays
- [ ] Feedback form appears
- [ ] Re-subscribe option works

#### Test SQL:
```sql
-- Check subscription
SELECT * FROM newsletter_subscriptions WHERE email = 'test@example.com';

-- Verify token
SELECT token FROM newsletter_subscriptions WHERE email = 'test@example.com';
```

---

### 3. Contact Form Testing

#### Contact Form Submission:
- [ ] Contact form displays at `/contact`
- [ ] All fields present: name, email, phone, subject, message
- [ ] Email validation works
- [ ] Required field validation works
- [ ] Form submission successful
- [ ] Success flash message appears
- [ ] Database record created in `contact_submissions`
- [ ] IP address captured
- [ ] User agent captured
- [ ] Timestamp recorded

#### Admin Review:
- [ ] Submission viewable in admin panel (if exists)
- [ ] Status can be updated
- [ ] Assignment to staff member works

#### Test SQL:
```sql
-- Check submission
SELECT * FROM contact_submissions ORDER BY created_at DESC LIMIT 5;
```

---

### 4. Draft Auto-Save Testing

#### Community Post Creation:
- [ ] Navigate to `/community/create`
- [ ] Start typing title and content
- [ ] Click "Save Draft" button manually
- [ ] Success toast appears: "Draft saved successfully!"
- [ ] Check localStorage: `community_post_draft` key exists
- [ ] Check browser Network tab: POST to `/api/drafts/save` sent
- [ ] Database record created in `draft_posts`

#### Auto-Save:
- [ ] Type content and wait 30 seconds
- [ ] Auto-save triggers automatically
- [ ] Toast notification appears
- [ ] Database updated with latest content

#### Draft Retrieval:
- [ ] GET `/api/drafts` returns user's drafts
- [ ] JSON response includes title, content, metadata

#### Test SQL:
```sql
-- Check draft
SELECT * FROM draft_posts WHERE user_id = 1 ORDER BY updated_at DESC;
```

---

### 5. Admin Notes Testing

#### Application Review Page:
- [ ] Navigate to admin application review page
- [ ] Login as admin/instructor/staff role
- [ ] Internal notes textarea displays
- [ ] Type notes content
- [ ] Click "Save Notes" button
- [ ] Success alert appears
- [ ] Check browser Network tab: POST to `/admin/applications/notes` sent
- [ ] Database record created in `application_notes`

#### Notes Persistence:
- [ ] Refresh page
- [ ] Notes load from database
- [ ] Edit notes and save again
- [ ] Database record updated (not duplicated)

#### Audit Trail:
- [ ] Check `admin_action_logs` table for action log
- [ ] Verify: user_id, action, resource_id, ip_address, timestamp

#### Test SQL:
```sql
-- Check notes
SELECT * FROM application_notes WHERE application_id = 1;

-- Check audit log
SELECT * FROM admin_action_logs WHERE action = 'update_application_notes' ORDER BY created_at DESC LIMIT 5;
```

---

### 6. Error Pages Testing

#### 404 Page Not Found:
- [ ] Visit non-existent URL: `/this-page-does-not-exist`
- [ ] Custom 404 page displays (not default server error)
- [ ] Page shows "404" text
- [ ] Search icon displays
- [ ] 3 CTA buttons functional (Home, Courses, Contact)
- [ ] 4 helpful links cards display
- [ ] Search form at bottom works
- [ ] Dark mode toggle works (if applicable)

#### 500 Server Error:
- [ ] Trigger server error (e.g., syntax error in controller)
- [ ] Custom 500 page displays
- [ ] "Something Went Wrong" message shows
- [ ] Try Again button works (refreshes page)
- [ ] Go Home button redirects to `/`
- [ ] Get Support button redirects to `/support`
- [ ] Contact info displays (email, phone)

#### 403 Access Denied:
- [ ] Attempt to access restricted page without permission
- [ ] Custom 403 page displays
- [ ] "Access Denied" message shows
- [ ] Login button redirects to `/login`
- [ ] Go Home button works
- [ ] Contact Support button works
- [ ] Information box explains possible reasons

---

### 7. Security Testing

#### XSS Vulnerability Fix:
- [ ] Navigate to `/community/events?filter=<script>alert('XSS')</script>`
- [ ] No JavaScript alert appears
- [ ] Filter parameter sanitized
- [ ] Only whitelisted values accepted: 'upcoming', 'past', 'my-events'
- [ ] Invalid filter value defaults to 'upcoming'

#### SQL Injection Prevention:
- [ ] Test blog comment with SQL injection: `'; DROP TABLE users; --`
- [ ] Comment saved as plain text (not executed)
- [ ] Database tables intact

---

### 8. SEO & Sitemap Testing

#### XML Sitemap:
- [ ] Visit `/sitemap.xml`
- [ ] Valid XML format displays
- [ ] Includes static pages (home, about, courses, blog, etc.)
- [ ] Includes dynamic content (blog posts, courses)
- [ ] Each URL has: `<loc>`, `<lastmod>`, `<changefreq>`, `<priority>`
- [ ] No broken links in sitemap

#### Robots.txt:
- [ ] Visit `/robots.txt`
- [ ] Plain text format displays
- [ ] Contains `User-agent: *`
- [ ] Disallows: `/admin/`, `/api/`, `/dashboard/`
- [ ] Sitemap URL included: `Sitemap: https://nebatech.com/sitemap.xml`

#### SEO Validation:
- [ ] Submit sitemap to Google Search Console
- [ ] Validate XML sitemap with online validator
- [ ] Check for 404 errors in sitemap URLs

---

## 🔍 BROWSER TESTING

### Browsers to Test:
- [ ] Chrome (latest)
- [ ] Firefox (latest)
- [ ] Safari (latest)
- [ ] Edge (latest)
- [ ] Mobile Chrome (Android)
- [ ] Mobile Safari (iOS)

### Responsive Testing:
- [ ] Desktop (1920x1080)
- [ ] Laptop (1366x768)
- [ ] Tablet (768x1024)
- [ ] Mobile (375x667)

---

## 🛠️ DEVELOPER TOOLS CHECKS

### Network Tab:
- [ ] No 404 errors for assets (CSS, JS, images)
- [ ] API calls return 200 status
- [ ] No CORS errors
- [ ] Response times acceptable (<500ms)

### Console Tab:
- [ ] No JavaScript errors
- [ ] No warnings (or only expected warnings)
- [ ] No mixed content warnings (HTTP/HTTPS)

### Performance:
- [ ] Page load time <3 seconds
- [ ] Images optimized (WebP or compressed)
- [ ] CSS/JS minified (if production)

---

## 📊 DATABASE VERIFICATION

### Run These Queries:

```sql
-- Verify all tables exist
SHOW TABLES LIKE 'blog_%';
SHOW TABLES LIKE 'newsletter_%';
SHOW TABLES LIKE 'contact_%';
SHOW TABLES LIKE 'draft_%';
SHOW TABLES LIKE 'application_notes';
SHOW TABLES LIKE 'admin_action_logs';

-- Check table structures
DESCRIBE blog_posts;
DESCRIBE newsletter_subscriptions;
DESCRIBE contact_submissions;
DESCRIBE draft_posts;
DESCRIBE application_notes;

-- Verify indexes
SHOW INDEX FROM blog_posts;
SHOW INDEX FROM newsletter_subscriptions;

-- Check foreign keys
SELECT 
  TABLE_NAME, COLUMN_NAME, CONSTRAINT_NAME, 
  REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
WHERE TABLE_SCHEMA = 'nebatech_db' 
  AND REFERENCED_TABLE_NAME IS NOT NULL;
```

---

## 🎯 ACCEPTANCE CRITERIA

### Must Pass:
- [ ] All 8 feature areas functional
- [ ] No console errors
- [ ] No 404 errors for routes
- [ ] Database tables created successfully
- [ ] Security vulnerability fixed
- [ ] Error pages display correctly
- [ ] Sitemap accessible

### Nice to Have:
- [ ] Sample blog posts seeded
- [ ] Email notifications working
- [ ] Performance optimized
- [ ] Mobile responsive tested

---

## 📝 TESTING NOTES

**Tester Name:** _____________________  
**Date Tested:** _____________________  
**Browser/Device:** _____________________

### Issues Found:
1. ___________________________________
2. ___________________________________
3. ___________________________________

### Comments:
___________________________________
___________________________________
___________________________________

---

## 🚀 DEPLOYMENT CHECKLIST

Before deploying to production:
- [ ] All tests passed
- [ ] Database schema applied to production
- [ ] Environment variables configured (.env)
- [ ] SMTP settings configured for emails
- [ ] SSL certificate active (HTTPS)
- [ ] Backup database before deployment
- [ ] Test on staging environment first
- [ ] Monitor error logs after deployment

---

**Status:** Ready for Testing  
**Last Updated:** January 2025
