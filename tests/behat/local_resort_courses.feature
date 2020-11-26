@local @local_resort_courses
Feature: Using the local_resort_courses plugin
  In order to resort courses
  As admin
  I need to be able to configure the plugin local_resort_courses

  Background:
    Given the following "categories" exist:
      | name    | category  | idnumber   |
      | Series  | 0         | catseries  |
      | Movies  | 0         | catmovies  |
      | Sequels | catmovies | catsequels |
    And the following "courses" exist:
      | fullname    | shortname | idnumber | category   | startdate                  |
      | House M.D.  | house     | 10       | catseries  | ##15 days ago##            |
      | The X Files | xfiles    | 12       | catseries  | ##last day of next month## |
      | Avatar      | avatar    | 13       | catmovies  | ##today##                  |
      | Ice Age     | iceage    | 14       | catmovies  | ##today##                  |
      | Ice Age 2   | iceage2   | 15       | catsequels | ##today##                  |
      | Shrek 2     | shrek2    | 16       | catsequels | ##today##                  |

  Scenario: Sort courses by full name ascending order
    Given the following config values are set as admin:
      | config    | value | plugin               |
      | sortorder | 1     | local_resort_courses |
    When I log in as "admin"
    And I am on course index
    And I follow "Series"
    And "House M.D." "link" should appear before "The X Files" "link"
    And I click on "Add a new course" "button"
    And I set the following fields to these values:
      | Course full name  | Lucifer |
      | Course short name | lucifer |
    And I click on "Save and return" "button"
    Then "House M.D." "link" should appear before "Lucifer" "link"
    And "Lucifer" "link" should appear before "The X Files" "link"

  Scenario: Sort courses by full name descending order
    Given the following config values are set as admin:
      | config    | value | plugin               |
      | sortorder | 2     | local_resort_courses |
    When I log in as "admin"
    And I am on course index
    And I follow "Series"
    And "House M.D." "link" should appear before "The X Files" "link"
    And I click on "Add a new course" "button"
    And I set the following fields to these values:
      | Course full name  | Lucifer |
      | Course short name | lucifer |
    And I click on "Save and return" "button"
    Then "The X Files" "link" should appear before "Lucifer" "link"
    And "Lucifer" "link" should appear before "House M.D." "link"

  Scenario: Sort courses by short name ascending order
    Given the following config values are set as admin:
      | config    | value | plugin               |
      | sortorder | 3     | local_resort_courses |
    When I log in as "admin"
    And I am on course index
    And I follow "Series"
    And "House M.D." "link" should appear before "The X Files" "link"
    And I click on "Add a new course" "button"
    And I set the following fields to these values:
      | Course full name  | Lucifer |
      | Course short name | lucifer |
    And I click on "Save and return" "button"
    Then "House M.D." "link" should appear before "Lucifer" "link"
    And "Lucifer" "link" should appear before "The X Files" "link"

  Scenario: Sort courses by short name descending order
    Given the following config values are set as admin:
      | config    | value | plugin               |
      | sortorder | 4     | local_resort_courses |
    When I log in as "admin"
    And I am on course index
    And I follow "Series"
    And "House M.D." "link" should appear before "The X Files" "link"
    And I click on "Add a new course" "button"
    And I set the following fields to these values:
      | Course full name  | Lucifer |
      | Course short name | lucifer |
    And I click on "Save and return" "button"
    Then "The X Files" "link" should appear before "Lucifer" "link"
    And "Lucifer" "link" should appear before "House M.D." "link"

  Scenario: Sort courses by ID in ascending order
    Given the following config values are set as admin:
      | config    | value | plugin               |
      | sortorder | 5     | local_resort_courses |
    When I log in as "admin"
    And I am on course index
    And I follow "Series"
    And "House M.D." "link" should appear before "The X Files" "link"
    And I click on "Add a new course" "button"
    And I set the following fields to these values:
      | Course full name  | Lucifer |
      | Course short name | lucifer |
      | Course ID number  | 11      |
    And I click on "Save and return" "button"
    Then "House M.D." "link" should appear before "Lucifer" "link"
    And "Lucifer" "link" should appear before "The X Files" "link"

  Scenario: Sort courses by ID in descending order
    Given the following config values are set as admin:
      | config    | value | plugin               |
      | sortorder | 6     | local_resort_courses |
    When I log in as "admin"
    And I am on course index
    And I follow "Series"
    And "House M.D." "link" should appear before "The X Files" "link"
    And I click on "Add a new course" "button"
    And I set the following fields to these values:
      | Course full name  | Lucifer |
      | Course short name | lucifer |
      | Course ID number  | 11      |
    And I click on "Save and return" "button"
    Then "The X Files" "link" should appear before "Lucifer" "link"
    And "Lucifer" "link" should appear before "House M.D." "link"

  Scenario: Sort courses by start date in ascending order
    Given the following config values are set as admin:
      | config    | value | plugin               |
      | sortorder | 7     | local_resort_courses |
    When I log in as "admin"
    And I am on course index
    And I follow "Series"
    And "House M.D." "link" should appear before "The X Files" "link"
    And I click on "Add a new course" "button"
    And I set the following fields to these values:
      | Course full name  | Lucifer |
      | Course short name | lucifer |
      # Start date will be automatically set to tomorrow.
    And I click on "Save and return" "button"
    Then "House M.D." "link" should appear before "Lucifer" "link"
    And "Lucifer" "link" should appear before "The X Files" "link"

  Scenario: Sort courses by start date in descending order
    Given the following config values are set as admin:
      | config    | value | plugin               |
      | sortorder | 8     | local_resort_courses |
    When I log in as "admin"
    And I am on course index
    And I follow "Series"
    And "House M.D." "link" should appear before "The X Files" "link"
    And I click on "Add a new course" "button"
    And I set the following fields to these values:
      | Course full name  | Lucifer |
      | Course short name | lucifer |
      # Start date will be automatically set to tomorrow.
    And I click on "Save and return" "button"
    Then "The X Files" "link" should appear before "Lucifer" "link"
    And "Lucifer" "link" should appear before "House M.D." "link"

  Scenario: Sort courses by full name ascending order but skip category Movies
    Given the following config values are set as admin:
      | config         | value  | plugin               |
      | sortorder      | 1      | local_resort_courses |
    When I log in as "admin"
    And I navigate to "Courses > Re-sort Courses" in site administration
    And I set the field "Skip categories" to multiline:
    """
    Movies
    """
    And I click on "Save changes" "button"
    And I am on course index
    And I follow "Movies"
    And "Avatar" "link" should appear before "Ice Age" "link"
    And I click on "Add a new course" "button"
    And I set the following fields to these values:
      | Course full name  | E.T. |
      | Course short name | et   |
    And I click on "Save and return" "button"
    Then "Avatar" "link" should appear before "Ice Age" "link"
    And "E.T." "link" should appear before "Avatar" "link"

  Scenario: Sort courses by full name ascending order but skip category Movies and check for non skipped category
    Given the following config values are set as admin:
      | config         | value  | plugin               |
      | sortorder      | 1      | local_resort_courses |
    When I log in as "admin"
    And I navigate to "Courses > Re-sort Courses" in site administration
    And I set the field "Skip categories" to multiline:
    """
    Movies
    """
    And I click on "Save changes" "button"
    And I am on course index
    And I follow "Series"
    And "House M.D." "link" should appear before "The X Files" "link"
    And I click on "Add a new course" "button"
    And I set the following fields to these values:
      | Course full name  | Lucifer |
      | Course short name | lucifer |
    And I click on "Save and return" "button"
    Then "House M.D." "link" should appear before "Lucifer" "link"
    And "Lucifer" "link" should appear before "The X Files" "link"

  Scenario: Sort courses by full name ascending order but skip category Movies recursively
    Given the following config values are set as admin:
      | config                    | value  | plugin               |
      | sortorder                 | 1      | local_resort_courses |
      | skipcategoriesrecursively | 1      | local_resort_courses |
    When I log in as "admin"
    And I navigate to "Courses > Re-sort Courses" in site administration
    And I set the field "Skip categories" to multiline:
    """
    Movies
    """
    And I click on "Save changes" "button"
    And I am on course index
    And I follow "Movies"
    And I follow "Sequels"
    And "Ice Age 2" "link" should appear before "Shrek 2" "link"
    And I click on "Add a new course" "button"
    And I set the following fields to these values:
      | Course full name  | Minions |
      | Course short name | minions |
    And I click on "Save and return" "button"
    Then "Ice Age 2" "link" should appear before "Shrek 2" "link"
    And "Minions" "link" should appear before "Ice Age 2" "link"

  Scenario: Sort all course categories with the scheduled task
    Given the following "categories" exist:
      | name       | category | idnumber |
      | Category A | 0        | catA     |
      | Category B | 0        | catB     |
      | Category C | catA     | catC     |
    And the following "courses" exist:
      | fullname   | shortname | category |
      | AAA Course | aaa       | catA     |
      | CCC Course | ccc       | catA     |
      | ZZZ Course | zzz       | catA     |
      | BBB Course | bbb       | catB     |
      | DDD Course | ddd       | catB     |
      | EEE Course | eee       | catC     |
      | FFF Course | fff       | catC     |
    And the following config values are set as admin:
      | config    | value | plugin               |
      | sortorder | 2     | local_resort_courses |
    When I log in as "admin"
    And I am on course index
    And I follow "Category A"
    Then "CCC Course" "link" should appear before "ZZZ Course" "link"
    And "AAA Course" "link" should appear before "CCC Course" "link"
    And I follow "Category C"
    And "EEE Course" "link" should appear before "FFF Course" "link"
    And I am on course index
    And I follow "Category B"
    And "BBB Course" "link" should appear before "DDD Course" "link"
    When I run the scheduled task "local_resort_courses\task\resort_courses"
    And I am on course index
    And I follow "Category A"
    Then "ZZZ Course" "link" should appear before "CCC Course" "link"
    And "CCC Course" "link" should appear before "AAA Course" "link"
    And I follow "Category C"
    And "FFF Course" "link" should appear before "EEE Course" "link"
    And I am on course index
    And I follow "Category B"
    And "DDD Course" "link" should appear before "BBB Course" "link"
