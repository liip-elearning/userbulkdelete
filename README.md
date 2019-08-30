moodle-tool_userbulkdelete
================================

Is a Moodle admin/tools plugin for deleting "big" amount of users in a single action.
It does it asynchronously with a scheduled task to avoid timeout errors.

https://gitlab.liip.ch/elearning/moodle-tool-userbulkdelete

Installation:
 
GIT: clone

Zipfile: Unzip the provided file into the directory *admin/tool*  


*IMPORTANT*
Since this plugin relies on another one that setup a block on the /admin/user/user_bulk.php page, it is mandatory to
create a symbolic link in order to install the related block plugin. To do so, please perform the following steps before 
going to your site's administration page. 

On the server's shell:

1.- Go to the Moodle installation root folder.
2.- Run the following command:
```ln -s ../admin/tool/userbulkdelete/block_userbulkdelete blocks/userbulkdelete```
3.- Go to your site's administration section. (e.g: http://yourmoodlesite.com/admin)
4.- Perform the upgrade.
5.- Happy asynchronous deletion.

 