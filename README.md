# Secure-App-Dev: Part 2

Create an authentication mechanism for a web application using XAMPP, PHP & MySQL. Your authentication mechanism should allow for the following functionality. 

### Setup
* Clone repository to Applications/XAMPP/xamppfiles/htdocs/c00193216
* Navigate to localhost/c00193216/setup.php
* Select 'Build Database' to create the MySQL db and User table

### Personally Identifiable Information Retention
No personally identifiable information regarding users should be stored in human readable form in the database.

### Register
A user will be required to intially register with the system using a chosen UserId, Password, Email Address and the date of birth. Once registered the user can authenticate.

### Lockout Mechanism
A lockout mechanism should be in place on the login page on 5 unsuccessfult authentication attempts within 5 minutes.

### Forgot Password
If the user cannot remeber their password they should have a 'Forgot Password' functinality to facilitate the end user reset of their password.

### Logging
The aplication should implememt logging to a text file for the following activities.
* Successful login attempts
* Unsuccessful login attempts
* Password resets
* Exceptions thrown against the database.
