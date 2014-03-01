reslift
=======

Killer Resumes Made Easy

{c}0dEd Project to simplify online and PDF resume submission, including interactive project clips.

index.html:
This is our main file where a user is prompted to login with Facebook. After logging in, some information is imported into the user's resume, and the user can flip through and edit their magazine-like resume by selecting text, dragging skill bars or clicking photos. Each edit is automatically saved and can be reverted.

missing.html:
Our httpd.conf file specifies that non-existant pages should redirect to missing.html. The missing.html file determines if there is a facebook ID contained in the non existant URL. If so, the the missing.html page renders that user's ResLift resume. (e.g. http://reslift.com/204701571 is actually missing.html and /204701571 is not a directory. If a Facebook user identifier is not found, then the user is redirected to index.html or a 404 page.

JS:
All JS libs are stored here. Including a SWF file for click-to-copy-text-to-clipboard functionality.

CSS:
All CSS files are stored here.

IMAGES:
Most images are stored here.

CLOUD:
Our PHP files are stored here for saving, retrieving and updating user activity. Our main table in the reslift database is userEdits, where all user edits are stored.




