# API Reference

All requests use JSON. Gzip compression required.

## Auth

* JWT (1h lifetime), generated using a public/private key pair
* Automatically refreshed every 30 minutes on user activity
* A "logout" link in the backend invalidates the current JWT
* Any backend page (except login) accessed with an invalid token redirects to login
* CSRF token for POST

## Response Format

All responses follow the same structure:

```json
{
  "success": true,
  "message": "string",
  "data": { ... }
}
```

## Endpoints

### GET `/page`

Returns the HTML content of a page (all PHPBB tags are translated).

**Params**: `project_uid`, `page_slug`

**Returns:** as above

**Data content**:

```json
{
    "html": "HTML"
}
```

### GET `/article`

Returns the HTML content of an article (all PHPBB tags are translated).

**Params**: `project_uid`, `article_slug`

**Returns:** as above

**Data content**:

```json
{
    "html": "HTML"
}
```

### GET `/form`

Returns the structure of a form. The fields are sorted by their `order` value.

> The honeypot field is provided by the system for anti-spam protection.

**Params**: `project_uid`, `form_slug`

**Returns:** as above

**Data content**:

```json
{
    "slug": "string",
    "title": "string",
    "text": "string",  
    "image": "string",
    "xss": "string",
    "honeypot": "string",
    "fields": {
        "honeypot": {
            "name": "string",
            "type": "honeypot"
        },
        "field0": {
            "id": "string",
            "name": "string",
            "label": "string",
            "type": "text|email|phone|checkbox|radio",
            "default_value": "string"
        },
        "field1": {
            "id": "string",
            "name": "string",
            "label": "string",
            "type": "text|email|phone|checkbox|radio",
            "default_value": "string"
        }
    }
}
```

### GET `/form_html`

Returns the form in its HTML version.

> The `html` field will contain the form's rendered HTML, including the XSS protection input and honeypot field for anti-spam purposes.

**Params**: `project_uid`, `form_slug`

**Returns:** as above

**Data content**:

```json
{
    "slug": "string",
    "title": "string", 
    "text": "string",  
    "image": "string",
    "html": "HTML"
}
```

### POST `/form_submit`

Saves a subscription. The `xss` field is passed as part of the `fields` object.

```json
{
  "project_uid": "string",
  "form_slug": "string",
  "fields": {
    "field_name": "value",
    "xss": "value"
  }
}
```

**Returns:**

```json
{
  "success": true,
  "message": "Form submitted successfully"
}
```