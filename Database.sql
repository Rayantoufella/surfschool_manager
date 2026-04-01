CREATE table user (
                      id int primary key auto_increment ,
                      name varchar(255) ,
                      email varchar(255),
                      password varchar(255),
                      role enum('admin','user') default 'user' ,
                      created_at_user datetime default current_timestamp()
);



create table student (
                         id int primary key auto_increment ,
                         country varchar(200) ,
                         level enum('Debut','intermediate' ,'advanced') ,
                         created_at_student datetime default current_timestamp(),

                         user_id int ,
                         foreign key (user_id) references user(id)
);

create table enroll
(
    id                int primary key auto_increment,
    status            enum ('paid' , 'pending'),
    created_at_enroll datetime default current_timestamp(),
    student_id        int,
    foreign key (student_id) references student (id) ,
    lesson_id         int,
    foreign key (lesson_id) references lesson (id)
);


create table lesson (
                        id int primary key auto_increment ,
                        title varchar(200) ,
                        coach varchar(200) ,
                        created_at_lessons datetime default current_timestamp() ,
                        capacity int
)