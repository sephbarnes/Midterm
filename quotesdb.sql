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
(1, 'Jesus'),
(2, 'John'),
(3, 'David'),
(4, 'Paul'),
(5, 'Peter');

INSERT INTO categories (id, category) 
  VALUES
(1, 'Faith'),
(2, 'Holiness'),
(3, 'Love'),
(4, 'sin'),
(5, 'Salvation');

INSERT INTO quotes (id, quote, author_id, category_id) 
  VALUES
(1, 'I am the way, the truth, and the life: no man cometh unto the Father, but by me.', 1, 5),
(2, 'he that hath seen me hath seen the Father', 1, 5),
(3, 'But the Comforter, which is the Holy Ghost, whom the Father will send in my name, he shall teach you all things, and bring all things to your remembrance, whatsoever I have said unto you.', 1, 5),
(4, 'If ye love me, keep my commandments.', 1, 3),
(5, 'Verily, verily, I say unto thee, Except a man be born of water and of the Spirit, he cannot enter into the kingdom of God.', 1, 5),
(6, 'If we confess our sins, he is faithful and just to forgive us our sins, and to cleanse us from all unrighteousness.', 2, 4),
(7, 'If we say that we have no sin, we deceive ourselves, and the truth is not in us.', 2, 4),
(8, 'Marvel not, my brethren, if the world hate you.', 2, 1),
(9, 'He that loveth not knoweth not God; for God is love.', 2, 3),
(10, 'And this commandment have we from him, That he who loveth God love his brother also.', 2, 3),
(11, 'Repent, and be baptized every one of you in the name of Jesus Christ for the remission of sins, and ye shall receive the gift of the Holy Ghost.', 5, 5),
(12, 'Because it is written, Be ye holy; for I am holy.', 5, 2),
(13, 'But ye are a chosen generation, a royal priesthood, an holy nation, a peculiar people; that ye should shew forth the praises of him who hath called you out of darkness into his marvellous light:', 5, 2),
(14, 'Dearly beloved, I beseech you as strangers and pilgrims, abstain from fleshly lusts, which war against the soul;', 5, 4),
(15, 'For so is the will of God, that with well doing ye may put to silence the ignorance of foolish men:', 5, 2),
(16, 'I beseech you therefore, brethren, by the mercies of God, that ye present your bodies a living sacrifice, holy, acceptable unto God, which is your reasonable service.', 4, 2),
(17, 'There is therefore now no condemnation to them which are in Christ Jesus, who walk not after the flesh, but after the Spirit.', 4, 4),
(18, 'And we know that all things work together for good to them that love God, to them who are the called according to his purpose.', 4, 3),
(19, 'What shall we then say to these things? If God be for us, who can be against us?', 4, 3),
(20, 'Now I beseech you, brethren, by the name of our Lord Jesus Christ, that ye all speak the same thing, and that there be no divisions among you; but that ye be perfectly joined together in the same mind and in the same judgment.', 4, 2),
(21, 'Let every thing that hath breath praise the LORD. Praise ye the LORD.', 3, 1),
(22, 'The LORD is gracious, and full of compassion; slow to anger, and of great mercy.', 3, 1),
(23, 'The LORD is my shepherd; I shall not want.', 3, 1),
(24, 'Wait on the LORD: be of good courage, and he shall strengthen thine heart: wait, I say, on the LORD.', 3, 1),
(25, 'Create in me a clean heart, O God; and renew a right spirit within me.', 3, 5);