DROP DATABASE IF EXISTS  `w2w`;
CREATE DATABASE IF NOT EXISTS  `w2w`;
USE  `w2w`;

CREATE TABLE `roles` (
    `id` INT UNSIGNED NOT NULL,
    `name` VARCHAR(80) UNIQUE NOT NULL,
    `description` VARCHAR(255),
    PRIMARY KEY (`id`)
);

CREATE TABLE `users` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_name` VARCHAR(40) UNIQUE NOT NULL,
    `email` VARCHAR(255) UNIQUE NOT NULL,
    `email_verified` BOOLEAN NOT NULL,
    `password_hash` VARCHAR(255) NOT NULL,
    `first_name` VARCHAR(80),
    `last_name` VARCHAR(80),
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME,
    `last_login_at` DATETIME,
    `banned` BOOLEAN NOT NULL,
    `number_reviews` INT UNSIGNED NOT NULL,
    `fk_role_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `cst__users__fk_role_id` FOREIGN KEY (`fk_role_id`) REFERENCES `roles` (`id`)
);

CREATE TABLE `authentication_tokens` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(255) NOT NULL,
    `token` VARCHAR(40) NOT NULL,
    `expires_at` DATETIME NOT NULL,
    `verified_at` DATETIME,
    `new_password` BOOLEAN NOT NULL,
    `fk_user_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `cst__authentication_tokens__fk_user_id` FOREIGN KEY (`fk_user_id`) REFERENCES `users` (`id`)
);

CREATE TABLE `categories` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(80) UNIQUE NOT NULL,
    `description` VARCHAR(255),
    PRIMARY KEY (`id`)
);

CREATE TABLE `ratings` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(40) UNIQUE NOT NULL,
    `description` VARCHAR(255),
    `value` INT UNIQUE NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `movies` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(100) UNIQUE NOT NULL,
    `description` VARCHAR(255),
    `year` INTEGER,
    `poster` VARCHAR(255),
    `fk_category_id` INT UNSIGNED NOT NULL,
    `fk_admin_review_id` INT UNSIGNED,
    `fk_rating_id` INT UNSIGNED,
    PRIMARY KEY (`id`),
    CONSTRAINT `cst__movies__fk_category_id` FOREIGN KEY (`fk_category_id`) REFERENCES `categories` (`id`),
    CONSTRAINT `cst__movies__fk_rating_id` FOREIGN KEY (`fk_rating_id`) REFERENCES `ratings` (`id`)
);

CREATE TABLE `reviews` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `content` TEXT NOT NULL,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME,
    `fk_movie_id` INT UNSIGNED NOT NULL,
    `fk_user_id` INT UNSIGNED NOT NULL,
    `fk_rating_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `cst__reviews__unique` UNIQUE KEY (`fk_movie_id`, `fk_user_id`),
    CONSTRAINT `cst__reviews__fk_movie_id` FOREIGN KEY (`fk_movie_id`) REFERENCES `movies` (`id`),
    CONSTRAINT `cst__reviews__fk_user_id` FOREIGN KEY (`fk_user_id`) REFERENCES `users` (`id`),
    CONSTRAINT `cst__reviews__fk_rating_id` FOREIGN KEY (`fk_rating_id`) REFERENCES `ratings` (`id`)
);

-- added afterwards because of circular foreign keys relation between `movies` and `reviews` :
ALTER TABLE `movies` ADD CONSTRAINT `cst__movies__fk_admin_review_id` FOREIGN KEY (`fk_admin_review_id`) REFERENCES `reviews` (`id`);

CREATE TABLE `reports` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `message` TEXT NOT NULL,
    `created_at` DATETIME NOT NULL,
    `treated` BOOLEAN NOT NULL,
    `fk_user_id` INT UNSIGNED NOT NULL,
    `fk_review_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `cst__reports__fk_user_id` FOREIGN KEY (`fk_user_id`) REFERENCES `users` (`id`),
    CONSTRAINT `cst__reports__fk_review_id` FOREIGN KEY (`fk_review_id`) REFERENCES `reviews` (`id`)
);

CREATE TABLE `messages` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `first_name` VARCHAR(80),
    `last_name` VARCHAR(80) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `content` TEXT NOT NULL,
    `created_at` DATETIME NOT NULL,
    `treated` BOOLEAN NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `tags` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(80) UNIQUE NOT NULL,
    `description` VARCHAR(255),
    PRIMARY KEY (`id`)
);

CREATE TABLE `movies_tags` (
    `fk_movie_id` INT UNSIGNED NOT NULL,
    `fk_tag_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`fk_movie_id`, `fk_tag_id`),
    CONSTRAINT `cst__movies_tags__fk_movie_id` FOREIGN KEY (`fk_movie_id`) REFERENCES `movies` (`id`),
    CONSTRAINT `cst__movies_tags__fk_tag_id` FOREIGN KEY (`fk_tag_id`) REFERENCES `tags` (`id`)
);


CREATE TABLE `artists` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `first_name` VARCHAR(80),
    `last_name` VARCHAR(80) NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `movies_directors` (
    `fk_movie_id` INT UNSIGNED NOT NULL,
    `fk_artist_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`fk_movie_id`, `fk_artist_id`),
    CONSTRAINT `cst__movies_directors__fk_movie_id` FOREIGN KEY (`fk_movie_id`) REFERENCES `movies` (`id`),
    CONSTRAINT `cst__movies_directors__fk_artist_id` FOREIGN KEY (`fk_artist_id`) REFERENCES `tags` (`id`)
);

CREATE TABLE `movies_actors` (
    `fk_movie_id` INT UNSIGNED NOT NULL,
    `fk_artist_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`fk_movie_id`, `fk_artist_id`),
    CONSTRAINT `cst__movies_actors__fk_movie_id` FOREIGN KEY (`fk_movie_id`) REFERENCES `movies` (`id`),
    CONSTRAINT `cst__movies_actors__fk_artist_id` FOREIGN KEY (`fk_artist_id`) REFERENCES `tags` (`id`)
);
