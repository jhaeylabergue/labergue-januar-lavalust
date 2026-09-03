# LavaLust Student Portal - Complete Documentation

## 1. Screenshot of the /student page

The `/student` page displays the student home portal with:
- Navigation bar with Home and Student Profile links
- Welcome message for the JL Student Portal
- Profile access status (granted with green badge)
- Student details in a card layout showing: Student ID, Name, Course, Year Level, Section, Email
- Link to view full profile

**URL**: `http://localhost:3000/student`

---

## 2. Screenshot of the /student/profile page

The `/student/profile` page displays detailed student information with:
- Large profile header with avatar and student name
- Academic information (course, year, section)
- Comprehensive student details card
- About Me section with bio
- Skills section listing technical skills
- Hobbies section
- Protected by StudentMiddleware badge

**URL**: `http://localhost:3000/student/profile`

---

## 3. Middleware-Protected Route

The `/student/profile` route is protected by the `StudentMiddleware`:

```php
$router->get('/student/profile', 'StudentController::profile')->middleware('student');
```

**How it works:**
- Users must have `student_access` session data set to true
- Without access, they're redirected to `/student`
- Access can be granted via `/student?grant=1` parameter
- The middleware checks the session and redirects if not authorized

---

## 4. Route Configuration

**File**: [app/config/routes.php](app/config/routes.php)

```php
<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/** @var object $router **/

$router->get('/', 'Welcome::index');

$router->get('/student', 'StudentController::index');
$router->get('/student/profile', 'StudentController::profile')->middleware('student');
```

**Routes:**
- `GET /` → Welcome controller (LavaLust homepage)
- `GET /student` → StudentController::index (unprotected student home page)
- `GET /student/profile` → StudentController::profile (protected with StudentMiddleware)

---

## 5. Controller Code

**File**: [app/controllers/StudentController.php](app/controllers/StudentController.php)

```php
<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentController extends Controller
{
    /**
     * Sample student data passed to views.
     */
    private function getStudentData(): array
    {
        return [
            'student_id' => '2024-00265',
            'name'       => 'Januar Labergue',
            'course'     => 'BS Information Technology',
            'year'       => '3rd Year',
            'section'    => 'F2',
            'email'      => 'januarlabergue@gmail.com',
            'phone'      => '+63 994 598 8592',
            'address'    => 'Puerto Galera,Oriental Mindoro, Philippines',
            'skills'     => ['PHP', 'JavaScript', 'MySQL', 'LavaLust MVC'],
            'hobbies'    => ['Coding', 'Gaming', 'Watching movies'],
            'bio'        => 'Web Systems student building practical apps with the LavaLust PHP framework.',
        ];
    }

    public function index()
    {
        $this->call->library('session');

        if (isset($_GET['grant']) && $_GET['grant'] === '1') {
            $this->session->set_userdata('student_access', true);
        }

        $data['student']    = $this->getStudentData();
        $data['page_title']   = 'Januar Labergue — Student Portal';
        $data['active_page']  = 'home';
        $data['has_access']   = (bool) $this->session->userdata('student_access');

        $this->call->view('student/home', $data);
    }

    public function profile()
    {
        $data['student']   = $this->getStudentData();
        $data['page_title'] = 'Student Profile — Januar Labergue';
        $data['active_page'] = 'profile';

        $this->call->view('student/profile', $data);
    }
}
```

**Key Features:**
- Private method `getStudentData()` returns student information
- `index()` handles the home page and session access grant
- `profile()` renders the detailed profile (protected by middleware)
- Session-based access control for profile page
- Query parameter `?grant=1` to grant profile access

---

## 6. Middleware Code

**File**: [app/middlewares/StudentMiddleware.php](app/middlewares/StudentMiddleware.php)

```php
<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentMiddleware
{
    public function handle(Closure $next)
    {
        $lava = lava_instance();
        $lava->call->library('session');
        $lava->call->helper('url');

        if (!$lava->session->userdata('student_access')) {
            redirect('student');
            return;
        }

        return $next();
    }
}
```

**How it works:**
1. Gets the LavaLust instance
2. Loads the Session library and URL helper
3. Checks if `student_access` session data is set
4. If not set, redirects to `/student` page
5. If set, allows the request to proceed to the controller

---

## 7. View Files

### Home Page View
**File**: [app/views/student/home.php](app/views/student/home.php)

```php
<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title ?? 'Student Portal') ?></title>
    <?php lava_instance()->call->view('student/_styles'); ?>
</head>
<body>

<?php lava_instance()->call->view('student/_nav', ['active_page' => $active_page ?? 'home']); ?>

<div class="page-wrap">
    <h1 class="page-title">Student Information</h1>
    <p class="page-subtitle">Welcome to the JL Student Portal — Web Systems &amp; Technologies Lab 3</p>

    <?php if (empty($has_access)): ?>
    <div class="alert alert-info">
        Profile access is protected by <strong>StudentMiddleware</strong>.
        <a href="<?= site_url('student?grant=1') ?>" class="btn btn-primary" style="margin-left: 1rem;">Grant Profile Access</a>
    </div>
    <?php else: ?>
    <p style="margin-bottom: 1.5rem;">
        <span class="badge badge-success">Profile access granted</span>
    </p>
    <?php endif; ?>

    <div class="card">
        <h2>Student Details</h2>
        <div class="info-grid">
            <div class="info-item">
                <label>Student ID</label>
                <span><?= htmlspecialchars($student['student_id']) ?></span>
            </div>
            <!-- Additional fields... -->
        </div>
    </div>

    <p>
        <a href="<?= site_url('student/profile') ?>" class="btn btn-primary">View Full Profile →</a>
    </p>
</div>

</body>
</html>
```

