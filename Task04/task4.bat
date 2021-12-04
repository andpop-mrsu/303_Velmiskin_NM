#!binbash
chcp 65001

sqlite3 movies_rating.db  db_init.sql

echo 1. Найти все пары пользователей, оценивших один и тот же фильм. Устранить дубликаты, проверить отсутствие пар с самим собой. Для каждой пары должны быть указаны имена пользователей и название фильма, который они ценили.
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo SELECT DISTINCT t1.name, t2.name, t1.title FROM (SELECT u.name, m.title FROM ratings r INNER JOIN users u ON r.user_id = u.id INNER JOIN  movies m  ON r.movie_id = m.id) AS t1 JOIN (SELECT u.name, m.title FROM ratings r INNER JOIN users u ON r.user_id = u.id INNER JOIN  movies m  ON r.movie_id = m.id) AS t2 ON t1.title=t2.title WHERE t1.namet2.name ORDER BY t1.title, t1.name, t2.name
echo  

echo 2. Найти 10 самых свежих оценок от разных пользователей, вывести названия фильмов, имена пользователей, оценку, дату отзыва в формате ГГГГ-ММ-ДД.
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo SELECT m.title, u.name, r.rating, strftime(%Y-%m-%d, r.timestamp, 'unixepoch') AS date_col FROM ratings r INNER JOIN users u ON r.user_id = u.id INNER JOIN  movies m  ON r.movie_id = m.id GROUP BY u.name ORDER BY r.timestamp DESC LIMIT 10

echo 3. Вывести в одном списке все фильмы с максимальным средним рейтингом и все фильмы с минимальным средним рейтингом. Общий список отсортировать по году выпуска и названию фильма. В зависимости от рейтинга в колонке Рекомендуем для фильмов должно быть написано Да или Нет.
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo SELECT title, year, case when  max_rating = avg_rating then 'Yes' else 'No' end as recommendation FROM (SELECT title, year, AVG(r.rating) AS avg_rating, MAX(AVG(r.rating)) OVER() as max_rating, MIN(AVG(r.rating)) OVER() AS min_rating FROM ratings r JOIN movies m ON r.movie_id = m.id GROUP BY r.movie_id) t1 WHERE avg_rating = max_rating OR avg_rating = min_rating ORDER BY year, title

echo 4. Вычислить количество оценок и среднюю оценку, которую дали фильмам пользователи-женщины в период с 2010 по 2012 год.
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo SELECT COUNT() AS r_count, ROUND(AVG(r.rating), 1) AS r_average FROM ratings r JOIN users u ON r.user_id = u.id WHERE u.gender = 'female' AND strftime(%Y-%m-%d, r.timestamp, 'unixepoch') BETWEEN '2010-01-01' AND '2012-01-01'

echo 5. Составить список фильмов с указанием их средней оценки и места в рейтинге по средней оценке. Полученный список отсортировать по году выпуска и названиям фильмов. В списке оставить первые 20 записей.
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo SELECT title, year,  ROUND(AVG(r.rating), 2) AS avg_r, RANK() OVER(ORDER BY AVG(r.rating) DESC) as rating_position FROM movies m JOIN ratings r ON m.id = r.movie_id GROUP BY m.id ORDER BY year, title LIMIT 20

echo 6. Вывести список из 10 последних зарегистрированных пользователей в формате Фамилия ИмяДата регистрации (сначала фамилия, потом имя).
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo SELECT (substr(name, instr(name, ' ') + 1)  ' '  substr(name, 1, instr(name, ' ')  - 1)) AS user_name, register_date FROM users ORDER BY register_date DESC LIMIT 10

echo 7. С помощью рекурсивного CTE составить таблицу умножения для чисел от 1 до 10.
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo WITH RECURSIVE multiple_table(i, str) AS (SELECT 1, '1x1=1' UNION ALL SELECT i + 1, CAST(i  10 + 1 AS text)  'x'  CAST(i % 10 + 1 AS text)  '='  CAST((i  10 + 1)  (i % 10 + 1) AS text) FROM multiple_table WHERE i  100) SELECT str FROM multiple_table

echo 8. С помощью рекурсивного CTE выделить все жанры фильмов, имеющиеся в таблице movies (каждый жанр в отдельной строке).
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo WITH RECURSIVE all_genres(genres, str) AS (SELECT '', movies.genres  '' FROM movies UNION ALL SELECT substr(str, 0, instr(str, '')), substr(genres, instr(genres, '') + 1) FROM all_genres WHERE str != '') SELECT genres FROM all_genres WHERE genres != '' GROUP BY genres