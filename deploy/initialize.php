<?php
// Wait for MySQL during the first Blueprint deployment; do not log credentials.
for ($attempt = 0; $attempt < 60; $attempt++) {
    try {
        new PDO('mysql:host='.getenv('DB_HOST').';port='.(getenv('DB_PORT') ?: '3306').';dbname='.getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'), [PDO::ATTR_TIMEOUT => 5]);
        exit(0);
    } catch (PDOException $e) {
        if ($attempt === 59) { fwrite(STDERR, "MySQL unavailable. Check the database service and DB variables.\n"); exit(1); }
        sleep(5);
    }
}
