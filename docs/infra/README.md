## Infrastructure Overview

The project architecture is fully containerized using Docker. All services are orchestrated using `docker-compose` to streamline setup, consistency, and portability across environments.

---

## Architecture Summary

| Service      | Container Name   | Container Role    | Key Mounts                                        | Notes                                      |
| ------------ | ---------------- | ----------------- | ------------------------------------------------- | ------------------------------------------ |
| PHP Runtime  | ttn-php          | PHP-FPM 8.3       | `docker/php/PHP.ini`, `titane/`                   | Exposes FPM on port 9000                   |
| Apache       | ttn-apache       | Web Server (2.x)  | `titane/`, `docker/apache/`, `docker/apache/ssl/` | Proxies PHP requests to FPM                |
| MariaDB      | ttn-mariadb      | Database 11.4.7   | `docker/mariadb/my.cnf`, `docker/mariadb/data/`   | Custom config and persisted data directory |
| phpMyAdmin   | ttn-phpmyadmin   | DB Management     | -                                                 | Web UI on port 8080                        |
| Mailcatcher  | ttn-mailcatcher  | Email Testing     | -                                                 | SMTP on 1025, Web UI on 1080              |

**Docker Compose Configuration:**
- Project name: `titane`
- Service naming convention: `ttn-` prefix for all containers

---

## Shared Volumes & Network

To ensure consistency between containers and enable proper routing:

### Volumes

* The `titane/` source directory is mounted into both the Apache and PHP-FPM containers to serve the same codebase.
* Apache uses this mount to serve static assets and handle `.htaccess` rules.
* PHP-FPM uses it to interpret and execute PHP files.

### Network

* All containers operate on a custom Docker network defined in `docker-compose.yml`.
* The Apache container forwards `.php` requests to the PHP container using FastCGI (`ttn-php:9000`), where `ttn-php` is the container name/service alias.

---

## Apache with HTTPS and PHP-FPM

Apache is configured to support HTTPS using self-signed certificates for development purposes.

**SSL Setup**:

1. Create certificates in `docker/apache/ssl/`:

   ```bash
   mkdir -p docker/apache/ssl
   openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
     -keyout docker/apache/ssl/selfsigned.key \
     -out docker/apache/ssl/selfsigned.crt \
     -subj "/CN=localhost"
   ```

2. Mount `docker/apache/ssl/` into the Apache container at `/etc/apache2/ssl/`

3. Apache configuration must include:

```apache
<FilesMatch ".+\.php$">
    SetHandler "proxy:fcgi://ttn-php:9000"
</FilesMatch>
```

---

## Mailcatcher for Development

Mailcatcher is included in the development stack to intercept and display emails sent by the application without actually sending them. This is essential for testing form submissions and notifications.

**Configuration**:
- SMTP Server: `ttn-mailcatcher` (container name)
- SMTP Port: `1025`
- Web Interface: `http://localhost:1080`

**Symfony Configuration** (in `titane/.env.local`):
```
MAILER_DSN=smtp://ttn-mailcatcher:1025
```

**Usage**:
1. The application sends emails to Mailcatcher's SMTP server on port 1025
2. Access the web interface at `http://localhost:1080` to view caught emails
3. All emails are stored in memory and cleared when the container restarts

**Benefits**:
- Prevents accidental email sends to real addresses during development
- Allows inspection of email content, headers, and HTML rendering
- No configuration needed - works out of the box

---

## Recommendations

* **Dockerfile Separation**: Each service should use a dedicated Dockerfile or multi-stage build.
* **Named Volumes**: Prefer `docker volumes` over path-based mounts for production data.
* **Security**: Avoid hardcoded secrets. Use `.env` files and Docker secrets.
* **Reverse Proxy**: For production, consider moving SSL termination to a reverse proxy like Nginx or Traefik.
* **Modularity**: Keep `docker-compose.override.yml` for local customizations like port bindings or log mounts.

Let me know if you'd like the updated `docker-compose.yml` and Dockerfiles reflecting this structure.
