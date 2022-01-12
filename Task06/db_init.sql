DROP TABLE IF EXISTS students;
DROP TABLE IF EXISTS specialty;
DROP TABLE IF EXISTS admission;
DROP TABLE IF EXISTS groups;
DROP TABLE IF EXISTS subjects;
DROP TABLE IF EXISTS subject_specialty;
DROP TABLE IF EXISTS session_results;

CREATE TABLE students(
	id INTEGER PRIMARY KEY, 
	surname TEXT NOT NULL, 
	name TEXT NOT NULL, 
	patronymic TEXT, 
	birthday DATE NOT NULL, 
	gender TEXT NOT NULL
);

INSERT INTO students(id, surname, name, patronymic, birthday, gender) VALUES
(1, "Акишев", "Даниил", "Витальевич", "2000-01-01", "male"),
(2, "Вельмискин", "Николай", "Михайлович", "2000-02-01", "male"),
(3, "Видяйкин", "Илья", "Александрович", "2001-05-01", "male"),
(4, "Гладышева", "Дарья", "Николаевна", "2000-03-01", "female"),
(5, "Гуськова", "Ирина", "Михайловна", "2001-05-05", "female"),
(6, "Дудоров", "Данила", "Викторович", "2000-04-01", "male"),
(7, "Заварюхина", "Юлия", "Викторовна", "2001-05-10", "female"),
(8, "Иншакова", "Анастасия", "Сергеевна", "2000-05-01", "female"),
(9, "Кулагин", "Павел", "Альбертович", "2001-05-20", "male"),
(10, "Максимов", "Степан", "Олегович", "2000-06-01", "male"),
(11, "Никулов", "Илья", "Алексеевич", "2001-05-16", "male"),
(12, "Осипов", "Даниил", "Александрович", "2000-07-01", "male"),
(13, "Паршин", "Дмитрий", "Иванович", "2001-06-10", "male"),
(14, "Потапкина", "Юлия", "Юрьевна", "2000-08-01", "female"),
(15, "Родькина", "Дарья", "Александровна", "2001-06-15", "female"),
(16, "Рузаева", "Алина", "Семеновна", "2000-09-01", "female"),
(17, "Светильников", "Данил", "Борисович", "2000-10-01", "male"),
(18, "Тайнов", "Александр", "Александрович", "2001-06-23", "male"),
(19, "Уткин", "Никита", "Витальевич", "2000-11-01", "male"),
(20, "Шабанов", "Данила", "Олегович", "2001-10-12", "male");

CREATE TABLE specialty(
	id INTEGER PRIMARY KEY,
	title TEXT NOT NULL
);

INSERT INTO specialty(id, title) VALUES 
(1, "Математика и компьютерные науки"),
(2, "Фундаментальная информатика и информационные технологии"),
(3, "Прикладная математика и информатика"),
(4, "Программная инженерия");

CREATE TABLE admission(
	id INTEGER PRIMARY KEY,
	student_id INTEGER NOT NULL,
	specialty_id INTEGER NOT NULL,
	date DATE NOT NULL,
	FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
	FOREIGN KEY (specialty_id) REFERENCES specialty(id) ON DELETE CASCADE
);

INSERT INTO admission(id, student_id, specialty_id, date) VALUES
(1, 1, 1, '2021-09-01'),
(2, 2, 2, '2021-09-01'),
(3, 3, 3, '2021-09-01'),
(4, 4, 4, '2021-09-01'),
(5, 5, 1, '2021-09-01'),
(6, 6, 2, '2020-09-01'),
(7, 7, 3, '2020-09-01'),
(8, 8, 4, '2020-09-01'),
(9, 9, 1, '2020-09-01'),
(10, 10, 2, '2020-09-01'),
(11, 11, 3, '2019-09-01'),
(12, 12, 4, '2019-09-01'),
(13, 13, 1, '2019-09-01'),
(14, 14, 2, '2019-09-01'),
(15, 15, 3, '2019-09-01'),
(16, 16, 4, '2018-09-01'),
(17, 17, 1, '2018-09-01'),
(18, 18, 2, '2018-09-01'),
(19, 19, 3, '2018-09-01'),
(20, 20, 4, '2018-09-01');

