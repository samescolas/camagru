CREATE TABLE images (
	id INT NOT NULL AUTO_INCREMENT,
	user_id INT NOT NULL,
	location VARCHAR(80) NOT NULL,
	image_type VARCHAR(12) NOT NULL,
	title VARCHAR(32),
	description TEXT,
	creation_dt DATETIME  NOT NULL DEFAULT NOW(),
	PRIMARY KEY (id),
	FOREIGN KEY (user_id) REFERENCES users(id)
);
