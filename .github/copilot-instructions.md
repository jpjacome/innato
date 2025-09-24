# Comprehensive AI Agent Instructions for Innato Laravel CMS Project

## CRITICAL OPERATIONAL DIRECTIVE

**ANALYSIS-ONLY MODE BY DEFAULT**: Unless the user explicitly requests implementation or file changes, ONLY provide analysis, suggestions, and recommendations. NEVER modify files, create new files, or implement changes without explicit user instruction.

## Project Overview

### Application Identity
- **Project Name**: Innato - Multi-purpose Laravel CMS
- **Framework**: Laravel 12.x (PHP 8.2+)
- **Primary Domain**: Content Management System with specialized modules
- **Architecture**: Monolithic MVC with role-based access control
- **Database**: SQLite (development), supports MySQL/PostgreSQL (production)

### Core Business Domains

#### 1. Tourism/Destinations Management
- **Purpose**: Comprehensive destination catalog for Ecuador tourism
- **Features**: Destination profiles, reservations, region management
- **Target**: Tourism operators, visitors, content editors

#### 2. Plant/Botanical Management  
- **Purpose**: Plant catalog with maintenance tracking
- **Features**: Plant profiles, image galleries, maintenance logs
- **Target**: Botanical gardens, plant enthusiasts, researchers

#### 3. Multi-tenant Content Management
- **Purpose**: Admin/Editor/Public content workflows
- **Features**: Role-based permissions, customizable themes, settings management
- **Target**: Content managers, site administrators

#### 4. El Patio Hostels (Specialized Landing)
- **Purpose**: Dedicated hostel booking and information portal
- **Features**: Custom branding, room management, reviews
- **Target**: Hostel guests, booking management

## Technical Architecture

### Framework Configuration
```
Laravel Version: 12.x
PHP Version: ^8.2
Database: SQLite (primary), MySQL/PostgreSQL (supported)
Authentication: Laravel Sanctum
Frontend: Blade templates with custom CSS/JS
Testing: PHPUnit
Development Tools: Laravel Telescope, Pulse, Tinker, Pint
```

### Key Dependencies
```json
{
  "production": [
    "laravel/framework": "^12.0",
    "laravel/sanctum": "^4.0", 
    "laravel/pulse": "^1.4"
  ],
  "development": [
    "laravel/telescope": "^5.7",
    "laravel/breeze": "^2.3",
    "laravel/sail": "^1.41"
  ]
}
```

## Database Schema Architecture

### Core User Management
```sql
-- users table
- id (bigint, PK)
- name (varchar 255)
- email (varchar 255, unique)
- password (varchar 255, hashed)
- role (enum: admin|editor|regular)
- is_admin (boolean)
- destination_id (FK to destinations, nullable)
- email_verified_at, remember_token, timestamps
```

