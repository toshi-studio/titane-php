# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

**Note**: This is a living document that should be updated as the project evolves. Use the `/update-claude-md` slash command to update it based on the current conversation context.

## Repository Type

This repository contains the **Titane project** which has completed Phase 1 (Project Setup & Infrastructure) and is now ready for Phase 2 implementation. The project includes both documentation and a functional Symfony application foundation.

## Project Overview

Titane is a headless CMS and CRM hybrid designed for freelancers and designers. Key characteristics:
- Multi-role administration with project-based content management
- Form subscription system
- Structured API (JSON-based)
- No frontend by design - API delivers content for any frontend stack

## Technology Stack

The Titane application uses:
- **PHP 8.3**
- **Symfony 7.3.x** - Full-featured PHP framework (handles BOTH backend UI and API)
- **API Platform 3.3** - REST/GraphQL API generator (shares entities with admin)
- **Easy Admin Bundle 4.x** - Admin interface
- **MariaDB 11.4** - Database
- **Apache 2.x** - Web server
- **Docker** - Containerization
- **SCeditor 3.2.0** - WYSIWYG editor

**Architecture Note**: Symfony will serve both the admin backend UI and the API endpoints. This monolithic approach allows sharing of entities, repositories, and business logic between the admin interface and the API, ensuring consistency and reducing code duplication.

## Development Commands

The development workflow is:
```bash
git clone git@github.com:toshi-studio/titane-php.git
cd titane-php
make dev  # Starts Docker development environment
make shell  # Access PHP container shell
make db-shell  # Access MariaDB shell
```

Key development commands inside the container:
```bash
php bin/console cache:clear  # Clear Symfony cache
php bin/console debug:config # Check configuration
php bin/console about        # Show Symfony version info
```

## Architecture

### Core Entities

1. **Projects**: Act as separate websites with unique UIDs
   - Can be archived (read-only state)
   - Contains Pages, Articles, Forms, and Media

2. **Pages**: Static content with SEO support
   - Unique slugs per project
   - Version control with rollback
   - Draft/Published states
   - No tag support

3. **Articles**: Dynamic content items
   - Mandatory tags for categorization
   - Auto-generated summaries
   - Version control with rollback
   - Can be embedded in Pages

4. **Forms**: Subscription collection system
   - Field types: text, email, phone, checkbox, radio
   - Anti-spam protection (honeypot + XSS)
   - CSV export functionality

5. **Media Library**: Project-specific file storage
   - Supported: jpg, png, webp, doc, ppt, xls, pdf, zip
   - 2MB size limit
   - No editing/resizing features

### API Structure

All API responses will follow this format:
```json
{
  "success": true,
  "message": "string",
  "data": { ... }
}
```

Key endpoints:
- `GET /page` - Retrieve page HTML content
- `GET /article` - Retrieve article HTML content  
- `GET /form` - Get form structure
- `GET /form_html` - Get rendered form HTML
- `POST /form_submit` - Submit form data

Authentication: JWT tokens (1h lifetime) with automatic 30-minute refresh (to be implemented)

## Documentation Files

- `/README.md` - Project overview and setup
- `/docs/IMPLEMENTATION_PLAN.md` - Detailed phased implementation plan with baby steps
- `/docs/API/api_reference.md` - Complete API documentation
- `/docs/backend/crm_content_types.md` - Entity descriptions and features
- `/docs/backend/security.md` - User roles and security model
- `/docs/backend/wysiwyg_tools.md` - Editor configuration
- `/docs/backend/dashboard.md` - Admin dashboard features

## Coding Standards and Principles

When implementing code for this project, you MUST follow:

1. **Best Practices** for the specific language being used (PHP/Symfony conventions, PSR standards for PHP)
2. **SOLID Principles**:
   - Single Responsibility Principle (SRP)
   - Open/Closed Principle (OCP)
   - Liskov Substitution Principle (LSP)
   - Interface Segregation Principle (ISP)
   - Dependency Inversion Principle (DIP)
3. **DRY Principle** (Don't Repeat Yourself) - avoid code duplication
4. **Clean Code** practices - meaningful names, small functions, proper abstraction levels
5. **Documentation Requirements**:
   - Every class MUST have a descriptive comment explaining its purpose and responsibility
   - Every function/method MUST have documentation including:
     - Description of what the function does
     - Parameter descriptions with types
     - Return value description with type
     - Any exceptions that may be thrown
   - For PHP, use PHPDoc format (@param, @return, @throws)
   - Comments should explain "why" not "what" for complex logic

## Implementation Status

**Phase 1: COMPLETED ✅** (Project Setup & Infrastructure)
- Symfony 7.3.1 application initialized
- Docker development environment configured  
- Core bundles installed and configured:
  - API Platform 3.3 (JSON-only format)
  - EasyAdmin 4.x (with dashboard and security controllers)
  - JWT Authentication (1h token lifetime)
  - Doctrine Extensions (timestampable, sluggable)
  - CORS Bundle (for cross-origin API access)
- Security configuration completed
- Development workflow established

**Next Phase: Phase 2 - Core Entities & Database**
- User & Security entities with JWT authentication
- Project entity with UID generation
- Page, Article, Tag entities with version control
- Form & FormField entities with dynamic fields
- Media entity with file upload handling

## Current Working Directory Structure

```
titane-php/
├── titane/                    # Symfony application root
│   ├── src/
│   │   └── Controller/Admin/  # EasyAdmin controllers
│   ├── config/               # Symfony configuration
│   └── ...
├── docker/                   # Docker configuration
├── docs/                     # Project documentation
└── Makefile                  # Development commands
```

This is a solo developer project where PRs are welcome for documentation improvements, but major design decisions are handled by the maintainer.