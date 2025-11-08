# Role-Specific Layouts Implementation

## Overview
Implemented separate portal layouts for each user role (Student, Facilitator, Admin) with unique navigation, color schemes, and features.

## Files Created

### 1. Student Portal Layout (`src/Views/layouts/student.php`)
- **Theme**: Blue and white, learning-focused
- **Navigation**:
  - Dashboard
  - My Courses
  - Browse Courses
  - Assignments (with pending badge)
  - Code Editor
  - My Progress
  - Certificates
  - My Portfolio
  - My Applications
  - Help & Support
- **Features**: 
  - Search functionality
  - Notification counter
  - Profile dropdown
  - Responsive sidebar overlay
  - Flash message handling
  - Mobile-friendly navigation

### 2. Facilitator Studio Layout (`src/Views/layouts/facilitator.php`)
- **Theme**: Purple gradient (purple-900 to purple-800)
- **Navigation**:
  - Dashboard
  - My Courses
  - Create Course (quick action button in header)
  - Submissions (with pending badge in yellow)
  - Grading
  - My Students
  - AI Content Generator
  - Analytics
  - Resources
  - Messages (with unread badge in green)
- **Features**:
  - Course creation button in header
  - Pending submission notifications
  - Unread message counter
  - Profile dropdown
  - Responsive design
  - Flash messages

### 3. Admin Panel Layout (`src/Views/layouts/admin.php`)
- **Theme**: Dark gray gradient (gray-900 to gray-800)
- **Navigation** (Organized in Sections):
  - **Admissions**: Applications (with pending badge), Cohorts
  - **User Management**: All Users, Facilitators, Students
  - **Content**: Courses, Programs, Certificates
  - **System**: Analytics, Reports, Settings, Activity Logs
- **Features**:
  - Quick stats in header (total users, total courses)
  - Pending applications badge
  - Notification counter
  - System version display in footer
  - Profile dropdown
  - Responsive sidebar
  - Flash messages

## Core Implementation

### Controller Base Class Updates (`src/Core/Controller.php`)

Added new `render()` method that:
1. Auto-detects user role from session
2. Loads the appropriate layout based on role:
   - `student` → `layouts/student.php`
   - `facilitator` → `layouts/facilitator.php`
   - `admin` → `layouts/admin.php`
   - Default → `layouts/main.php`
3. Wraps view content in the selected layout
4. Passes user data and content to layout

#### New Methods:
```php
protected function render(string $view, array $data = [], ?string $layout = null)
protected function getCurrentUser(): ?array
```

The original `view()` method remains for backward compatibility.

## Controllers Updated

Updated the following controllers to use `render()` instead of `view()`:

1. **DashboardController** - Student dashboard now uses student layout
2. **FacilitatorController** (5 views) - All facilitator views use facilitator layout:
   - Dashboard
   - Create Course
   - Edit Course
   - Submissions
   - Review Submission
3. **CourseController** (11 views) - Course browsing uses role-appropriate layout:
   - All course category pages
   - Course detail page
   - Error pages
4. **CodeEditorController** (2 views) - Code editor uses student layout:
   - Editor index
   - Assignment editor
5. **FeedbackController** - Feedback view uses student layout
6. **ApplicationController** - Already using render() (admin layout auto-detected)
7. **PortfolioController** - Already using render() (student layout auto-detected)

## User Experience

### Student Portal
- **Color**: Blue (#3B82F6) accents
- **Focus**: Learning and progress tracking
- **Navigation**: Simple, education-oriented
- **Badges**: Red badge for pending assignments
- **Footer**: Links to About, Help, Privacy, Terms

### Facilitator Studio
- **Color**: Purple (#7C3AED to #6D28D9) gradient
- **Focus**: Teaching and content management
- **Navigation**: Course creation and student management
- **Badges**: 
  - Yellow for pending submissions
  - Green for unread messages
- **Footer**: Links to Help & Guides, Give Feedback, Support

### Admin Panel
- **Color**: Dark gray (#111827 to #1F2937) gradient
- **Focus**: Platform administration and management
- **Navigation**: Sectioned by function (Admissions, Users, Content, System)
- **Badges**: Yellow for pending applications
- **Header Stats**: Quick overview of total users and courses
- **Footer**: System version, Documentation, API, Support links

## Testing Instructions

### Test Student Portal
1. Login with: `abdulhafiz@nebatech.com` / `Password123!`
2. Verify blue theme appears
3. Check navigation items are learning-focused
4. Test dashboard, courses, assignments pages

### Test Facilitator Studio
1. Login with: `facilitator@nebatech.com` / `Password123!`
2. Verify purple gradient theme
3. Check "Create Course" button in header
4. Test course management pages
5. Verify badge counts for submissions

### Test Admin Panel
1. Login with: `admin@nebatech.com` / `Admin123!`
2. Verify dark theme appears
3. Check sectioned navigation (4 sections)
4. Test application management
5. Verify quick stats in header

## Technical Details

### Layout Structure
Each layout includes:
- Responsive sidebar with Alpine.js toggle
- Header with mobile menu button and user actions
- Main content area with flash messages
- Footer with role-appropriate links
- Profile dropdown menu
- Notification/badge system

### Responsive Design
- Desktop: Fixed sidebar on left
- Mobile: Overlay sidebar with backdrop
- Breakpoint: `md` (768px)
- Mobile menu: Hamburger button in header

### State Management
- Alpine.js for sidebar toggle
- PHP sessions for user data
- Flash messages for success/error notifications

### Badge System
- Student: Pending assignments (red)
- Facilitator: Pending submissions (yellow), unread messages (green)
- Admin: Pending applications (yellow)

## Benefits

1. **Role Clarity**: Each user immediately knows which portal they're in
2. **Feature Discovery**: Navigation tailored to role-specific features
3. **Visual Identity**: Distinct color schemes prevent confusion
4. **Workflow Optimization**: Quick access to most-used features per role
5. **Notification System**: Role-specific badges for pending items
6. **Responsive**: Works seamlessly on mobile and desktop
7. **Maintainability**: Centralized layout management

## Future Enhancements

- Add role-specific dashboard widgets
- Implement real-time badge count updates
- Add customizable sidebar preferences
- Create role-based notification preferences
- Add dark mode toggle per layout
- Implement sidebar collapse/expand preference saving

## User Credentials

For testing purposes:
- **Student**: abdulhafiz@nebatech.com / Password123!
- **Facilitator**: facilitator@nebatech.com / Password123!
- **Admin**: admin@nebatech.com / Admin123!

---

**Implementation Date**: December 2024
**Status**: ✅ Complete and Ready for Testing