### Tourism/Destinations System
```sql
-- destinations table (comprehensive tourism management schema)
CREATE TABLE destinations (
    -- Primary identification
    id (bigint, PK, auto-increment)
    slug (varchar 255, unique index) -- URL-friendly identifier
    title (varchar 255, NOT NULL) -- Destination name
    subtitle (varchar 255, nullable) -- Secondary description
    
    -- Geographic and conservation data
    coordinates (varchar 255, nullable) -- GPS coordinates
    conservation_status (varchar 255, nullable) -- Environmental status
    province (varchar 255, nullable) -- Ecuador province
    canton (varchar 255, nullable) -- Canton subdivision
    parish (varchar 255, nullable) -- Parish subdivision
    sector (varchar 255, nullable) -- Specific sector/area
    region (varchar 255, nullable) -- Tourism region (added later)
    reference_distance (varchar 255, nullable) -- Distance from reference point
    
    -- Climate information (JSON fields)
    climate_dry_season (JSON, nullable) -- Dry season details
    climate_wet_season (JSON, nullable) -- Wet season details
    
    -- Access and logistics
    access_from (varchar 255, nullable) -- Starting point for access
    access_route (varchar 255, nullable) -- Route description/condition
    access_transport (varchar 255, nullable) -- Transportation options
    access_time (varchar 255, nullable) -- Travel time required
    
    -- Operational details
    schedule_hours (varchar 255, nullable) -- Operating hours
    entry_fee (varchar 255, nullable) -- Cost information
    season_availability (varchar 255, nullable) -- Seasonal access
    requirements (varchar 255, nullable) -- Special requirements
    
    -- Contact information
    contact_person (varchar 255, nullable) -- Primary contact name
    contact_role (varchar 255, nullable) -- Contact's role/title
    contact_phone (varchar 255, nullable) -- Phone number
    contact_email (varchar 255, nullable) -- Email address
    
    -- Tourism features (JSON arrays with icons and names)
    activities (JSON, nullable) -- Available activities
    services (JSON, nullable) -- Available services with availability status
    
    -- Target audience segmentation
    target_audience_type (varchar 255, nullable) -- Tourist type
    target_audience_origin (varchar 255, nullable) -- Geographic origin
    target_audience_age (varchar 255, nullable) -- Age demographics
    target_audience_transport (varchar 255, nullable) -- Preferred transport
    target_audience_stay (varchar 255, nullable) -- Duration of stay
    
    -- Economic and capacity data
    average_price (varchar 255, nullable) -- Pricing information
    capacity (varchar 255, nullable) -- Maximum capacity
    payment_methods (varchar 255, nullable) -- Accepted payment types
    mobile_coverage (varchar 255, nullable) -- Mobile network availability
    
    -- Quality assessment
    tourism_criteria (JSON, nullable) -- Tourism quality criteria with status
    environmental_challenges (JSON, nullable) -- Environmental issues
    
    -- Content and media
    main_description (text, nullable) -- Primary description
    secondary_description (text, nullable) -- Additional description
    strengths_benefits (text, nullable) -- Key selling points
    gallery_images (JSON, nullable) -- Image gallery paths
    
    -- Management
    status (enum: 'active'|'inactive', default 'active') -- Visibility status
    created_at, updated_at (timestamps)
)

-- reservations table (tourism booking system)
CREATE TABLE reservations (
    id (bigint, PK)
    name (varchar 255, NOT NULL) -- Guest name
    email (varchar 255, NOT NULL) -- Guest email
    destination_id (bigint, FK to destinations.id, nullable) -- Booked destination
    people_count (integer, NOT NULL) -- Number of guests
    date (date, NOT NULL) -- Reservation date
    phone_number (varchar 255, NOT NULL) -- Contact phone
    created_at, updated_at (timestamps)
    
    -- Foreign key constraint
    FOREIGN KEY (destination_id) REFERENCES destinations(id) ON DELETE SET NULL
)

-- destinations_settings table (page configuration)
CREATE TABLE destinations_settings (
    id (bigint, PK)
    banner_title (varchar 255, nullable) -- Page banner title
    banner_description (text, nullable) -- Banner description
    banner_image (varchar 255, nullable) -- Banner image path
    headline_title (varchar 255, nullable) -- Section headline
    headline_cards (JSON, nullable) -- Feature cards data
    destinations_title (varchar 255, nullable) -- Destinations section title
    destinations_button_text (varchar 255, nullable) -- CTA button text
    created_at, updated_at (timestamps)
)
```

**Current Database Status:**
- **Active destinations**: 4 destinations currently in database
- **Sample destinations**: 
  - "TURISMO RURAL LIBERTADOR BOLÍVAR" (libertador-bolivar)
  - "SALINAS DE GUARANDA" (salinas-guaranda)
- **Geographic focus**: Ecuador tourism (provinces, cantons, parishes)
- **Unique constraint**: slug field ensures URL-friendly unique identifiers

