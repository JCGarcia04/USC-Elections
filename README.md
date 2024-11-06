The files in this repository is only for the front-end of the application and is in localhost.

Apache and MySQL was used in the Xampp Control Panel
----- DATABASE auth -----
----- TABLE NAME login -----
----- id INT(8) UNSIGNED NOT NULL AUTO_INCREMENT, password VARCHAR(255) NOTNULL, PRIMARY KEY (id) -----

----- DATABASE vote_db -----
----- TABLE NAME votes -----
----- id INT(8) NOT NULL AUTO_INCREMENT, candidate_name VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL, position VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL, vote_time DATETIME NOT NULL, PRIMARY KEY (id)

----- TABLE NAME vote_status -----
----- id INT(8) NOT NULL AUTO_INCREMENT, has_voted TINYINT(1) NOT NULL, PRIMARY KEY (id) -----

