create database oc;
	use oc;

create table teacher(
	teacher_id int(100) not null auto_increment,
	first_name varchar(100) not null,
	last_name varchar(100) not null,
	username varchar(100) not null,
	email_address varchar(100) not null,
	password varchar(100) not null,
	primary key(teacher_id)
);

create table teaches(
	teacher_id int(100) not null,
	student_id int(100) not null
);

create table student(
	student_id int(100) not null auto_increment,
	first_name varchar(100) not null,
	last_name varchar(100) not null,
	username varchar(100) not null,
	email_address varchar(100) not null,
	password varchar(100) not null,
	primary key(student_id)
);

create table enrolls (
	student_id int(100) not null,
	subject_id int(100) not null
);

create table subject(
	subject_id int(100) not null auto_increment,
	subject_code varchar(100) not null,
	course_title varchar(100) not null,
	course_description varchar(100) not null,
	course_about varchar(100) not null,
	teacher_id int(100) not null,
	primary key(subject_id),
	foreign key(teacher_id) references teacher(teacher_id)
);

create table classrecord(
	subject_id int(100) not null,
	student_id int(100) not null,
	assignment_assignment int(100) not null,
	quiz_number int(100) not null,
	score int(100) not null,
	total int(100) not null,
	foreign key(subject_id) references subject(subject_id),
	foreign key(student_id) references student(student_id)
);

create table learning_materials(
	subject_id int(100) not null,
	lecture_number int(100) not null,
	title varchar(100) not null,
	date_posted timestamp not null,
	file blob not null,
	foreign key(subject_id) references subject(subject_id)
);

create table announcement(
	announcement_id int(100) not null auto_increment,
	subject_id int(100) not null,
	date_posted timestamp not null,
	title varchar(100) not null,
	content varchar(1000) not null,
	primary key(announcement_id),
	foreign key(subject_id) references subject(subject_id)
);

create table announcement_comment(
	id int(100) not null auto_increment,
	announcement_id int(100) not null,
	student_id int(100) not null,
	teacher_id int(100) not null,
	content varchar(1000) not null,
	date_posted timestamp not null,
	primary key(id),
	foreign key(announcement_id) references announcement(announcement_id)
	-- foreign key(student_id) references student(student_id)
);

create table assignment(
	assignment_id int(100) not null auto_increment,
	subject_id int(100) not null,
	date_posted timestamp not null,
	deadline_date date not null,
	deadline_time time not null,
	title varchar(100) not null,
	instruction varchar(1000) not null,
	file blob not null,
	primary key(assignment_id),
	foreign key(subject_id) references subject(subject_id)
);

create table quiz(
	quiz_id int(100) not null auto_increment,
	subject_id int(100) not null,
	primary key(quiz_id),
	foreign key(subject_id) references subject(subject_id)
);

create table identification_quiz(
	identification_id int(100) not null auto_increment,
	subject_id int(100) not null,
	quiz_id int(100) not null,
	date_posted datetime not null default CURRENT_TIMESTAMP,
	deadline_date date not null,
	deadline_time time not null,
	question_number int(100) not null,
	question varchar(100) not null,
	answer int(100) not null,
	primary key(identification_id),
	foreign key(subject_id) references subject(subject_id),
	foreign key(quiz_id) references quiz(quiz_id)
);

create table multiplechoice_quiz(
	multiplechoice_id int(100) not null auto_increment,
	subject_id int(100) not null,
	quiz_id int(100) not null,
	date_posted datetime not null default CURRENT_TIMESTAMP,
	deadline_date date not null,
	deadline_time time not null,
	question_number int(100) not null,
	question varchar(100) not null,
	answer varchar(100) not null,
	primary key(multiplechoice_id),
	foreign key(subject_id) references subject(subject_id),
	foreign key(quiz_id) references quiz(quiz_id)
);

create table multiplechoice_choices(
	multiplechoice_id int(100) not null,
	subject_id int(100) not null,
	quiz_id int(100) not null,
	option varchar(1000) not null,
	foreign key(multiplechoice_id) references multiplechoice_quiz(multiplechoice_id),
	foreign key(quiz_id) references quiz(quiz_id)
);

create table multipleanswer_quiz(
	multipleanswer_id int(100) not null auto_increment,
	subject_id int(100) not null,
	quiz_id int(100) not null,
	date_posted datetime not null default CURRENT_TIMESTAMP,
	deadline_date date not null,
	deadline_time time not null,
	question_number int(100) not null,
	question varchar(1000) not null,
	primary key(multipleanswer_id),
	foreign key(subject_id) references subject(subject_id),
	foreign key(quiz_id) references quiz(quiz_id)
);

create table multipleanswer_choices(
	multipleanswer_id int(100) not null,
	subject_id int(100) not null,
	quiz_id int(100) not null,
	option varchar(1000) not null,
	foreign key(multipleanswer_id) references multipleanswer_quiz(multipleanswer_id),
	foreign key(quiz_id) references quiz(quiz_id)
);

create table multipleanswer_answers(
	multipleanswer_id int(100) not null,
	subject_id int(100) not null,
	quiz_id int(100) not null,
	answer varchar(1000) not null,
	foreign key(multipleanswer_id) references multipleanswer_quiz(multipleanswer_id),
	foreign key(quiz_id) references quiz(quiz_id)
);