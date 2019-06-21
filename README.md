# Student-Success-Plan

The West Fork School District has created this PHP bundle for use in managing our Student Success Plans.

This code can be freely used and edited for your purposes.

It is intended that the contents of Mentor and the contens of Student will be on different domains.  While it is possible to do this another way, we felt it cleaner.

At present, the forgot password feature doesn't work.

Please note...  If you are going to use the Google Secure LDAP authentication option, you MUST setup stunnel on your network to act as a proxy between PHP's LDAP and G Suite.  These scripts assume you will be running stunnel on the same machine as you are hosting the SSP server.  More information can be found here. https://support.google.com/a/answer/9089736?hl=en

You will also need to include the client certificate and key files.  These instructions are also in the link above.

To start, you will need to import the empty database file "DBSetup.sql."  From your MySQL server, run the following command from the directory that contains this file:

mysql -u root -p < DBSetup.sql  

This assumes you are using the root user.  Then assign a user (the script assumes the user is named ssp) to the database.

Once the database is configured, edit the mysqli_connect.php files in the student and mentor copies to match.
