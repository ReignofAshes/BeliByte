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
1. Created the visuals of the website’s pages using HTML and CSS:
  a. Login
  b. Logout
  c. Profile
  d. Timeline

Middle End:
2. Connected SQL to PHP to an online interactive website
3. Allowed not only textual data to be stored in the local database, but also images 
4. SQL
  a. Table creation and population
  b. Primary and secondary keys
  c. Indices
  d. Query strings
5. All changes made in the website reflects in the database

Backend:
6. Created working links for the website’s pages
7. Allowed users to sign in with real emails and names:
  a. Used phpMyAdmin to create unique ids and generally generated user ids, connected to a user’s first name, last name, and email

Posts
8. Allowed each post on a user’s feed to have its own unique id
9. Connected each post to a user’s user id
10. Stored each post in the database
  a. myphpMyAdmin; MySQL:
11. Used indexes to allow certain people or content to be filtered and searched for
12. Indexed to allow php to search tables
  a. Allowed “comments” to populate their own table in the database
  b. Created error messages when:
13. Incorrect prompts were inputted in the submission fields
  a. Allows posts to be deleted based on unique post id

Profile
14. Clickable links in text and profile photo in the top corner
15. Allowed changes in profile pictures and cover photos
  a. Allowed unique url to reflect in the url
16. Created a max mb cap for uploading profile pictures
17. Automatically resizes and crops non-square profile pictures to fit in a perfect circle border 
18. Used random name/number generators to generate unique names for each photo uploaded into a created user folder after uploading to avoid hypothetical users overwriting each other’s profile photos
  a. Allows a copy “thumbnail” to be saved to the user’s folder for reference
19. Will add a post when profile photos are updated
20. Setting limits to owner of account only when editing or deleting post information

Friend’s pages
21. Using query strings to load different profiles than owner (me) via unique urls
  a. Matched user id 

Likes
22. Likes: Posts, Profiles, and Comments
23. Connected likes to userid to prevent duplicate likes
24. Created new database table in phpMyAdmin to store like count per user
25. Used JSON to transer data from arrays to be able to see both outside and inside direct database
26. Like and unlike posts based on user id
27. Grammar “people liked” vs “person liked” vs “you liked and _ people liked”

Edit and Delete
28. Can only delete own post connected to your user id
29. Edit can change text and image posts and automatically refresh to the profile

Security
30.	SQL injection prevention via:
  a.	Variable escaping
  b.	Prepared statements
  c.	Html escaping
  d.	Input whitelisting/blacklisting 
31.	Password hashing
  a.	Limited login tries
32.	Security through obscurity
  a.	Limited error info
    i.	Hiding developer errors (display_errors) using XAMPP ini files
  b.	Private/public folders
  c.	index.php in all folders
  d.	Hiding developer errors
33.	Database protection
  a.	Encrypting user’s confidential information within the database even if database is hacked using formula algorithms
    i.	One-way encryption (not used to keep this project simple)
    ii.	Hashing algorithms (for user’s passwords)
34.	md5
35.	sha1
36.	hash()
  b.	Using created hashed password to compare to the hashed password stored in system
