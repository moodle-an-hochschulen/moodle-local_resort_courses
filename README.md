moodle-local_resort_courses
===========================
Moodle plugin which sorts a category page automatically as soon as a course has been added or modified


Requirements
============
This plugin requires Moodle 2.1+


Changes
=======
2012-06-01 - Initial version


Installation
============
Install the plugin like any other plugin to folder
/local/resort_courses

See http://docs.moodle.org/22/en/Installing_plugins for details on installing Moodle plugins


Usage
=====
The local_resort_courses plugin acts completely behind the scenes. As soon as a course has been added or modified in a category, it verifies that the containing category page is automatically sorted just as it would be sorted when you click the "Re-sort courses by name" button on the category page.


Settings
========
local_resort_courses has no settings page, but it checks config.php for two configuration variables:

1. Sort order
-------------
By setting $CFG->resort_courses_sortorder to "fullname ASC", "fullname DESC", "shortname ASC", "shortname DESC", "idnumber ASC" or "idnumber DESC", you can control the sort order of the course list

Example in config.php:
$CFG->resort_courses_sortorder = "fullname ASC";

2. Skip categories
------------------
By setting $CFG->resort_courses_skip to a array of category IDs, you can exclude categories and all their descendant categories when resorting

Example in config.php:
$CFG->resort_courses_skip = array(42, 101);


Further information
===================
Report a bug or suggest an improvement: https://github.com/abias/moodle-local_resort_courses/issues