### Plant Management System
```sql
-- plants table
- id (int, PK)
- name (varchar 255)
- common_names (text)
- family, native_range, age
- current_height, expected_height
- leaf_type, bloom_time, flower_color, fruit
- light, soil, hardiness
- other_comments (text)
- timestamps

-- plant_images table
- id (int, PK)
- plant_id (FK to plants)
- image_path (varchar 255)
- image_order (int)
- created_at

-- maintenance_logs table
- id (int, PK)
- plant_id (FK to plants)
- last_watering, next_watering (dates)
- last_fertilization, next_fertilization (dates) 
- last_pruning, next_pruning (dates)
- pest_disease_inspection (text)
- timestamps

-- maintenance_images table
- id, maintenance_log_id (FK)
- image_path, created_at
```

### Configuration & Settings Tables
```sql
-- dashboard_settings (singleton pattern)
- primary_color, secondary_color, accent_color
- dashboard_title, logo
- show_logo, background_color
- dark theme colors
- text_color

-- Multiple settings tables following singleton pattern:
- hero_settings (homepage hero section)
- home_settings (homepage content)
- about_settings (about page)
- contact_settings (contact information)
- header_settings (navigation)
- footer_settings (footer content)
- elpatio_settings (specialized landing)
- reviews_settings (review system config)
```

## Application Structure

### Model Architecture

#### Core Models with Relationships
```php
// User Model (App\Models\User)
- belongsTo: Role, Destination (assignedDestination)
- Methods: isAdmin(), isEditor(), isRegular(), canEditDestination()
- Role-based authorization logic

// Plant Model (App\Models\Plant)  
- hasMany: PlantImage, MaintenanceLog
- Fillable: botanical attributes, growing conditions
- Ordered relationships for images, maintenance

// Destination Model (App\Models\Destination)
- hasOne: User (assignedEditor relationship via destination_id)
- hasMany: Reservation (tourism booking system)
- JSON casts: activities, services, climate_dry_season, climate_wet_season, tourism_criteria, environmental_challenges, gallery_images
- Helper methods: getFormattedActivities(), getFormattedServices(), getFormattedCriteria(), getClimateSeasons()
- Comprehensive tourism metadata with Ecuador geographic structure (province, canton, parish, sector, region)
- Status management: active/inactive enum for content control
- Role-based editing: Admins can edit all, Editors can edit only assigned destinations
- Policy protection: DestinationPolicy controls update permissions

// Settings Models (Singleton Pattern)
- HomeSetting, AboutSetting, DashboardSettings, etc.
- Static method: instance() - returns first record or creates default
- JSON casts for complex data structures
```

### Controller Architecture

#### Admin Controllers (App\Http\Controllers\Admin\)
```php
AdminDestinationController - Full destination CRUD
PlantController - Plant management with image upload
MaintenanceLogController - Maintenance tracking
ReviewController - Review system management
ElPatioController - Specialized hostel management
```

#### Editor Controllers (App\Http\Controllers\Editor\)
```php
EditorDashboardController - Limited dashboard access
EditorDestinationController - Restricted destination editing
UserController - Self-profile management only
```

#### Public Controllers
```php
PagesController - Public content pages
PlantViewController - Public plant catalog
DestinationViewController - Public destination browsing
UserManagementController - User profile management
```

### View Architecture

#### Directory Structure
```
resources/views/
├── admin/ (admin interface)
│   ├── dashboard.blade.php
│   ├── plants/ (plant management)
│   ├── destinations/ (destination management)
│   └── users/ (user management)
├── editor/ (editor interface)
│   ├── dashboard.blade.php 
│   ├── destinations/ (limited editing)
│   └── users/ (self-management)
├── public/ (public-facing)
│   ├── plants/ (plant catalog)
│   └── destinations/ (destination browsing)
├── elpatio/ (specialized landing)
├── components/ (reusable Blade components)
├── layouts/ (base templates)
└── auth/ (authentication views)
```

### Middleware & Security

#### Custom Middleware
```php
AdminMiddleware - Restricts access to admin users only
EditorMiddleware - Allows admin OR editor access
Role-based route protection throughout application
```

