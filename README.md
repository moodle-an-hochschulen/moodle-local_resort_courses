moodle-local_resort_courses
===========================

[![Build Status](https://travis-ci.com/moodleuulm/moodle-local_resort_courses.svg?branch=master)](https://travis-ci.com/moodleuulm/moodle-local_resort_courses)

Moodle plugin which sorts a category page automatically as soon as a course has been added or modified


Requirements
------------

This plugin requires Moodle 3.9+


Motivation for this plugin
--------------------------

Moodle core does not take care that Moodle course categories are sorted automatically. There is a sort button on every category page, but this button has to be pushed manually.

This approach makes sense if the course manager really needs to be in control of the sort order, but most of the time pressing the sort button manually after adding or updating a course is a daunting task.

If you want to get rid of this senseless job of pushing the sort button manually, this plugin is for you.


Installation
------------

Install the plugin like any other plugin to folder
/local/resort_courses

See http://docs.moodle.org/en/Installing_plugins for details on installing Moodle plugins


Usage & Settings
----------------

After installing the plugin, it is active and fully working.

As soon as a course has been added or modified in a category, the plugin verifies that the containing category page is automatically sorted just as it would be sorted when you change the sorting filter on the course category management page.

To configure the plugin and its behaviour, please visit:
Site administration -> Courses -> Re-sort courses.

There, you find two sections:

### 1. Sort order

By default, local_resort_courses sorts categories by course full name in ascending order, just as the filter on the course category management page is set by default. By setting the "Sort order" setting to another value, you can control the sort order of the course list.

### 2. Skip categories

By default, local_resort_courses handles re-sort jobs for every category. By selecting one or multiple categories in the "Skip categories" setting, you can define categories which mustn't be sorted automatically and whose sort order can still be controlled manually.

By default, when you select one or multiple categories in the "Skip categories" setting, local_resort_courses skips only the categories which are selected in the preceding setting. By checking the "Skip categories recursively" setting, you can define that local_resort_courses should skip the selected categories and all of their descendant categories when handling re-sort jobs.


How this plugin works
---------------------

This plugin simply catches the course_created and course_updated events which are fired when a course is created and updates and sorts the course's category automatically. That's it.

Additionally, there is a scheduled task local_resort_courses\task\resort_courses which is disabled by default but which can be enabled to make sure that all categories are sorted properly in any case.


Theme support
-------------

This plugin acts behind the scenes, therefore it should work with all Moodle themes.
It has been developed on and tested only with Moodle Core's Boost theme.
It should also work with Boost child themes, including Moodle Core's Classic theme. However, we can't support any other theme than Boost.


Plugin repositories
-------------------

This plugin is published and regularly updated in the Moodle plugins repository:
http://moodle.org/plugins/view/local_resort_courses

The latest development version can be found on Github:
https://github.com/moodleuulm/moodle-local_resort_courses


Bug and problem reports / Support requests
------------------------------------------

This plugin is carefully developed and thoroughly tested, but bugs and problems can always appear.

Please report bugs and problems on Github:
https://github.com/moodleuulm/moodle-local_resort_courses/issues

We will do our best to solve your problems, but please note that due to limited resources we can't always provide per-case support.


Feature proposals
-----------------

Due to limited resources, the functionality of this plugin is primarily implemented for our own local needs and published as-is to the community. We are aware that members of the community will have other needs and would love to see them solved by this plugin.

Please issue feature proposals on Github:
https://github.com/moodleuulm/moodle-local_resort_courses/issues

Please create pull requests on Github:
https://github.com/moodleuulm/moodle-local_resort_courses/pulls

We are always interested to read about your feature proposals or even get a pull request from you, but please accept that we can handle your issues only as feature _proposals_ and not as feature _requests_.


Moodle release support
----------------------

Due to limited resources, this plugin is only maintained for the most recent major release of Moodle as well as the most recent LTS release of Moodle. Bugfixes are backported to the LTS release. However, new features and improvements are not necessarily backported to the LTS release.

Apart from these maintained releases, previous versions of this plugin which work in legacy major releases of Moodle are still available as-is without any further updates in the Moodle Plugins repository.

There may be several weeks after a new major release of Moodle has been published until we can do a compatibility check and fix problems if necessary. If you encounter problems with a new major release of Moodle - or can confirm that this plugin still works with a new major release - please let us know on Github.

If you are running a legacy version of Moodle, but want or need to run the latest version of this plugin, you can get the latest version of the plugin, remove the line starting with $plugin->requires from version.php and use this latest plugin version then on your legacy Moodle. However, please note that you will run this setup completely at your own risk. We can't support this approach in any way and there is an undeniable risk for erratic behavior.


Translating this plugin
-----------------------

This Moodle plugin is shipped with an english language pack only. All translations into other languages must be managed through AMOS (https://lang.moodle.org) by what they will become part of Moodle's official language pack.

As the plugin creator, we manage the translation into german for our own local needs on AMOS. Please contribute your translation into all other languages in AMOS where they will be reviewed by the official language pack maintainers for Moodle.


Right-to-left support
---------------------

This plugin has not been tested with Moodle's support for right-to-left (RTL) languages.
If you want to use this plugin with a RTL language and it doesn't work as-is, you are free to send us a pull request on Github with modifications.


PHP7 Support
------------

Since Moodle 3.4 core, PHP7 is mandatory. We are developing and testing this plugin for PHP7 only..


Copyright
---------

Ulm University
Communication and Information Centre (kiz)
Alexander Bias
