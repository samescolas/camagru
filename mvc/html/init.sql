CREATE USER 'camagru'@'localhost' IDENTIFIED BY 'camagru';

GRANT ALL PRIVILEGES ON *.* TO 'camagru'@'localhost';

FLUSH PRIVILEGES;

USE camagru;

CREATE TABLE users (
	id INT NOT NULL AUTO_INCREMENT,
	username VARCHAR(18) NOT NULL, 
	email VARCHAR(32) NOT NULL,
	dt_joined DATETIME DEFAULT NOW(),
	PRIMARY KEY (id)
);

CREATE TABLE shadow (
	id INT NOT NULL AUTO_INCREMENT,
	user_id INT NOT NULL,
	passwd CHAR(64),
	salt CHAR(32),
	PRIMARY KEY (id),
	FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE sessions (
	id INT NOT NULL AUTO_INCREMENT,
	user_id INT NOT NULL,
	hash CHAR(64) NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE images (
	id INT NOT NULL AUTO_INCREMENT,
	user_id INT NOT NULL,
	location VARCHAR(96) NOT NULL,
	image_type VARCHAR(12) NOT NULL,
	title VARCHAR(32),
	description TEXT,
	creation_dt DATETIME  NOT NULL DEFAULT NOW(),
	PRIMARY KEY (id),
	FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE likes (
	id INT NOT NULL AUTO_INCREMENT,
	user_id INT NOT NULL,
	image_id INT NOT NULL,
	dt DATETIME NOT NULL DEFAULT NOW(),
	PRIMARY KEY (id),
	FOREIGN KEY (user_id) REFERENCES users(id),
	FOREIGN KEY (image_id) REFERENCES images(id)
);

CREATE TABLE email_verification (
	id INT NOT NULL AUTO_INCREMENT,
	user_id INT NOT NULL,
	token VARCHAR(64),
	PRIMARY KEY (id),
	FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE comments (
	id INT NOT NULL AUTO_INCREMENT,
	user_id INT NOT NULL,
	image_id INT NOT NULL,
	comment TEXT NOT NULL,
	dt DATETIME NOT NULL DEFAULT NOW(),
	PRIMARY KEY (id),
	FOREIGN KEY (user_id) REFERENCES users(id),
	FOREIGN KEY (image_id) REFERENCES images(id)
);
