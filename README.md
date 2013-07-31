moodle-local_resort_courses
===========================
Moodle plugin which sorts a category page automatically as soon as a course has been added or modified


Requirements
============
This plugin requires Moodle 2.5+


Changes
=======
2013-07-30 - Transfer Github repository from github.com/abias/... to github.com/moodleuulm/...; Please update your Git paths if necessary
2013-07-30 - Check compatibility for Moodle 2.5, no functionality change
2013-04-23 - Check if we need to specify log events
2013-03-18 - Code cleanup according to moodle codechecker
2013-02-18 - Check compatibility for Moodle 2.4, fix language string names to comply with language string name convention
2013-01-21 - Migrate plugin settings from config.php to a settings page within Moodle
2012-06-25 - Update version.php for Moodle 2.3
2012-06-01 - Initial version


Installation
============
Install the plugin like any other plugin to folder
/local/resort_courses

See http://docs.moodle.org/25/en/Installing_plugins for details on installing Moodle plugins


Usage & Settings
================
The local_resort_courses plugin acts completely behind the scenes. After installing local_resort_courses, as soon as a course has been added or modified in a category, local_resort_courses verifies that the containing category page is automatically sorted just as it would be sorted when you click the "Re-sort courses by name" button on the category page.
To configure the behaviour of the plugin, please visit Plugins -> Local plugins -> Re-sort courses.

There, you find two sections:

1. Sort order
-------------
By default, local_resort_courses sorts categories by course full name in ascending order, just as the "Re-sort courses by name" button on the category page does. By setting the "Sort order" setting to another value, you can control the sort order of the course list.

2. Skip categories
------------------
By default, local_resort_courses handles re-sort jobs for every category. By selecting one or multiple categories in the "Skip categories" setting, you can define categories which mustn't be sorted automatically and whose sort order can still be controlled manually.

By default, when you select one or multiple categories in the "Skip categories" setting, local_resort_courses skips only the categories which are selected in the preceding setting. By checking the "Skip categories recursively" setting, you can define that local_resort_courses should skip the selected categories and all of their descendant categories when handling re-sort jobs.


Themes
======
The local_resort_courses plugin acts behind the scenes, therefore it works with all moodle themes.


Further information
===================
local_resort_courses is found in the Moodle Plugins repository: http://moodle.org/plugins/view.php?plugin=local_resort_courses

Report a bug or suggest an improvement: https://github.com/moodleuulm/moodle-local_resort_courses/issues


Moodle release support
======================
Due to limited ressources, local_resort_courses is only maintained for the most recent major release of Moodle. However, previous versions of this plugin which work in legacy major releases of Moodle are still available as-is without any further updates in the Moodle Plugins repository.

There may be several weeks after a new major release of Moodle has been published until I can do a compatibility check and fix problems if necessary. If you encounter problems with a new major release of Moodle - or can confirm that local_resort_courses still works with a new major relase - please let me know on https://github.com/moodleuulm/moodle-local_resort_courses/issues


Right-to-left support
=====================
This plugin has not been tested with Moodle's support for right-to-left (RTL) languages.
If you want to use this plugin with a RTL language and it doesn't work as-is, you are free to send me a pull request on
github with modifications.


Copyright
=========
Alexander Bias, University of Ulm
