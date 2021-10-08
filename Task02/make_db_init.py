import csv
import re

if __name__ == '__main__':
    with open('db_init.sql', 'w') as db_init:
        db_init.write(
            'DROP TABLE IF EXISTS movies;\n'
            'DROP TABLE IF EXISTS ratings;\n'
            'DROP TABLE IF EXISTS tags;\n'
            'DROP TABLE IF EXISTS users;\n'
            '\n'
        )

        db_init.write(
            'CREATE TABLE movies(\n'
            '\tid INTEGER PRIMARY KEY,\n'
            '\ttitle TEXT,\n'
            '\tyear INTEGER,\n'
            '\tgenres TEXT\n'
            ');\n'
            '\n'
            'CREATE TABLE ratings(\n'
            '\tid INTEGER PRIMARY KEY,\n'
            '\tuser_id INTEGER,\n'
            '\tmovie_id INTEGER,\n'
            '\trating REAL,\n'
            '\ttimestamp INTEGER\n'
            ');\n'
            '\n'
            'CREATE TABLE tags(\n'
            '\tid INTEGER PRIMARY KEY,\n'
            '\tuser_id INTEGER,\n'
            '\tmovie_id INTEGER,\n'
            '\ttag TEXT,\n'
            '\ttimestamp INTEGER\n'
            ');\n'
            '\n'
            'CREATE TABLE users(\n'
            '\tid INTEGER PRIMARY KEY,\n'
            '\tname TEXT,\n'
            '\temail TEXT,\n'
            '\tgender TEXT,\n'
            '\tregister_date TEXT,\n'
            '\toccupation TEXT\n'
            ');\n'
            '\n'
        )

        db_init.write(
            'INSERT INTO movies(id, title, year, genres)\n'
            'VALUES\n'
        )
        with open('movies.csv') as movies_file:
            movies_insert = ""
            reader = csv.DictReader(movies_file)
            for film in reader:
                movieId = film['movieId']
                title = film['title'].replace('"', '""').replace("'", "''")
                year = (lambda res: res.group(0) if res is not None else 'null')(re.search(r'\d{4}', film['title']))
                genres = film['genres']
                movies_insert += f"({movieId}, '{title}', {year}, '{genres}'),\n"
            db_init.write(movies_insert[:-2] + ';\n\n')

        db_init.write(
            'INSERT INTO ratings(id, user_id, movie_id, rating, timestamp)\n'
            'VALUES\n'
        )
        with open('ratings.csv') as ratings_file:
            ratings_insert = ""
            reader = csv.DictReader(ratings_file)
            for ratingId, rating_row in enumerate(reader):
                userId = rating_row['userId']
                movieId = rating_row['movieId']
                rating = rating_row['rating']
                timestamp = rating_row['timestamp']
                ratings_insert += f"({ratingId + 1}, {userId}, {movieId}, {rating}, {timestamp}),\n"
            db_init.write(ratings_insert[:-2] + ';\n\n')

        db_init.write(
            'INSERT INTO tags(id, user_id, movie_id, tag, timestamp)\n'
            'VALUES\n'
        )
        with open('tags.csv') as tags_file:
            tags_insert = ""
            reader = csv.DictReader(tags_file)
            for tagId, tag_row in enumerate(reader):
                userId = tag_row['userId']
                movieId = tag_row['movieId']
                tag = tag_row['tag'].replace('"', '""').replace("'", "''")
                timestamp = tag_row['timestamp']
                tags_insert += f"({tagId + 1}, {userId}, {movieId}, '{tag}', {timestamp}),\n"
            db_init.write(tags_insert[:-2] + ';\n\n')

        db_init.write(
            'INSERT INTO users(id, name, email, gender, register_date, occupation)\n'
            'VALUES\n'
        )
        with open('users.txt') as user_file:
            user_insert = ""
            for user in user_file.readlines():
                user = user.rstrip().replace('"', '""').replace("'", "''").split('|')
                userId = user[0]
                name = user[1]
                email = user[2]
                gender = user[3]
                register_date = user[4]
                occupation = user[5]
                user_insert += f"({userId}, '{name}', '{email}', '{gender}', '{register_date}', '{occupation}'),\n"
            db_init.write(user_insert[:-2] + ';')