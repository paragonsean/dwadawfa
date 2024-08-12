=== Autoresponder Addon for Newsletter ===
Tested up to: 6.6.1

== Changelog ==

= 1.5.6 =

* WP 6.6.1 check
* Fixed the autortesponder start from the user editing page

= 1.5.5 =

* WP 6.6 check

= 1.5.4 =

* Changed some instructions

= 1.5.3 =

* Isolation of admin/public code
* Added restart button to subscribers
* Added series list on subscribers details panel (of Newsletter)
* Added alignment button
* Change the automatic alignment as separated process to save resources
* Automatic alignment can be enabled/disabled
* New rules panel to make more clear the configuration
* Rules can be enabled/disabled
* Added sender name and email on each series
* Requires Newsletter 8.4.1
* WP 6.5.5 check

= 1.5.2 =

* Fixed the align procedure
* WP 6.5.4 check

= 1.5.1 =

* WP 6.5.3 check
* Added support for the support data service

= 1.5.0 =

* Added checks for fatal errors
* WP 6.5.2 check
* Per language rule
* All subscribers rule
* Integration with the subscriber details admin page

= 1.4.6 =

* Fixed the restart behavior on resubscription

= 1.4.5 =

* WP 6.4.3 compatibility check
* Aligned with Newsletter 8.1.2

= 1.4.3 =

* Removed obsolete scheduled event
* Revisited the admin interface
* Checked with WP 6.3.1
* Minimim Newsletter version raised to 7.8
* Minimim PHP version raised to 7.0

= 1.4.3 =

* Fixed statistics access button breaking the stats page

= 1.4.2 =

* Fixed missing subject when regeneration is active

= 1.4.1 =

* Fixed statistics button on general stats panel

= 1.4.0 =

* Fixex email testing with Newsletter 7.8
* Reorganized admin interface
* Fixed error in statsitics page with Newsletter 7.8

= 1.3.8 =

* Changed delay validation to allow decimal numbers
* Added regeneration of emails' content

= 1.3.7 =

* WP 5.9 compatibility check
* Minor optimizations

= 1.3.6 =

* Fixed CSS inclusion
* Compatibility checked with WP 5.8.3

= 1.3.5 =

* Query error due to missing max emails fixed

= 1.3.4 =

* Fixed convert button on maintenance panel

= 1.3.3 =

* Added the step placeholder for google analytics

= 1.3.2 =

* Compatibility with WP 5.8 meta data
* Added Google Analytics configuration

= 1.3.1 =

* Added support to restart on resubscribe
* Added new lists activation on series completion

= 1.3.0 =

* Thank you for Thomas LEJEUNE for the request and code sample to implement the massive re-enable (see below)
* New subscriber list action to control the subscriber status
* Fixed the immediate series block in some subscription conditions
* Added massive action to re-enable the subscribers who completed the series for new late added steps
* More coherence between panels
* Advanced options and action move to separated panel

= 1.2.9 =

* Fixed delay displayed on email list

= 1.2.8 =

* Fix email sending on second subscription

= 1.2.7 =

* Improved user list
* Added https to gravatar image
* More room for serties with numerous steps

= 1.2.6 =

* More detailed report on autoresponder subscriber list panel
* Filter on subscriber list panel to show the processing or late subscribers
* Cleanup of data of deleted subscribers (which may lead to show a late warning)

= 1.2.5 =

* Improved reporting of late messages

= 1.2.4 =

* Added check for {message} tag in the hand coded theme
* Fix bug not applying the template when testing messages made with the old theme system

= 1.2.3 =

* Fixed the tracking flag

= 1.2.2 =

* Fixed the email status on series duplication

= 1.2.1 =

* Added conversion feature from old series to the new one (with composer)

= 1.2.0 =

* Added on confirmation immediate send of message 1 when the delay is set to zero
* Interface redesign
* Improved statistics report
* Test mode changed: now it must be triggered manually and limited to one single series at time
* Great log details when Newsletter is in debug mode
* In test mode there is a reset all button to make the test easy
* In test mode the number of emails sent are not limited by your set speed (otherwise test could be not easy to read -
keep the number of subscribers in a series small when doing tests)
* Somewhere changed the terminology to be more clear
* Added warning if the autoresponder is cumulating delays

= 1.1.4 =

* Duplication fix
* Number of steps on autoresponder list

= 1.1.3 =

* Added action on subscriber list to reset the status or restart the series
* Menu icon fix

= 1.1.2 =

* Fixed menu for editors

= 1.1.1 =

* Fixed step deletion bug

= 1.1.0 =

* Improved theme configuration and preview

= 1.0.8 =

* Added hand-coded theme

= 1.0.7 =

* Fixed autoresponder processing which does not proceed in a specific case

= 1.0.6 =

* Fix the autoresponder list

= 1.0.5 =

* Fix delay not keeping the zero value
* Fix debug notice

= 1.0.3 =

* Fix

= 1.0.0 =

* First release
