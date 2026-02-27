=== WP Survey And Quiz Tool ===
Contributors: Fubra,Backie,olliea95
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=99WUGVV4HY5ZE&lc=GB&item_name=CATN%20Plugins&item_number=catn&currency_code=GBP&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted
Tags: Quiz,test,exam,survey,results,email,quizzes,charts,google charts,wpsqt,tool,poll,polling,polls
Requires at least: 3.1
Tested up to: 3.4.1
Text Domain: wp-survey-and-quiz-tool
Stable tag: 2.13.1
A highly customisable Quiz, Survey and Poll plugin to which allows for unlimited questions and sections.

== Description ==

Allows users to create quizzes, surveys or polls hosted on their WordPress install.

There will be bugs and faults - hopefully not too many. Bug reports are crucial to improving the plugin. Please report all bugs and issues you find to the <a href="https://github.com/fubralimited/WP-Survey-And-Quiz-Tool/issues?sort=created&direction=desc&state=open">GitHub issue tracking page</a>. If you are not able to report the issue there then please use the <a href="http://wordpress.org/tags/wp-survey-and-quiz-tool?forum_id=10">forum</a>.

For full changelog and development history, see the <a href="https://github.com/fubralimited/WP-Survey-And-Quiz-Tool">GitHub repo</a>.

All documentation can be found on the <a href="https://github.com/fubralimited/WP-Survey-And-Quiz-Tool/wiki/_pages">GitHub Wiki</a>.

**Features**

* Unlimited quizzes, polls and surveys.
* Unlimited number of sections for quizzes, surveys and polls.
* Auto marking for quizzes with all multiple choice questions.
* Ability to limit quizzes and surveys to one submission per IP address, WordPress user or computer (using cookies).
* Ability to send customised notification emails.
* Ability to send notification emails to a single email address, multiple email addresses or a group of WordPress users.
* Ability to have notification emails only be sent if the user got a certain score.
* Ability to have surveys and quizzes be taken by registered WordPress members only.
* Ability to have quizzes and surveys with or without contact forms.
* Ability to have custom contact forms.
* Ability to export the results of quizzes.
* Ability to have PDF certifications using <a href="http://www.docraptor.com">DocRaptor</a>

**Requirements**

* PHP 5.2+
* WordPress 3.1
* Sessions
* cURL

**Developer Features**

Currently 30+ filters and hooks to use throughout the plugin to help extend it without editing the plugin.

Custom pages allows for the theming of the plugin pages without editing the plugin.

Developed by <a href="http://www.catn.com">PHP Hosting Experts CatN</a>.

**For those having issues with results not saving**

If you have upgraded from a version 1.x.x and nothing appears to be saving, please follow these instructions.

1. Make sure you have the latest version of the plugin
1. Deactivate plugin
1. Activate plugin
1. In the WPSQT menu click Maintenance
1. Select the Upgrade tab
1. Click the Upgrade button
1. Repeat all previous steps once more

Any further issues then feel free to create a thread on the <a href="http://wordpress.org/tags/wp-survey-and-quiz-tool?forum_id=10">forum</a>.

== ChangeLog ==

= 2.13.1 =

* Added several more strings for translation
* Added a link to the navbar for survey Total Results
* Fixed undefined variable notices
* Fixed progress bar displaying incorrectly when a contact form was enabled
* Fixed contact form occasionally not displaying
* Fixed error when using the navbar after viewing a survey's Total Results
* Fixed Likert answers in a survey not being cached correctly
* Fixed empty poll results being allowed for the single question type
* Fixed emails not being sent occasionally
* Changed timer to be client side, this fixes issues with loosing time due to page load
* Updated the included jQuery UI library to fix issues with WordPress 3.5

= 2.13 =

* Fixed several PHP notices
* Fixed navigation bar on quiz/survey/poll delete page
* Fixed multiple choice survey questions only counting first option selected
* Fixed 'other' graph showing for likert matrix questions when disallowed
* Fixed timer not showing due to extra whitespace in javascript
* Fixed W3C validation issues
* Fixed required free text questions not being checked for answer
* Fixed 'Answer Explanation' not displaying for free text questions
* Correctly sanitise various database queries
* Removed superfluous console.log() that was causing IE8 (and possibly other versions) to silently fail
* Replace all PHP short tags with the longer tags to ensure compatibility with all PHP configurations
* Added Spanish (es_ES) translation
* Added Italian (it_IT) translation
* Added Swedish (sv_SE) translation
* Added Romanian (ro_RO) translation
* Added option to hide/show survey results when survey is already taken and limiting is enabled
* Added option to show a progress bar on a quiz/survey
* Added option to randomise the order of the answers of a question
* Added ability to save and resume quizzes
* Added button to quickly insert a quiz/survey/poll into a new page

= 2.12 =

