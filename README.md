# Moodle plugin tool_userbulkdelete

This is a Moodle admin/tool plugin that performs the Bulk Deletion of a big amount of users using asynchronous scheduled 
tasks to avoid any browser's timeout errors.

## Pre-requisites: 

* Having access to the server's shell is mandatory.
* For this plugin to work properly, it is better to have the cron process well configured on the server, although the 
asynchronous tasks processing might be launched by running:
 
    * ```sudo php ./admin/cli/cron.php``` to run all the cron tasks.
    * or ```sudo php ./admin/tool/task/cli/adhoc_task.php  --execute``` for a specific adhoc task processing.
      

## Installation:

Since this plugin relies on another one (block_userbulkdelete) that sets up a block on the http://yourmoodlesite.ch/admin/user/user_bulk.php page, 
it is mandatory to create a symbolic link in order to install the related block plugin, this step will be detailed in the
following installation procedures.

You can choose any of the following methods. As a convention all the commands are written as executed from the root directory of your Moodle installation.
 
### Method 1: Using GIT 

   * Go to the Moodle's installation root folder.
   * Clone the plugin's repo: ```git clone https://github.com/liip-elearning/userbulkdelete.git ./admin/tool/userbulkdelete```
   * Run the following command: ```ln -s ../admin/tool/userbulkdelete/block_userbulkdelete blocks/userbulkdelete```
   * Go to your website's administration section (e.g: http://yourmoodlesite.ch/admin).
   * Being all the installation requirements fulfilled, just click on the **"Upgrade Moodle database now"** button.
   * You will receive the installation success message and that's it for the installation procedure.
        
### Method 2: Uncompressing the Zip file 
 
   * Go to the Moodle's installation root folder.
   * Unzip the plugin file into the moodle's directory *./admin/tool/*
   * Run the following command on the shell: ```ln -s ../admin/tool/userbulkdelete/block_userbulkdelete blocks/userbulkdelete```
   * Go to your website's administration section (e.g: http://yourmoodlesite.ch/admin).
   * Being all the installation requirements fulfilled, just click on the **"Upgrade Moodle database now"** button.
   * You will receive the installation success message and that's it for the installation procedure.
    
### Method 3: Using the plugins interface on the Moodle's admin page (web)
    
   * Go to your website's plugin administration section: (e.g: http://yourmoodlesite.ch/admin/tool/installaddon/index.php).
   * Upload the zip file.
   * Click on the **"Install plugin from the ZIP file"** button.
   * Moodle will verify if the plugin can be installed, at this point if you get an error of access permission, run: 
   ```chmod -R 777 ./admin/tool``` and retry the ZIP uploading.
   * After the verifications click on the **"Continue"** button.
   * You will get to an interface that shows the following error:
 > Unavailable missing dependencies
 <br>(×) Not in the Plugins directory: block_userbulkdelete.
   * At this point, using the shell:
       * Go to the Moodle's installation root folder.
       * Run the following command on the shell: ```ln -s ../admin/tool/userbulkdelete/block_userbulkdelete blocks/userbulkdelete``` 
   * Return to the web interface showing the error and refresh the browser
   * Now that all the installation requirements have been fulfilled, just click on the **"Upgrade Moodle database now"** button.
   * You will receive the installation success message and that's it for the installation procedure.
   

## Usage:
 
 Upon installation, a custom block has been instantiated on the page http://yourmoodlesite.ch/admin/user/user_bulk.php,
 it contains a brief explanation of the process and a button to **"Perform Bulk Async Deletion"**.

* Go to http://yourmoodlesite.ch/admin/user/user_bulk.php, also available on the *"Users"* tab of the site administration section as **"Bulk asynchronous user deletion"**.
* Add to selection, any users you want to be deleted.
* Click on the **"Add to selection"** button.
* The page will refresh automatically, and the selected users will show in the appropriate list.
* Now click the **"Perform Bulk Async Deletion"** button.
* You will see the confirmation page **userbulkdelete**, with the list of the users to be deleted.
* Scroll to the bottom of the page and click on the **"Start asynchronous deletion"** button. 

Note that all of the users that cannot be deleted will automatically be excluded from the process.

At this point everything else should be handled by the **cron process**, otherwise, the commands to start performing the
async deletion tasks can be launched with the commands stated on the *"Pre-requisites"* section of this document.


#### Logs and Notices

The deletion process will perform one scheduled task for each user profile, if any of them fails, it will be rescheduled automatically, 
and one entry on the Moodle's standard log will be added, so it can be found on: http://yourmoodlesite.ch/report/log/index.php, 
where you can choose the *"CLI"* as the source of the entries in order to filter the messages.

By the end of the scheduled tasks processing, the system will issue a notification of success or failure with all the related details,
accessible via the bell icon on the header's menu or pointing the browser to http://yourmoodlesite.ch/message/output/popup/notifications.php

  
## Uninstallation:

The best way to unistall the plugin is:

* On the shell go to the Moodle's installation root folder and remove the plugin folder (e.g: ```rm -rf ./admin/tool/userbulkdelete/```
* Remove the symlink created when installing: ```unlink ./blocks/userbulkdelete```.
* Point the browser to: http://yourmoodlesite.ch/admin/index.php there, you will see the status of the two plugins is *"Missing from disk"*.
* Click on the **"Upgrade Moodle database now"**  button.
* Then, browse to the plugins overview page:  http://yourmoodlesite.ch/admin/plugins.php
* Search for *"userbulkdelete"*, you must find two lines, one for the tool plugin and another for the block.
* Click on the **"Uninstall"** link for the first one you want to remove and the interface will guide you through the rest of the process.
* You will be taken to an interface showing there's still one of the plugins missing from the disk, click on the **"Upgrade Moodle database now"** button.
* If the plugins overview page does not open automatically, browse to: http://yourmoodlesite.ch/admin/plugins.php
* Search for *"userbulkdelete"*, and you will find the remaining plugin details.
* Click on the **"Uninstall"** link and the interface will guide you through the rest of the process.
 
  
 ## Got any feedback?
  
 Please do not hesitate to contact us at elearning@liip.ch
 
 Happy user's bulk asynchronous deletion!
