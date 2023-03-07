CREATE TABLE authors (
	id serial NOT NULL PRIMARY KEY,
	author varchar(50) NOT NULL
);
  
CREATE TABLE categories (
	id serial NOT NULL PRIMARY KEY,
	category varchar(20) NOT NULL
);
  
CREATE TABLE quotes (
	id serial NOT NULL PRIMARY KEY,
	quote text NOT NULL,
 	author_id INT NOT NULL,
	category_id INT NOT NULL,
  
	CONSTRAINT FK_quotes_authors FOREIGN KEY(author_id) REFERENCES authors(id),
	CONSTRAINT FK_quotes_categories FOREIGN KEY(category_id) REFERENCES categories(id)

);
  
INSERT INTO authors (id, author) 
  VALUES
(1, 'Technology'),
(2, 'Gaming'),
(3, 'Auto'),
(4, 'Entertainment'),
(5, 'Books');

INSERT INTO categories (id, category) 
  VALUES
(1, 'Technology'),
(2, 'Gaming'),
(3, 'Auto'),
(4, 'Entertainment'),
(5, 'Books');