#### Security Features
- CSRF protection on all forms
- Input validation on all user inputs  
- Eloquent ORM prevents SQL injection
- Role-based authorization using Laravel policies
- Password hashing with bcrypt
- Sanctum API authentication

## Route Architecture

### Route Groups by Access Level
```php
// Public Routes
Route::get('/', 'HomeController') // Homepage
Route::get('/plants', 'PlantViewController') // Public plant catalog
Route::get('/destinations', 'DestinationViewController') // Public destinations

// Authenticated Routes (all roles)
Route::middleware(['auth'])->group(...)

// Editor Routes (admin OR editor)
Route::middleware(['auth', EditorMiddleware::class])->group(...)

// Admin Routes (admin only)  
Route::middleware(['auth', AdminMiddleware::class])->group(...)

// Specialized Domain Routes
Route::domain('elpatiohostels.com')->group(...) // El Patio landing
```

### Key Route Patterns
- RESTful resource routes for CRUD operations
- Nested routes for related resources (plant/{id}/maintenance)
- API routes for AJAX operations
- Fallback routes for legacy URL support

## Development Patterns & Conventions

### Code Standards
```php
// Always use strict typing
declare(strict_types=1);

// Follow PSR-4 autoloading
namespace App\Http\Controllers\Admin;

// Use proper type hints
public function update(Request $request, Plant $plant): RedirectResponse

// Leverage Laravel features
- Eloquent ORM for database operations
- Request validation with custom rules
- Resource controllers for RESTful operations
- Service container for dependency injection
```

### Database Patterns
- **Singleton Pattern**: Settings models (HomeSetting::instance())
- **Polymorphic Relations**: Not extensively used, prefer explicit relationships
- **Soft Deletes**: Not implemented, uses hard deletes
- **Timestamps**: Enabled on most models
- **JSON Casting**: Used for complex data (activities, services)

### File Upload Patterns
- Storage in `public/storage` with symbolic links
- Image processing for plant galleries
- Validation for file types and sizes
- Cleanup on record deletion

## Testing Infrastructure

### Test Structure
```
tests/
├── Feature/ (HTTP integration tests)
│   ├── destination management
│   ├── plant management  
│   ├── user authentication
│   └── admin functionality
└── Unit/ (isolated component tests)
    ├── model relationships
    ├── business logic
    └── helper functions
```

### Testing Patterns
- RefreshDatabase trait for clean test environment
- Factory usage for model creation
- Feature tests for complete user workflows
- Unit tests for business logic
- Authentication testing with Sanctum

## Deployment & Configuration

### Environment Configuration
```php
// Key environment variables
APP_NAME=Innato
APP_ENV=production
APP_DEBUG=false
DB_CONNECTION=sqlite (dev) | mysql (prod)
MAIL_MAILER=smtp
TELESCOPE_ENABLED=false (production)
```

### Asset Management
- Vite for asset compilation
- CSS/JS in resources/assets/
- Public assets served from public/
- Image storage in storage/app/public/

## AI Agent Operational Guidelines

### Analysis Protocol
1. **Request Classification**: Determine intent (debugging, feature, optimization, etc.)
2. **Context Gathering**: Identify relevant models, controllers, views
3. **Relationship Mapping**: Understand data dependencies
4. **Security Assessment**: Check authorization and validation requirements
5. **Suggestion Formation**: Provide specific, actionable recommendations

### Response Framework
```
ANALYSIS ONLY (unless explicitly requested otherwise):
1. Identify the specific Laravel components involved
2. Reference relevant models, relationships, and migrations
3. Consider role-based access control implications  
4. Suggest implementation approach with code examples
5. Highlight potential security, performance, or architectural concerns
6. Provide testing recommendations
7. Suggest deployment considerations if applicable
```

### Code Suggestion Guidelines
- Always include proper type hints and return types
- Use Laravel's built-in features (validation, authorization, etc.)
- Follow the existing project patterns
- Consider the role-based access control system
- Include error handling and user feedback
- Suggest appropriate tests
- Consider performance implications

