# Titane Implementation Plan

## Phase 1: Project Setup & Infrastructure
**Goal**: Establish development environment and basic Symfony structure

### Steps:
1. **Initialize Symfony project**
   - Create new Symfony 7.3 project with --webapp flag
   - Configure .env for database connection
   - Setup git repository structure

2. **Docker configuration**
   - Create Dockerfile for PHP 8.3 + Apache
   - Create docker-compose.yml with PHP, MariaDB, and phpMyAdmin services
   - Configure Apache for Symfony
   - Test container setup with "make dev" command

3. **Install core bundles**
   - API Platform 3.3
   - EasyAdmin 4.x
   - Doctrine extensions (timestampable, sluggable)
   - Security bundle configuration

4. **Basic configuration**
   - Configure security.yaml for JWT authentication
   - Setup API Platform with JSON format
   - Configure EasyAdmin basic layout
   - Create Makefile with common commands

## Phase 2: Core Entities & Database
**Goal**: Implement the data model with proper relationships

### Steps:
1. **User & Security entities**
   - Create User entity with roles (Super Admin, Admin, Editor, Viewer)
   - Implement JWT authentication
   - Create fixtures for initial users

2. **Project entity**
   - Fields: name, description, url, uid, archived status
   - Unique UID generation
   - Timestampable behavior

3. **Page entity**
   - All fields from documentation
   - Relationship to Project
   - Sluggable behavior
   - Version control setup (PageVersion entity)
   - Soft delete for trash functionality

4. **Article entity**
   - Similar to Page with required tags
   - ArticleVersion entity
   - Summary auto-generation logic

5. **Tag entity**
   - Hierarchical structure (parent/child)
   - Project-specific constraint

6. **Form & FormField entities**
   - Form structure with dynamic fields
   - Field ordering system
   - Subscription entity for form submissions

7. **Media entity**
   - File upload handling
   - Project relationship
   - File type validation

### Database migrations
- Generate and test all migrations
- Create sample data fixtures

## Phase 3: Admin Interface (EasyAdmin)
**Goal**: Build the complete backend administration UI

### Steps:
1. **Dashboard configuration**
   - Custom theme matching requirements
   - Menu structure by role
   - Project switcher implementation

2. **CRUD controllers**
   - ProjectCrudController with archive functionality
   - PageCrudController with version history
   - ArticleCrudController
   - FormCrudController with field builder
   - MediaCrudController with file upload
   - TagCrudController with hierarchy
   - SubscriptionCrudController with filters

3. **Advanced features**
   - Auto-save functionality for Page/Article editors
   - Version rollback interface
   - Trash/restore functionality
   - Bulk operations

4. **WYSIWYG Integration**
   - Integrate SCeditor 3.2.0
   - Custom toolbar configuration
   - Media library integration
   - Tag insertion for articles

## Phase 4: API Development
**Goal**: Implement all API endpoints with API Platform

### Steps:
1. **API Resources configuration**
   - Configure Page API resource (GET /page)
   - Configure Article API resource (GET /article)
   - Configure Form API resources (GET /form, /form_html, POST /form_submit)

2. **Custom operations**
   - HTML content transformation (PHPBB to HTML)
   - Form HTML rendering
   - Anti-spam implementation (honeypot + XSS)

3. **API security**
   - CORS configuration
   - Rate limiting
   - Gzip compression requirement
   - Response format standardization

4. **API documentation**
   - OpenAPI/Swagger setup
   - Custom response examples
   - Testing endpoints

## Phase 5: Business Logic & Services
**Goal**: Implement core business logic

### Steps:
1. **Version control system**
   - Version creation service
   - Diff visualization
   - Rollback mechanism

2. **Content services**
   - PHPBB to HTML converter
   - Summary auto-generation
   - Slug generation with uniqueness

3. **Form services**
   - Form HTML renderer
   - Submission validator
   - CSV export functionality
   - Anti-spam checker

4. **Media services**
   - File upload handler
   - Public URL generator
   - File type validator

## Phase 6: Testing & Quality
**Goal**: Ensure code quality and reliability

### Steps:
1. **Unit tests**
   - Entity tests
   - Service tests
   - Validator tests

2. **Functional tests**
   - API endpoint tests
   - Admin interface tests
   - Authentication flow tests

3. **Code quality**
   - PHPStan/Psalm setup
   - CS Fixer configuration
   - Pre-commit hooks

## Phase 7: Performance & Optimization
**Goal**: Optimize for production use

### Steps:
1. **Caching**
   - Implement Redis for JWT caching
   - API response caching
   - Query optimization

2. **Asset optimization**
   - Frontend asset compilation
   - Image optimization
   - Lazy loading implementation

3. **Database optimization**
   - Index optimization
   - Query analysis
   - N+1 query prevention

## Phase 8: Deployment Preparation
**Goal**: Prepare for production deployment

### Steps:
1. **Production configuration**
   - Environment-specific configs
   - Secrets management
   - Error handling/logging

2. **Documentation**
   - API documentation finalization
   - Deployment guide
   - Admin user guide

3. **CI/CD Setup**
   - GitHub Actions configuration
   - Automated testing
   - Build process

## Milestones & Timeline Estimate

- **Milestone 1** (Phase 1-2): Basic setup with entities - 1 week
- **Milestone 2** (Phase 3): Complete admin interface - 2 weeks  
- **Milestone 3** (Phase 4): API implementation - 1 week
- **Milestone 4** (Phase 5-6): Business logic & testing - 2 weeks
- **Milestone 5** (Phase 7-8): Optimization & deployment - 1 week

**Total estimated time**: 7 weeks for MVP

## Next Steps

1. Start with Phase 1, Step 1: Initialize Symfony project
2. Commit after each completed step
3. Update CLAUDE.md with discoveries and decisions
4. Test each phase before moving to the next