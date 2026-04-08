Hello!
This project was made for SCU's MBA ISBA 2402 course "Fundamentals of SQL."
Project Requirements: Connect a SQL database to a website.
Project Specifications: Interactive “social media” site that allows users to sign up. Information about each user is stored in phpMyAdmin.
---
References: “My SQL Cookbook” – Paul DuBois; QuckProgramming’s YouTube Tutorials and support
SQL (MySQL), PHP, XAMPP, and HTML were used.
Frontend: HTML using Sublime Text 3
Middle end: PHP (phpMyAdmin), OOP
Backend: SQL
---
Skills:
Frontend:
•	Created the visuals of the website’s pages using HTML and CSS:
  o	Login
  o	Logout
  o	Profile
  o	Timeline

Middle End:
•	Connected SQL to PHP to an online interactive website
•	Allowed not only textual data to be stored in the local database, but also images 
•	SQL
  o	Table creation and population
  o	Primary and secondary keys
  o	Indices
  o	Query strings
•	All changes made in the website reflects in the database

Backend:
•	Created working links for the website’s pages
•	Allowed users to sign in with real emails and names:
  o	Used phpMyAdmin to create unique ids and generally generated user ids, connected to a user’s first name, last name, and email

Posts
o	Allowed each post on a user’s feed to have its own unique id
o	Connected each post to a user’s user id
o	Stored each post in the database
  •	myphpMyAdmin; MySQL:
o	Used indexes to allow certain people or content to be filtered and searched for
o	Indexed to allow php to search tables
  •	Allowed “comments” to populate their own table in the database
  •	Created error messages when:
o	Incorrect prompts were inputted in the submission fields
  •	Allows posts to be deleted based on unique post id

Profile
o	Clickable links in text and profile photo in the top corner
o	Allowed changes in profile pictures and cover photos
  	Allowed unique url to reflect in the url
o	Created a max mb cap for uploading profile pictures
o	Automatically resizes and crops non-square profile pictures to fit in a perfect circle border 
o	Used random name/number generators to generate unique names for each photo uploaded into a created user folder after uploading to avoid hypothetical users overwriting each other’s profile photos
  	Allows a copy “thumbnail” to be saved to the user’s folder for reference
o	Will add a post when profile photos are updated
o	Setting limits to owner of account only when editing or deleting post information

Friend’s pages
o	Using query strings to load different profiles than owner (me) via unique urls
  	Matched user id 

Likes
o	Likes: Posts, Profiles, and Comments
o	Connected likes to userid to prevent duplicate likes
o	Created new database table in phpMyAdmin to store like count per user
o	Used JSON to transer data from arrays to be able to see both outside and inside direct database
o	Like and unlike posts based on user id
o	Grammar “people liked” vs “person liked” vs “you liked and _ people liked”

Edit and Delete
o	Can only delete own post connected to your user id
o	Edit can change text and image posts and automatically refresh to the profile

Security
1.	SQL injection prevention via:
  a.	Variable escaping
  b.	Prepared statements
  c.	Html escaping
  d.	Input whitelisting/blacklisting 
2.	Password hashing
  a.	Limited login tries
3.	Security through obscurity
  a.	Limited error info
    i.	Hiding developer errors (display_errors) using XAMPP ini files
  b.	Private/public folders
  c.	index.php in all folders
  d.	Hiding developer errors
4.	Database protection
  a.	Encrypting user’s confidential information within the database even if database is hacked using formula algorithms
    i.	One-way encryption (not used to keep this project simple)
    ii.	Hashing algorithms (for user’s passwords)
1.	md5
2.	sha1
3.	hash()
  b.	Using created hashed password to compare to the hashed password stored in system
