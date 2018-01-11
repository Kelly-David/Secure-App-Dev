# Secure-App-Dev

Create an authentication mechanism for a web application using XAMPP, PHP & MySQL. Your authentication mechanism should allow for the following functionality. 

### Setup
* Clone repository to Applications/XAMPP/xamppfiles/htdocs/c00193216
* Navigate to localhost/c00193216/setup.php
* Select 'Build Database' to create the MySQL db and User table

### Register with the system.
* The system should allow users to register with the system using a username and password.
* Complexity rules regarding the password should be enforced.

### On an unsuccessful authentication attempt
* A generic error message is presented back to the end user outlining that the username (BOB) & password combination cannot be authenticated at the moment. 
* Reflect the supplied username provided in the above message. Ensure that this reflected parameter in not susceptible to XSS. 
* Lockout after 3 attempts for 5 minutes.

### On successful authentication 
* The system should greet the user by their username.
* Create an active session.
* Allow for the authenticated user to view some pages (at least two) that an unauthenticated user will not have access to.
* Allow for the user to logout securely. 

### Password Change
* Authenticated users should be capable of changing their password.
* Complexity rules regarding the password should be enforced.
* On password change the active session should be expired.
* The user will have to re-authenticate using new credentials to gain access to the system.
* No out of band communication mechanism is required to inform the user that their credentials has been updated. 
