# inactive project
This project was abandoned, but the code will remain for whoever wants to start there own clickme site. Please don't host an exact replica of WOWMeter though, this serves as a base.

This is sad. It was a good 3 years... 

# WOWMeter
WOWMeter is a click-my-signature website based off the Doge meme. It was started in 2014 by Erman Sayin, but abandoned a year later, picked up again by Preston Cammarata a few months later, and sadly closed after a few months, and now it's finally back for good, with a brand new backend.

Note: WOWMeter is not finished, and we accept contributions :) We will post coding guidelines in a file later.

# Setting up
(sorry that some files have 2 space tabs and others have 4 space tabs. used two editors while making this, i will eventually switch to 4 space tabs throughout every file soon)

wow.php is the configuration file that is included in every page, unless the header.php file is doing it for you.

Fill out a random string for the "$salt" variable in wow.php, make it something long, random and unique. This improves security, but make sure to never change it, or all hashed content will be forever lost.

More configuration is self explanatory in wow.php.

Create a database, run the file "db.sql" from the repo in the database in order to get the required tables, make sure you fill out database information in wow.php.

# Notes
When including main.php, type "$no_script = 1" beforehand, to make it not show any content besides the news.

When including the header, type "$login_required = 1" if you want a certain page to be only accessed by logged in members.

When you need to check if the user is logged in, use the boolean "$member_access" to find out.

An array of the logged in users table information is accessed through a variable called "$session_array".

There is a variable that returns the users username. This variable is "$username".

# Extra Scripts
WOWMeter also has server scripts for a few Linux distros that can enable you to update the site from a repo, use cron jobs to find bots, and other stuff, and more. These scripts are not available yet, but will be soon in the repo.

# License
View the LICENSE file for that!

# New Repo Changes
+ All hashed strings have converted from sha256 to sha512.
+ All PHP and some JS has been reworked for performance.
+ New fonts and images.
+ Better security, improved techniques for functions.
+ World Map
+ Custom Signature Backgrounds
+ Global Language Support
+ More...
