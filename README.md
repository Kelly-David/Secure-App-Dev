# Secure-App-Dev

Create an authentication mechanism for a web application using XAMPP, PHP & MySQL. Your authentication mechanism should allow for the following functionality. 

### Register with the system.
o	The system should allow users to register with the system using a username and password.
o	Complexity rules regarding the password should be enforced.

### On an unsuccessful authentication attempt
o	A generic error message is presented back to the end user outlining that the username (BOB) & password combination cannot be authenticated at the moment. 
o	Reflect the supplied username provided in the above message. Ensure that this reflected parameter in not susceptible to XSS. 
o	Lockout after 3 attempts for 5 minutes.

### On successful authentication 
o	The system should greet the user by their username.
o	Create an active session.
o	Allow for the authenticated user to view some pages (at least two) that an unauthenticated user will not have access to. 
o	Allow for the user to logout securely. 

### Password Change
o	Authenticated users should be capable of changing their password.
o	Complexity rules regarding the password should be enforced.
o	On password change the active session should be expired.
o	The user will have to re-authenticate using new credentials to gain access to the system.
o	No out of band communication mechanism is required to inform the user that their credentials has been updated. 
