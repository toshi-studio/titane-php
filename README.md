# Titane

![MIT Licence](https://img.shields.io/badge/license-MIT-blue)
![Build](https://img.shields.io/github/actions/workflow/status/toshi-studio/titane/ci.yml)


## Overview

**Titane** is a headless CMS and CRM hybrid oriented toward freelancers and designers. It supports multi-role administration, project-based content management, form subscriptions, and a structured API.

**Titane** does not come with a frontend by design. Its structured API will deliver the content that will be integrated at any time, in any frontend stack, with full content fidelity.

## Backend features 

* [User Roles & Security](docs/backend/security.md)
* [Managed entities](docs/backend/crm_content_types.md)
* [WYSIWYG tools](docs/backend/wysiwyg_tools.md)

## API Reference
See [API Reference](docs/API/api_reference.md)


### Technical Stack
#### Versions
- **PHP 8.3** – Enables modern syntax and performance.
- **Apache 2.x** – Stable, widely supported HTTP server.
- **MariaDB 10.6** – Open-source relational DB with transactional support.
- **Symfony 7.1.x** – Full-featured PHP framework for scalable, secure APIs.
- **API Platform 3.3** – Declarative REST/GraphQL API generator with OpenAPI support.
- **Easy Admin Bundle 4.x** - Symfony recipe to build the admin
- **SCeditor 3.2.0** - lightweight and configurable WYSIWYG editor

### Development Environment
- **Docker**: Used to containerize all services (PHP-FPM, Apache, MariaDB).

## Getting Started
```bash
git clone git@github.com:toshi-studio/titane-php.git
cd titane
make dev  # or docker compose up --build
```

## Contributing
This is a solo developer project. PRs are welcome for bugfixes or documentation, but major features will be handled directly by the maintainer.


## License

This project is licensed under the [MIT License](LICENCE.md).

