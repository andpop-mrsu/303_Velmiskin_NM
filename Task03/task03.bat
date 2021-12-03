#!/bin/bash
chcp 65001

sqlite3 movies_rating.db < db_init.sql

echo "1. Составить список фильмов, имеющих хотя бы одну оценку. Список фильмов отсортировать по году выпуска и по названиям. В списке оставить первые 10 фильмов."
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "SELECT DISTINCT m.*  FROM movies m INNER JOIN ratings r ON m.id = r.movie_id ORDER BY year, title LIMIT 10"
echo " "

echo "2. Вывести список всех пользователей, фамилии (не имена!) которых начинаются на букву 'A'. Полученный список отсортировать по дате регистрации. В списке оставить первых 5 пользователей."
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "SELECT * FROM users WHERE name LIKE '% A%' ORDER BY register_date LIMIT 5"
echo " "

echo "3. Написать запрос, возвращающий информацию о рейтингах в более читаемом формате: имя и фамилия эксперта, название фильма, год выпуска, оценка и дата оценки в формате ГГГГ-ММ-ДД. Отсортировать данные по имени эксперта, затем названию фильма и оценке. В списке оставить первые 50 записей."
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "SELECT name, title, year, rating, DATE(timestamp, 'unixepoch') as rating_date FROM users u JOIN movies m JOIN ratings r WHERE u.id = r.user_id AND m.id = r.movie_id ORDER BY name, title, rating LIMIT 50"
echo " "

echo "4. Вывести список фильмов с указанием тегов, которые были им присвоены пользователями. Сортировать по году выпуска, затем по названию фильма, затем по тегу. В списке оставить первые 40 записей."
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "SELECT m.*, tag FROM movies m INNER JOIN tags t ON m.id = t.movie_id ORDER BY year, title, tag LIMIT 40"
echo " "

echo "5. Вывести список самых свежих фильмов. В список должны войти все фильмы последнего года выпуска, имеющиеся в базе данных. Запрос должен быть универсальным, не зависящим от исходных данных (нужный год выпуска должен определяться в запросе, а не жестко задаваться)."
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "SELECT * FROM movies WHERE year = (SELECT MAX(year) FROM movies)"
echo " "

echo "6. Найти все драмы, выпущенные после 2005 года, которые понравились женщинам (оценка не ниже 4.5). Для каждого фильма в этом списке вывести название, год выпуска и количество таких оценок. Результат отсортировать по году выпуска и названию фильма."
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "SELECT title, year, COUNT(title) as number_ratings FROM users u JOIN movies m JOIN ratings r WHERE u.id = r.user_id AND m.id = r.movie_id AND m.year>2005 AND u.gender='female' AND r.rating >= 4.5 AND m.genres LIKE '%Drama%' GROUP BY m.title ORDER BY year, title"
echo " "

echo "7. Провести анализ востребованности ресурса - вывести количество пользователей, регистрировавшихся на сайте в каждом году. Найти, в каких годах регистрировалось больше всего и меньше всего пользователей."
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "SELECT STRFTIME('%Y', register_date) as year, COUNT(STRFTIME('%Y', register_date)) as count FROM users GROUP BY year"
sqlite3 movies_rating.db -box -echo "SELECT year, max(count) as max FROM (SELECT STRFTIME('%Y', register_date) as year, COUNT(STRFTIME('%Y', register_date)) as count FROM users GROUP BY year)"
sqlite3 movies_rating.db -box -echo "SELECT year, min(count) as min FROM (SELECT STRFTIME('%Y', register_date) as year, COUNT(STRFTIME('%Y', register_date)) as count FROM users GROUP BY year)"
echo " "
