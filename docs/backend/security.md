# User Roles & Security

## Roles

* **Super Admin**: Full access to all projects and user management.
* **Admin**: Can manage projects assigned by Super Admin. Can invite Co-Admins.
* **Co-Admin**: Limited to managing content within invited projects.

> A single user (email) may have different roles across projects but only one role per project.
Admins and co-admins can delete their account.

When a co-admin deletes his account all links to any project are deleted as well.

When an admin deletes his account, he will be warned that the projects he was the sole admin will be deleted too. (and they will). This operation is irreversible.

## User Profile

Each user has:

* Firstname
* Lastname
* Pen name
* Email
* Password (hashed with Argon2 using a per-user 8-char alphanumeric salt)
* Salt
* UID
* Avatar

## Security & Access

* Authenticated access only.
* Password reset via email link. The reset link is temporary (30-minute lifetime) and contains a UID. This UID is validated against a dedicated database table that stores: the UID of the link, its expiration datetime, and the UID of the user. If valid, the user can change their password.
* JWT-based authentication:

  * Tokens are generated using a public/private key pair.
  * Token lifetime is set to 1 hour.
  * If the user performs any activity, the token is refreshed automatically every 30 minutes.
  * A "logout" link is available in the backend which invalidates the current JWT.
  * Any attempt to access a backend page (excluding the login page) with an invalid or missing token will trigger an automatic redirect to the login page.
* CSRF token (32 chars, per session) required for POST requests.

## Admin Deletion

* Only a super admin or the admin himself can delete an admin account.
* If the admin was the sole admin of a project, a prompt is displayed to cascade delete or archive the project.
* Archived projects are only accessible to super admins.
* Super admins can restore or permanently delete archived projects.