* Fixed survey total results not showing free text answers on some sections
* Fixed division by zero error for question success rate
* Fixed issue with section names that contained apostrophes
* Fixed the answer explanation for free text questions not showing
* Fixed additional text not displaying for certain questions in surveys
* Fixed %SCORE_PERCENTAGE% not correctly rounding
* Changed the email message to respondent to use view page instead of mark
* Changed field for question name to textarea for better readability
* Changed the front end strings to allow translations - see <a href="https://github.com/fubralimited/WP-Survey-And-Quiz-Tool/wiki/Translators">the translators page</a> for info on how to translate
* Added token for the results view page
* Added the shortcode for the quiz/survey/poll on edit page
* Added ability to only show answer explanation on quiz review
* Added ability to add extra information to answer explanation through the use of %TB_B% and %TB_E% tokens
* Added ability to mark a quiz even if it has free text questions
* Added ability to export the results of a quiz to csv
* Added Russian (ru_RU) and Dutch (nl_NL) translations

= 2.11 =

* Fixed poll results page when limited by cookie
* Fixed disabled quiz/poll/survey still displaying
* Fixed various issues with latest PHP
* Fixed var dump displaying when displaying certain surveys/polls
* Fixed duplication of quiz/poll/survey not assigning correct sections to questions
* Fixed scripts/styles not loading on <= WP 3.2.1
* Fixed many PHP notices
* Fixed the survey_results shortcode so it is positioned correctly in a post/page
* Fixed default dropdown answer
* Fixed bug when using custom permalinks and viewing the quiz on Firefox
* Fixed question points when assigned more than one
* Added ability to show quiz review only on fail
* Added success rate to questions
* Added ability to delete all results for poll/survey

= 2.10.2 =

* Added the ability to define an answer explanation

= 2.10.1 =

* Fixed error with maintenance page not able to display

= 2.10 =

* Fixed navigation links bug on results page
* Fixed update check to respect proxy settings
* Fixed poll results not displaying
* Fixed free text question hint not displaying
* Fixed several warnings from appearing
* Fixed survey creation - notification email is no longer required as stated
* Fixed person name being set to blank in certain cases
* Added ability to remove multiple results
* Added button to remove an image from a question
* Added custom form fields to results table
* Added sorting by headings on quiz results table
* Added option to hide Anonymous results
* Moved an option on the quiz options page to make a little more sense
* Removed IP address from results table - can be seen on mark page if required

= 2.9.3 =

* Removed redundant code that was a possible XSS vulnerability

= 2.9.2 =

* Several clarifications in admin panel
* Ability to customise chart size
* Ability to customise chart text size
* Ability to customise chart text colour
* Ability to abbreviation 'strongly' on chart

= 2.9.1 =

* Quiz duplication
* Change the order of questions
* Minor styling tweaks to admin panels
* Graphs fixed
* Cookies for limiting (as well as or instead of IP/WP User limiting)
* Added likert matrix question type

= 2.9 =

* Added results to finish display of surveys - like polls
* Tweaked survey results page
* Added option to customise graph colours

= 2.8.3 =

* Added %SCORE_PERCENTAGE% replacement token
* Changed the subject for emails sent from WPSQT
* Changed the email handler
* Only loaded the jquery files on a WPSQT page

= 2.8.2 =

* Fixed install script
* Fixed top scores widget

= 2.8.1 =

* Fixed pagination on quiz/survey list
* Fixed poll results for multiple questions
* Fixed several notices and warnings
* Cache all poll results like survey results
* Optimisation on several sections

= 2.8 =

* Rewritten the poll results backend, now much more reliable
* Polls with multiple sections now work entirely
* Allow poll results to be shown if the poll is already taken and limiting is enabled

= 2.7.4 =

* Fixed upgrade notice not appearing
* Fixed empty field validation
* Added shortcode to display the survey results on a page
* Clarified some error messages

= 2.7.3 =

* Fixed error with upgrading
* Added ability to add a timer for a quiz
* Addressed several layout issues
* Tested up to WP 3.3 Beta 2

= 2.7.2 =

* Fixed deleting survey results when they contain a free text, dropdown or multiple question
* Added some spacing after dropdown boxes

= 2.7.1 =

* Fix capability issue

= 2.7 =

* Added labels to the pie charts
* Added ability to change likert scale
* Added option to choose which role is required to admin WPSQT
* Added limit to one submission per WP user
* Fixed survey result deleting
* Changed the text of the next button to 'Submit' if on the last section
* Removed titles from within chart
* Moved all of the documentation to the <a href="https://github.com/fubralimited/WP-Survey-And-Quiz-Tool/wiki/_pages">GitHub Wiki</a>

= 2.6.6 =

* Fixed poll results view failing
* Fixed fatal error on PDF creation
* Fixed likert results on single and total views
* Add ability to set a different quiz finish message for pass

= 2.6.5 =

* Added limit to one submission for surveys
* Fixed multisite issues
* Fixed issues with section names containing quotes

= 2.6.4 =

* Updated the menu so it's hopefully more user friendly
* Fixed the total survey results page when there's a free text question
* Fixed issue where URLs were being encoded in additional text field and not decoded

= 2.6.3 =

