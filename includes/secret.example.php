<?php
  // The secret.php file contains secret variables. Replace with your own variables and copy over to secret.php.

  // 0Auth (testing instance)
  define("AUTH0_DOMAIN", 'xxxxxx.auth0.com');
  define("AUTH0_CLIENT_ID", 'xxxxxx');
  define("AUTH0_CLIENT_SECRET", 'xxxxxx');
  define("AUTH0_AUDIENCE", 'urn:test:api');

  define("LOCAL_URL", "http://localhost:8888/");
  define("IS_DEVELOPMENT", true);

  define("AUTH0_MYLCUSD_EXCEPTIONS", array('xxx18', 'xxxxxx19'));
  define("USER_ADMINISTRATORS", array('jcartnal', 'lhicklin'));

  // Database PDO: credentials
  define("DB_HOST", "xxxxx");
  define("DB_NAME", "xxxxx");
  define("DB_USER", "xxxxx");
  define("DB_PASSWORD", "xxxxx");

  // Database PDO: List of Tables
  define("DB_TABLE_ANNOUNCEMENTS", "announcements");        // announcements table
  define("DB_TABLE_TEACHERS", "teachers");                  // table of teachers
  define("DB_TABLE_TAGS", "tags");                          // table of tags
  define("DB_TABLE_TAG_ANNOUNCEMENT", "tag_announcement");  // many-many table from tags to announcements
?>
