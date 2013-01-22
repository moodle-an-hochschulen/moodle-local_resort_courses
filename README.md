moodle-local_resort_courses
===========================
Moodle plugin which sorts a category page automatically as soon as a course has been added or modified


Requirements
============
This plugin requires Moodle 2.3+


Changes
=======
2013-01-21 - Migrate plugin settings from config.php to a settings page within Moodle
2012-06-25 - Update version.php for Moodle 2.3
2012-06-01 - Initial version


Installation
============
Install the plugin like any other plugin to folder
/local/resort_courses

See http://docs.moodle.org/23/en/Installing_plugins for details on installing Moodle plugins


Usage & Settings
================
The local_resort_courses plugin acts completely behind the scenes. After installing local_resort_courses, as soon as a course has been added or modified in a category, local_resort_courses verifies that the containing category page is automatically sorted just as it would be sorted when you click the "Re-sort courses by name" button on the category page. 
To configure the behaviour of the plugin, please visit Plugins -> Local plugins -> Resort courses.

There, you find two sections:

1. Sort order
-------------
By default, local_resort_courses sorts categories by course full name in ascending order, just as the "Re-sort courses by name" button on the category page does. By setting the "Sort order" setting to another value, you can control the sort order of the course list.

2. Skip categories
------------------
By default, local_resort_courses handles resort jobs for every category. By selecting one or multiple categories in the "Skip categories" setting, you can define categories which mustn't be sorted automatically and whose sort order can still be controlled manually.

By default, when you select one or multiple categories in the "Skip categories" setting, local_resort_courses skips only the categories which are selected in the preceding setting. By checking the "Skip categories recursively" setting, you can define that local_resort_courses should skip the selected categories and all of their descendant categories when handling resort jobs.


Themes
======
The local_resort_courses plugin acts behind the scenes, therefore it works with all moodle themes.


Further information
===================
local_resort_courses is found in the Moodle Plugins repository: http://moodle.org/plugins/view.php?plugin=local_resort_courses

Report a bug or suggest an improvement: https://github.com/abias/moodle-local_resort_courses/issues


Copyright
=========
Alexander Bias, University of Ulm