* Proofread documentation
* Tidied up the update checker
* Updated the database backup feature
* Add option to run all previous upgrades
* Rolled out limit to IP for quizzes
* Allow longer quiz/survey/poll name

= 2.6.2 =

* Fixed sent from email field in Options page not working
* Fixed poll limit to one submission per IP
* Amended documentation
* Issues should now be reported on GitHub

= 2.6.1 =

* Included update checker
* Included legacy upgrade script - versions pre 2.1 should now work when updated

= 2.6 =

* Optimised the upgrade checking so the database isn't being written to on every page load
* Fixed an issue with the version comparing
* Fixed issue viewing total results on a survey when there are no results

= 2.5.9 =

* Changed the upgrade script so deactivation/activation isn't required after update

= 2.5.8 =

* Re added XSS protection

= 2.5.7 =

* Removed all the uses of htmlentities as it was encoding as ISO to a UTF8 table

= 2.5.6 =

* Various bug fixes

= 2.5.5 =

* Added option for custom survey finish message

= 2.5.4 =

* Fixed install script to install a correct database

= 2.5.3 =

* Update the URL in the email notification to point to the correct resultid
* Remove htmlentities and stripslashes on the additional text field so HTML can actually be used

= 2.5.2 =

* Made the maintenance menu more informative
* Once again fixed the poll results display
* Added a date taken column to the results page of quizzes, any results pre this update will not have a date

= 2.5.1 =

* Slight change to the upgrade script

= 2.5 =

* Quizzes now auto approve if passed
* Pass/Fail column now works as intended
* Removed the 'date viewed' column as that was misleading
* Finally fixed the upgrade script - please now use this if prompted

= 2.4.3 =

* Updated the documentation
* Fixed poll results not showing when the poll name isn't capitalised

= 2.4.2 =

* Changed default database collation to UTF8 - will not update old tables
* Fixed poll finish to show results if set
* Increased the size of the question title field - will not update old tables
* Fixed most notices and warnings

= 2.4.1 =

* Minor poll related bugs

= 2.4 =

* Added ability to create polls
* Fixed a couple of minor bugs

= 2.3 =

* Added widget for displaying top scores
* Added a pass mark feature - doesn't do anything yet
* Various bug fixes
* Conflicts with other plugins solved

= 2.2.3 =

* Added new shortcode to be able to display the results for a user

= 2.2.2 =

* Yet again fixed the positioning of a quiz/survey - all fixed and its not being touched again!
* Fixed the marking of quizzes unable for auto mark
* Added ability to backup the WPSQT databases - will be improved in a later release

= 2.2.1 =

* Temporarily removed the upgrade notice as it was misleading
* Add 'date viewed' to the results table of a quiz
* Many changes to the survey results page - including fixes and clarifications

= 2.2 =

* Fixed plugin stopping Super Cache from working correctly
* Fixed multiple choice questions occasionally appearing with radio buttons

= 2.1.1 =

* Final fix to the positioning of the quiz/survey

= 2.1 =

* Fixed free text questions not displaying in results
* Fixed email system when the user is logged in
* Fixed marking free text questions
* Fixed positioning of quiz/survey, the quiz/survey will now display wherever you place the shortcode, any content before/after will be placed accordingly
* Fixed token replacement in the finish message
* Quiz review page fixed - no longer repeats results many times and correctly displays free text answers
* Many spelling/grammatical errors fixed
* Some styling changes to the admin pages to make them look prettier

= 2.0-beta2 =

* Added scores and percentage columns to quiz result list#
* Added ability to send notification email
* Added navbar linking system for easier navigation throughout the plugin.
* Added image option for quizzes
* Added action in display question.
* Fixed PDF feature
* Fixed quiz review
* Fixed quiz roles not appearing
* Fixed various bugs


= 2.0-beta =

* Added Admin Bar menu
* Added Notifications per quiz and survey
* Added PDF functionality
* Added ability to have default answer choices on multiple choice questions
* Fixed design flaws with custom forms.
* Added image field for questions
* Added filters and improved extendibility
* Whole bunch of other stuff

== Upgrade Notice ==

= 2.9.3 =
Security release. XSS vulnerability has been removed.

= 2.5.2 =
Fixes for new poll system, doc updates, general bug fixes. Worth updating!

= 2.4 =
Lots of new features, mainly polls.

= 2.2.1 =
Almost completely stable and loads of improvements over the beta release.

= 2.1 =
A lot more stable than beta releases. There is still going to be a few bugs, please report them on the <a href="http://wordpress.org/tags/wp-survey-and-quiz-tool?forum_id=10">support forums</a>.

== Installation ==

* Download/upload plugin to wp-content/plugins directory
* Activate Plugin within Admin Dashboard.
* Run the upgrade script if prompted to

== Screenshots ==

1. Picture of contact details form.
2. Picture of multiple choice
3. Picture of free text area
4. Picture of the main page of the plugin admin section
5. Question List in Admin section
6. Edit Question in Admin section
7. Edit quiz in Admin section
8. Result list
9. Very limited mark result page