CREATE TABLE groups(
	id INTEGER PRIMARY KEY,
	student_id INTEGER NOT NULL,
	specialty_id INTEGER NOT NULL,
	group_on_course INTEGER NOT NULL,
	semester INTEGER NOT NULL CHECK(semester = 1 OR semester = 2),
	FOREIGN KEY (student_id) REFERENCES admission(student_id) ON DELETE CASCADE,
	FOREIGN KEY (specialty_id) REFERENCES admission(specialty_id) ON DELETE CASCADE	
);

INSERT INTO groups(student_id, specialty_id, group_on_course, semester) 
SELECT student_id, specialty_id, CASE WHEN CAST(CAST(CAST(ROUND((julianday('now') - julianday(date))/360 + 1) AS INTEGER)AS TEXT) ||'0'|| CAST(specialty_id AS TEXT) AS INTEGER) > 404 THEN CAST('40'|| CAST(specialty_id AS TEXT) AS INTEGER) ELSE CAST(CAST(CAST(ROUND((julianday('now') - julianday(date))/360 + 1) AS INTEGER) AS TEXT) ||'0'|| CAST(specialty_id AS TEXT) AS INTEGER) END, CASE WHEN CAST(STRFTIME('%m', DATE('now')) AS INTEGER) >= 9 AND CAST(STRFTIME('%m', DATE('now')) AS INTEGER) <= 12 THEN 1 ELSE 2 END FROM admission;

CREATE TABLE subjects(
	id INTEGER PRIMARY KEY,
	subject TEXT NOT NULL,
	type_of_certification TEXT NOT NULL CHECK(type_of_certification = 'зачет' OR type_of_certification = 'экзамен'),
	hours_study INTEGER NOT NULL,
	course INTEGER NOT NULL,
	semester INTEGER NOT NULL CHECK(semester = 1 OR semester = 2) 
);

INSERT INTO subjects(id, subject, type_of_certification, hours_study, course, semester) VALUES
(1, 'История', 'экзамен', 144, 1, 1),
(2, 'Аналитическая геометрия', 'экзамен', 144, 1, 1),
(3, 'Математический анализ-I', 'зачет', 180, 1, 1),
(4, 'Алгебра и геометрия', 'зачет', 180, 1, 1),
(5, 'Алгебра и геометрия', 'экзамен', 180, 1, 2),
(6, 'Основы программирования', 'экзамен', 144, 1, 2),
(7, 'Математический анализ-II', 'зачет', 180, 1, 2),
(8, 'Дискретная математика', 'экзамен', 144, 2, 1),
(9, 'Дифференциальные уравнения', 'зачет', 144, 2, 1),
(10, 'Дифференциальные уравнения', 'экзамен', 144, 2, 2),
(11, 'Комплексный анализ', 'экзамен', 180, 2, 2),
(12, 'Теория автоматов и формальных языков', 'зачет', 108, 2, 2),
(13, 'Математическая логика и теория алгоритмов', 'экзамен', 180, 3, 1),
(14, 'Функциональный анализ', 'экзамен', 180, 3, 1),
(15, 'Физика', 'зачет', 108, 3, 1),
(16, 'Вычислительные методы', 'экзамен', 108, 4, 1);

CREATE TABLE subject_specialty (
	id INTEGER PRIMARY KEY,
	specialty_id INTEGER NOT NULL,
	subject_id INTEGER NOT NULL,
	FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE,
	FOREIGN KEY (specialty_id) REFERENCES specialty(id) ON DELETE CASCADE
);

INSERT INTO subject_specialty(id, specialty_id, subject_id) VALUES
(1, 1, 1),
(2, 1, 5),
(3, 1, 9),
(4, 1, 13),
(5, 2, 2),
(6, 2, 6),
(7, 2, 10),
(8, 2, 14),
(9, 3, 3),
(10, 3, 7),
(11, 3, 11),
(12, 3, 15),
(13, 4, 4),
(14, 4, 8),
(15, 4, 12),
(16, 4, 16);


CREATE TABLE session_results(
	id INTEGER PRIMARY KEY,
	student_id INTEGER NOT NULL,
	subject_id INTEGER NOT NULL,
	point INTEGER CHECK(point <= 100 AND point >= 0),
	FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
	FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE
);

INSERT INTO session_results(id, student_id, subject_id, point) VALUES
(1,6,2,53),
(2,6,6,96),
(3,7,1,89),
(4,7,3,64),
(5,7,7,84),
(6,8,4,54),
(7,9,1,93),
(8,9,5,93),
(9,10,2,42),
(10,10,6,54),
(11,11,3,86),
(12,11,7,91),
(13,11,11,100);