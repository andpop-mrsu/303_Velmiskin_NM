INSERT INTO users(first_name, last_name, email, gender, register_date, occupation_id)
VALUES
('Misha', 'Lomonosov', 'lomonosov_nauka@mrsu.ru', 'male', date('now'), (SELECT id FROM occupations o WHERE o.occupation == 'student')),
('Lew', 'Trotskiy', 'red_revolution@mrsu.ru', 'male', date('now'), (SELECT id FROM occupations o WHERE o.occupation == 'student')),
('Vladimir', 'Lenin', 'fatherOfPeople@mrsu.ru', 'male', date('now'), (SELECT id FROM occupations o WHERE o.occupation == 'student')),
('Eva', 'Draun', 'Other_Eva@mrsu.ru', 'female', date('now'), (SELECT id FROM occupations o WHERE o.occupation == 'student')),
('Karl', 'Marx', 'stop_kapitalism@mrsu.ru', 'male', date('now'), (SELECT id FROM occupations o WHERE o.occupation == 'student'));

INSERT INTO movies(title, year) 
VALUES
('The Lord of the Rings: The Fellowship of the Ring', 2001),
('The Lord of the Rings: The Two Towers', 2002),
('Lord of the Rings: The Return of the King', 2003);

INSERT INTO ratings(user_id, movie_id, rating, timestamp)
VALUES
((SELECT id FROM users WHERE users.email = 'fatherOfPeople@mrsu.ru'), (SELECT id FROM movies WHERE movies.title = 'The Lord of the Rings: The Fellowship of the Ring' and movies.year = 2001), 4.8, strftime('%s','now')),
((SELECT id FROM users WHERE users.email = 'fatherOfPeople@mrsu.ru'), (SELECT id FROM movies WHERE movies.title = 'The Lord of the Rings: The Two Towers' and movies.year = 2002), 4.9, strftime('%s','now')),
((SELECT id FROM users WHERE users.email = 'fatherOfPeople@mrsu.ru'), (SELECT id FROM movies WHERE movies.title = 'Lord of the Rings: The Return of the King' and movies.year = 2003), 5.0, strftime('%s','now'));