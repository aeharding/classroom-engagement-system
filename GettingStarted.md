# Requirements #

## Server ##
  * PHP 5 or greater (w/ mail()).
  * MySQL Database with a user with full permissions to an empty table.

## User ##
  * HTML5, CSS3 compliant browser
  * Can run on:
  * Windows Phone 8
  * iOS (not specifically supported)
  * Android (supposedly)

# Procedure #
  1. Download the build of interest (either from the source `webserver` directory or the downloads tab above).
  1. Place the files under the `www` directory on your webserver.
  1. In a text editor, change the settings in `setup/connect.php` to contain valid MySQL connection settings and an absolute URL for the email service.
  1. In a browser, run `setup/newDatabase.php`.
    * **Delete this file once complete with no errors.**