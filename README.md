**** DARWIN_GAME_POO-Applicatif ****
POO Applicatif with Animal-Object.


**** register_PHP_Applicatif ****
Create a registration form that saves a new user in a database. You will create a page inscription.php that will display a registration form with the following input fields:
-A field of type "text" with attribute "name" with value "name" 
-A field of type "text" with attribute "name" with value "email" 
-A field of type "password" with attribute "name" with value "password"
-A field of type "password" with attribute "name" with value "password_confirmation"
-The name must contain between 3 and 10 characters. It must be saved in the database in the field "name". In case of error, you will need to display "Invalid name" on top of the form.
-The email must be valid. It must be saved in the database in the field "email". To check that the email is valid, learn about Regular Expressions. In case of error, you will display "Invalid email" on top of the form.
-The password must match its confirmation, must contain 3 to 10 characters, and must be hashed with the PHP function password_hash. This hash must be saved in the database in the field 
"password". In case of error, you will display on top of the form "Invalid password or password confirmation".
The creation date of the new user must be saved in the database in the field "created_at".
If the user creation succeeds, you will display the form again preceded by the message "User created".


**** login_PHP_Applicatif ****
Create a new page set_color.php that displays a form containing a field of type "text" with attribute "name" with value "background". You will also add a button to validate the form, containing the text "Submit". When the form is submitted, you will check the validity of the value entered (the value can be "white", "black", "red" or "blue").
If  the  value  is  valid,  you  will  bring  the  user,  via  a  302  redirection,  to  the  page  show_color.php  that you will create. You will also save the entered value in a cookie named "background_color".
If the value is not valid, you will display the form again preceded with the message "Invalid color". In that case, you will need to make sure there is no more existing cookie named "background_color". The page show_color.php has the following behavior:
-If there is not an existing cookie named "background_color" or if its value is invalid, you will redirect the user to the page set_color.php with a 302 redirection.
-If  a  cookie   named  "background_color"  exists  and  its  value   is  valid,  you  will  apply   a background color  on  the  element  <body>  of  the  page,  corresponding  to  the  value  saved  in the cookie.