### Profile Page View
**File**: [app/views/student/profile.php](app/views/student/profile.php)

```php
<?php
/**
 * @var array  $student
 * @var string $page_title
 * @var string $active_page
 * @var bool   $has_access
 */

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); ?>   
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title ?? 'Student Profile') ?></title>
    <?php lava_instance()->call->view('student/_styles'); ?>
</head>
<body>

<?php lava_instance()->call->view('student/_nav', ['active_page' => $active_page ?? 'profile']); ?>

<div class="page-wrap">
    <div class="profile-header">
        <div class="avatar"><?= strtoupper(substr($student['name'], 0, 1)) ?></div>
        <div>
            <h1 class="page-title"><?= htmlspecialchars($student['name']) ?></h1>
            <p class="page-subtitle" style="margin-bottom: 0;">
                <?= htmlspecialchars($student['course']) ?> · <?= htmlspecialchars($student['year']) ?> · Section <?= htmlspecialchars($student['section']) ?>
            </p>
        </div>
    </div>

    <div class="card">
        <h2>Student Information</h2>
        <div class="info-grid">
            <!-- Student details... -->
        </div>
    </div>

    <div class="card">
        <h2>About Me</h2>
        <p class="bio-text"><?= htmlspecialchars($student['bio']) ?></p>
    </div>

    <div class="card">
        <h2>Skills</h2>
        <ul class="tag-list">
            <?php foreach ($student['skills'] as $skill): ?>
            <li><?= htmlspecialchars($skill) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="card">
        <h2>Hobbies</h2>
        <ul class="tag-list">
            <?php foreach ($student['hobbies'] as $hobby): ?>
            <li><?= htmlspecialchars($hobby) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <p>
        <span class="badge badge-success">Protected by StudentMiddleware</span>
    </p>
</div>

</body>
</html>
```

### Navigation Partial
**File**: [app/views/student/_nav.php](app/views/student/_nav.php)

```php
<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); ?>
<nav class="student-nav">
    <div class="nav-brand">JL Student Portal</div>
    <div class="nav-links">
        <a href="<?= site_url('student') ?>" class="<?= ($active_page ?? '') === 'home' ? 'active' : '' ?>">Home</a>
        <span class="nav-sep">|</span>
        <a href="<?= site_url('student/profile') ?>" class="<?= ($active_page ?? '') === 'profile' ? 'active' : '' ?>">Student Profile</a>
    </div>
</nav>
```

### Styles Partial
**File**: [app/views/student/_styles.php](app/views/student/_styles.php)

Contains all CSS styling for:
- Dark theme with blue accents
- Navigation bar styling
- Card layouts
- Info grid display
- Badge and button styles
- Profile header with avatar
- Tag lists for skills and hobbies

---

## 8. Deployment & Render Link

### Local Development
**Current URL**: `http://localhost:3000/`

### Deployment to Render

To deploy this LavaLust application to Render.com:

1. **Create a Render account** at [render.com](https://render.com)

2. **Connect your GitHub repository** containing this code

3. **Create a Web Service** with these settings:
   - **Build Command**: `composer install` (if using Composer)
   - **Start Command**: `php -S 0.0.0.0:$PORT public/index.php`
   - **Environment Variables**:
     - `APP_ENV=production`
     - `BASE_URL=https://your-app-name.onrender.com/`

4. **Configure .htaccess** for Render (if using Apache):
   - Ensure `.htaccess` files are present in `/public` and root directories
   - The routing redirects all requests to `public/index.php`

5. **Set up database** (if needed):
   - Create a PostgreSQL or MySQL service on Render
   - Update database configuration in `app/config/database.php`

### GitHub Repository Link
Store this project on GitHub for easy deployment:
- Create a repository on [github.com](https://github.com)
- Push this code to the repository
- Connect the repository to Render for continuous deployment

**Example Render URL** (after deployment):
```
https://lavalust-student-portal.onrender.com/
```

---

## Key Features Summary

✅ **Clean URL Routing**: No `/index.php/` in URLs  
✅ **Middleware Protection**: Secure routes with StudentMiddleware  
✅ **Session Management**: Access control using PHP sessions  
✅ **Responsive Design**: Dark theme with modern UI  
✅ **Modular Views**: Reusable view components (_nav, _styles)  
✅ **Security**: HTML escaping with `htmlspecialchars()`  
✅ **MVC Architecture**: Proper separation of concerns  

---

## Testing

### Test Routes
- `/` → Homepage (LavaLust welcome page)
- `/student` → Student portal home page
- `/student?grant=1` → Grant profile access via query parameter
- `/student/profile` → Detailed profile (protected, requires grant)

### Test Middleware
1. Try accessing `/student/profile` directly → Should redirect to `/student`
2. Click "Grant Profile Access" → Session is set
3. Navigate to `/student/profile` → Should now be accessible

---

