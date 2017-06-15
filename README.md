# Spartan Connect: Web App
A basic web app that allows teachers and administrators to add announcements to the Spartan Connect mobile app.

# Setup
1. Clone this setup into your htdocs/www folder
2. Import a mock database into your MySQL setup. Ask a team member for a sample database.
3. Download and setup Composer: https://getcomposer.org/download/
4. Change working directory to your previous folder and run `composer install` (or `./composer.phar install`). This will install the Auth0 dependencies.
5. Install bower through npm: `npm install -g bower`
6. Install bower dependencies: `bower install`
7. Go to your localhost and check if it's working!
8. If you are on Windows and are running into problems with `curl` and certificates, see https://github.com/auth0/Auth0-PHP#troubleshoot.