### Security Checklist for Suggestions
- [ ] Input validation implemented
- [ ] Authorization checks included  
- [ ] CSRF protection considered
- [ ] SQL injection prevention verified
- [ ] XSS prevention implemented
- [ ] File upload security addressed
- [ ] Role-based access enforced

## Common Development Scenarios

### Adding New Features
1. Create/modify models with proper relationships
2. Add validation rules and authorization policies
3. Implement controller logic with proper error handling
4. Create/update views with consistent styling
5. Add appropriate routes with middleware
6. Include comprehensive tests
7. Update documentation

### Debugging Issues
1. Check Laravel logs in storage/logs/
2. Use Telescope for request tracing (if enabled)
3. Verify database relationships and constraints
4. Check middleware and authorization logic
5. Validate input and output data flow
6. Review error handling and user feedback

### Performance Optimization
1. Identify N+1 query problems
2. Implement eager loading where appropriate
3. Add database indexes for frequently queried columns
4. Consider caching for settings and static data
5. Optimize image storage and serving
6. Review and optimize asset compilation

### Destinations Management Specific Scenarios

#### Adding New Destinations
1. **Admin Access Required**: Only admins can create new destinations via AdminDestinationController
2. **Required Fields**: title, slug (unique), status (active/inactive)
3. **Editor Assignment**: Consider assigning an editor via destination_id relationship
4. **Geographic Data**: Include province, canton, parish for Ecuador-specific categorization
5. **JSON Fields**: Populate activities, services, tourism_criteria arrays with proper structure
6. **Gallery Images**: Handle file uploads and JSON array storage for gallery_images

#### Editor-Destination Relationship Management
1. **One-to-One Assignment**: Each editor can be assigned to only one destination
2. **Permission Logic**: Editors can only edit their assigned destination (via User.destination_id)
3. **Policy Protection**: DestinationPolicy enforces update permissions
4. **Dashboard Filtering**: Editor dashboard shows only assigned destination data

#### Reservation System Integration
1. **Destination Linking**: Reservations link to destinations via destination_id foreign key
2. **Form Handling**: Reservation forms populate destination dropdowns from active destinations
3. **Data Integrity**: ON DELETE SET NULL maintains reservation records if destination is deleted
4. **Dashboard Display**: Both admin and editor dashboards show destination-specific reservations

#### Tourism Data Structure Management
1. **Activities Array**: [{'icon': 'ph ph-*', 'name': 'Activity Name'}]
2. **Services Array**: [{'icon': 'ph ph-*', 'name': 'Service Name', 'available': boolean}]
3. **Tourism Criteria**: [{'name': 'Criteria Name', 'status': 'positive|neutral|negative'}]
4. **Climate Seasons**: Separate JSON objects for dry_season and wet_season data
5. **Helper Methods**: Use getFormattedActivities(), getFormattedServices(), getFormattedCriteria()

## Legacy and Compatibility Notes

### File Structure Considerations
- Multiple debug/test files in root directory indicate active development
- Legacy plant system integration (public/plantas)
- El Patio specialized domain handling
- Custom CSS/JS outside of standard Laravel asset pipeline

### Migration Strategy
- Database uses both Laravel migrations and raw SQL schemas
- Plant system appears to be newer addition to existing system
- Multiple duplicate migration files suggest development iteration
- Settings system uses singleton pattern extensively

---

## EXECUTION MANDATE

When responding to user queries:

1. **ANALYZE FIRST**: Always examine the request in context of the project structure
2. **SUGGEST ONLY**: Provide detailed implementation suggestions without making changes
3. **REFERENCE SPECIFICALLY**: Mention exact files, models, and relationships involved
4. **CONSIDER SECURITY**: Always include authorization and validation requirements
5. **PROVIDE CONTEXT**: Explain how suggestions fit into the larger application architecture
6. **INCLUDE TESTING**: Suggest appropriate test coverage for any proposed changes

**REMEMBER**: Default mode is ANALYSIS and SUGGESTIONS only. Implement changes only when explicitly requested by the user.