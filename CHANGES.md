moodle-local_resort_courses
===========================

Changes
-------

### v3.9-r1

* 2020-11-24 - Feature: Add a scheduled task which will re-sort all categories in the Moodle instance to make sure that all categories are sorted properly in any case.
               Please note: This scheduled task is disabled by default.
* 2020-11-24 - Improvement: Initialize the skipcategories setting with a proper default value. This did not affect the UI but some automated tests in Moodle core - Thanks to @ewallah for highlighting the issue.
* 2020-11-24 - Improvement: After MDL-57678 was integrated to Moodle core, remove local workaround for the fact that the select categories widgets did not properly handle &nbsp;.
               Please note: This raises the required Moodle core version to 3.9.2.
* 2020-11-24 - Prepare compatibility for Moodle 3.9.

### v3.8-r1

* 2020-02-13 - Prepare compatibility for Moodle 3.8.
* 2019-12-11 - Prevent that this plugin breaks Moodle core PHPUnit tests when installed on a site - Credits to eWallah.

### v3.7-r1

* 2019-08-14 - Added behat tests.
* 2019-08-14 - Fixed bug when adding a course to a category.
* 2019-08-14 - Prepare compatibility for Moodle 3.7.

### v3.6-r1

* 2019-01-23 - Check compatibility for Moodle 3.6, no functionality change.
* 2018-12-05 - Changed travis.yml due to upstream changes.

### v3.5-r1

* 2018-05-30 - Check compatibility for Moodle 3.5, no functionality change.

### v3.4-r2

* 2018-05-16 - Implement Privacy API.

### v3.4-r1

* 2018-03-06 - Check compatibility for Moodle 3.4, no functionality change.
* 2017-12-05 - Added Workaround to travis.yml for fixing Behat tests with TravisCI.

### v3.3-r1

* 2017-11-23 - Check compatibility for Moodle 3.3, no functionality change.
* 2017-11-08 - Updated travis.yml to use newer node version for fixing TravisCI error.

### v3.2-r3

* 2017-05-29 - Make codechecker happier
* 2017-05-29 - Add Travis CI support

### v3.2-r2

* 2017-05-05 - Improve README.md

### v3.2-r1

* 2017-01-13 - Check compatibility for Moodle 3.2, no functionality change
* 2017-01-12 - Move Changelog from README.md to CHANGES.md

### v3.1-r2

* 2016-07-21 - Move the plugin's settings page to Site Administration -> Courses because this is where it logically belongs to

### v3.1-r1

* 2016-07-19 - Check compatibility for Moodle 3.1, no functionality change

### Changes before v3.1

* 2016-02-10 - Change plugin version and release scheme to the scheme promoted by moodle.org, no functionality change
* 2016-01-01 - Check compatibility for Moodle 3.0, no functionality change
* 2015-08-21 - Avoid PHP warnings caused by accessing undefined property - Credits to Jarosław Maciejewski
* 2015-08-18 - Check compatibility for Moodle 2.9, no functionality change
* 2015-01-29 - Check compatibility for Moodle 2.8, no functionality change
* 2014-08-29 - Update README file
* 2014-08-25 - Support new event API, remove legacy event handling
* 2014-06-30 - Bugfix: Sorting by course start date and by course id was broken
* 2014-06-30 - Support new logging API, remove legacy logging
* 2014-06-30 - Check compatibility for Moodle 2.7, no functionality change
* 2014-01-31 - Check compatibility for Moodle 2.6, no functionality change
* 2013-07-30 - Transfer Github repository from github.com/abias/... to github.com/moodleuulm/...; Please update your Git paths if necessary
* 2013-07-30 - Check compatibility for Moodle 2.5, no functionality change
* 2013-04-23 - Check if we need to specify log events
* 2013-03-18 - Code cleanup according to moodle codechecker
* 2013-02-18 - Check compatibility for Moodle 2.4, fix language string names to comply with language string name convention
* 2013-01-21 - Migrate plugin settings from config.php to a settings page within Moodle
* 2012-06-25 - Update version.php for Moodle 2.3
* 2012-06-01 - Initial version
