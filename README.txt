INSTRUCTIONS
------------------------------------------------------------
1. To install this plugin, Login as an administrator, go to 
		Site Administration->Plugins->Install Addon
   Choose the plugin type as "Authentication method (auth)" and upload the zip
2. Once the installation is complete, Go to Site Administration->Plugins->Authentication->elcentra
3. You can choose whether you want to use the buttons that the plugin adds automatically or place them manually in your theme file. 
  3.1.  If automatic mode is selected, the plugin automatically plugs in the buttons to the end of the login form in login page. You can override this default behaviour by adding an element (possibly a div) with 'auth_custom_location' class. 
  3.2.  If you select manual method, copy the code shown in your administration page and paste it wherever you want it to appear in your theme file
4. Follow the instructions shown in the configuration page. You need to create an application in each of the 4 social sites & fill in the required fields in the moodle elcentra configuration form. All fields are required & hence you will have to fill each of the field. You will get the details prompted in this form (e.g. client id, client secret, etc.) from the social network when you create an application using the corresponding URL.
5. Once this step is complete, you are done with the installation.

Changelog
------------------------------------------------------------

v1.1 (Build 2014043000)
*******
1. Inclusion of VK as additional login method.


v1.02  (Build 2013112200)
*******
1. Code clean up
2. Update on instructions for installation


v 1.01 (Build 2013102800)
******
1. Automatically finds and adds the login buttons though the user can disable this and add the button at any other convenient location
2. File encodings of all files are changed to UTF-8
3. More improvements

