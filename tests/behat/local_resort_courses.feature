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
      | fullname    | shortname | idnumber | category   | startdate       |
      | The X Files | xfiles    | 10       | catseries  | ##15 days ago## |
      | Lucifer     | lucifer   | 11       | catseries  | ##10 days ago## |
      | Ice Age     | iceage    | 12       | catmovies  | ##5 days ago##  |
      | Avatar      | avatar    | 13       | catmovies  | ##today##       |
      | Ice Age 2   | iceage2   | 14       | catsequels | ##15 days ago## |
      | Shrek 2     | shrek2    | 15       | catsequels | ##10 days ago## |

  Scenario: Sort courses by full name ascending order
    Given the following config values are set as admin:
      | config    | value | plugin               |
      | sortorder | 1     | local_resort_courses |
    When I log in as "admin"
    And I navigate to "Courses > Manage courses and categories" in site administration
    And I click on "Series" "link"
    And I click on "Create new course" "link"
    And I set the following fields to these values:
      | Course full name  | House M.D. |
      | Course short name | house      |
    And I click on "Save and return" "button"
    Then "House" "link" should appear before "Lucifer" "link"
    And "Lucifer" "link" should appear before "The X Files" "link"

  Scenario: Sort courses by full name descending order
    Given the following config values are set as admin:
      | config    | value | plugin               |
      | sortorder | 2     | local_resort_courses |
    When I log in as "admin"
    And I navigate to "Courses > Manage courses and categories" in site administration
    And I click on "Series" "link"
    And I click on "Create new course" "link"
    And I set the following fields to these values:
      | Course full name  | House M.D. |
      | Course short name | house      |
    And I click on "Save and return" "button"
    Then "The X Files" "link" should appear before "Lucifer" "link"
    And "Lucifer" "link" should appear before "House M.D." "link"

  Scenario: Sort courses by short name ascending order
    Given the following config values are set as admin:
      | config    | value | plugin               |
      | sortorder | 3     | local_resort_courses |
    When I log in as "admin"
    And I navigate to "Courses > Manage courses and categories" in site administration
    And I click on "Series" "link"
    And I click on "Create new course" "link"
    And I set the following fields to these values:
      | Course full name  | House M.D. |
      | Course short name | house      |
    And I click on "Save and return" "button"
    Then "House" "link" should appear before "Lucifer" "link"
    And "Lucifer" "link" should appear before "The X Files" "link"

  Scenario: Sort courses by short name descending order
    Given the following config values are set as admin:
      | config    | value | plugin               |
      | sortorder | 4     | local_resort_courses |
    When I log in as "admin"
    And I navigate to "Courses > Manage courses and categories" in site administration
    And I click on "Series" "link"
    And I click on "Create new course" "link"
    And I set the following fields to these values:
      | Course full name  | House M.D. |
      | Course short name | house      |
    And I click on "Save and return" "button"
    Then "The X Files" "link" should appear before "Lucifer" "link"
    And "Lucifer" "link" should appear before "House M.D." "link"

  Scenario: Sort courses by ID in ascending order
    Given the following config values are set as admin:
      | config    | value | plugin               |
      | sortorder | 5     | local_resort_courses |
    When I log in as "admin"
    And I navigate to "Courses > Manage courses and categories" in site administration
    And I click on "Series" "link"
    And I click on "Create new course" "link"
    And I set the following fields to these values:
      | Course full name  | House M.D. |
      | Course short name | house      |
      | Course ID number  | 5          |
    And I click on "Save and return" "button"
    And I click on "Sort by Course ID number ascending" "link"
    Then "House M.D." "link" should appear before "The X Files" "link"
    And "The X Files" "link" should appear before "Lucifer" "link"

  Scenario: Sort courses by ID in descending order
    Given the following config values are set as admin:
      | config    | value | plugin               |
      | sortorder | 6     | local_resort_courses |
    When I log in as "admin"
    And I navigate to "Courses > Manage courses and categories" in site administration
    And I click on "Series" "link"
    And I click on "Create new course" "link"
    And I set the following fields to these values:
      | Course full name  | House M.D. |
      | Course short name | house      |
      | Course ID number  | 5          |
    And I click on "Save and return" "button"
    And I click on "Sort by Course ID number descending" "link"
    Then "Lucifer" "link" should appear before "The X Files" "link"
    And "The X Files" "link" should appear before "House M.D." "link"

  Scenario: Sort courses by start date in ascending order
    Given the following config values are set as admin:
      | config    | value | plugin               |
      | sortorder | 7     | local_resort_courses |
    When I log in as "admin"
    And I navigate to "Courses > Manage courses and categories" in site administration
    And I click on "Series" "link"
    And I click on "Create new course" "link"
    And I set the following fields to these values:
      | Course full name  | House M.D. |
      | Course short name | house      |
    And I click on "Save and return" "button"
    Then "The X Files" "link" should appear before "Lucifer" "link"
    And "Lucifer" "link" should appear before "House M.D." "link"

  Scenario: Sort courses by start date in descending order
    Given the following config values are set as admin:
      | config    | value | plugin               |
      | sortorder | 8     | local_resort_courses |
    When I log in as "admin"
    And I navigate to "Courses > Manage courses and categories" in site administration
    And I click on "Series" "link"
    And I click on "Create new course" "link"
    And I set the following fields to these values:
      | Course full name  | House M.D. |
      | Course short name | house      |
    And I click on "Save and return" "button"
    Then "House M.D." "link" should appear before "Lucifer" "link"
    And "Lucifer" "link" should appear before "The X Files" "link"

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
    And I navigate to "Courses > Manage courses and categories" in site administration
    And I click on "Movies" "link"
    And I click on "Create new course" "link"
    And I set the following fields to these values:
      | Course full name  | E.T. |
      | Course short name | et   |
    And I click on "Save and return" "button"
    Then "E.T." "link" should appear before "Avatar" "link"
    And "Avatar" "link" should appear before "Ice Age" "link"

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
    And I navigate to "Courses > Manage courses and categories" in site administration
    And I click on "Series" "link"
    And I click on "Create new course" "link"
    And I set the following fields to these values:
      | Course full name  | House M.D. |
      | Course short name | house      |
    And I click on "Save and return" "button"
    Then "House" "link" should appear before "Lucifer" "link"
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
    And I navigate to "Courses > Manage courses and categories" in site administration
    And I click on "Movies" "link"
    And I click on "Sequels" "link"
    And I click on "Create new course" "link"
    And I set the following fields to these values:
      | Course full name  | Minions |
      | Course short name | minions |
    And I click on "Save and return" "button"
    Then "Minions" "link" should appear before "Ice Age 2" "link"
    And "Ice Age 2" "link" should appear before "Shrek 2" "link"
