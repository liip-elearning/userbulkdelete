# Block for the Moodle plugin tool_userbulkdelete

This is a Moodle block plugin for starting the Asynchronous tasks for the Bulk Deletion of a big amount of users.


# Installation:

The files for this plugin are stored inside the folder of the main tool (./admin/tool/userbulkdelete/block_userbulkdelete),
so, in order to be installed, a symbolic link has to be created, all the steps are described on the main tool README file. 

# Usage:

Upon installation, this plugin will instantiate a block on the page http://yourmoodlesite.ch/admin/user/user_bulk.php 
with a button for starting the Asynchronous Bulk deletion of users.  


# Uninstallation:

This plugin works together with the *tool_userbulkdelete* plugin. Being a plugin dependency, it cannot be uninstalled 
unless the main tool is uninstalled.

Upon deletion of the 'admin/tool/userbulkdelete' folder, the symbolic link has to be removed, all the steps are described 
on the main tool README file.