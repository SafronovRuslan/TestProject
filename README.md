PHP 8.2
Mariadb 11.2

Project Description
Registration Page:
The main page displays a registration form with the following fields: Username, Phone Number, and a Register button. After the user fills in the fields and clicks Register, the following process occurs:

The user receives a generated unique link to a special page (Page A).
Access to this page is granted via the unique link for 7 days. After the expiration of this period, the link becomes inactive.
Page A Functionality:
On Page A, the user has access to the following features:

✔ Ability to generate a new unique link.
✔ Ability to deactivate the current unique link.
✔ Imfeelinglucky button.
✔ History button.
Upon clicking the Imfeelinglucky button, the user is presented with the following:

✔ A random number between 1 and 1000.

✔ The result: Win or Lose. The winning amount is displayed (0 if the result is Lose).

✔ If the random number is even, the result is "Win". Otherwise, the result is "Lose".

Win Amount Calculation:

✔ If the random number is greater than 900, the winning amount should be 70% of the random number.
✔ If the random number is greater than 600, the winning amount should be 50% of the random number.
✔ If the random number is greater than 300, the winning amount should be 30% of the random number.
✔ If the random number is 300 or less, the winning amount should be 10% of the random number.
✔ Upon clicking the History button, the user can view information about the last 3 results from clicking the Imfeelinglucky button.
