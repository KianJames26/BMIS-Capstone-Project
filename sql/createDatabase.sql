CREATE DATABASE BMIS_DB;
USE BMIS_DB;

CREATE TABLE Students(
    lrn int NOT NULL UNIQUE,
    first_name varchar(50) NOT NULL,
    middle_name varchar(50),
    last_name varchar(50) NOT NULL,
    suffix varchar(2),
    gender varchar(6) NOT NULL,
    birth_date date NOT NULL,
    birth_place varchar(100) NOT NULL,
    contact_number int NOT NULL,
    email varchar(255) NOT NULL,
    grade_level int NOT NULL,
    section int,
    house_address varchar(255) NOT NULL,
    barangay varchar(255) NOT NULL,
    city varchar(255) NOT NULL,
    province varchar(255) NOT NULL,
    last_school varchar(255) NOT NULL,
    last_school_address varchar(255) NOT NULL,
    student_picture MEDIUMBLOB NOT NULL,
    report_card MEDIUMBLOB NOT NULL,
    birth_certificate MEDIUMBLOB NOT NULL,
    isOnline boolean,
    isEnrolled boolean,
    
    PRIMARY KEY (lrn)
);
CREATE TABLE Parent_Information(
    student_lrn int,
    parent_name varchar(255) NOT NULL,
    parent_contact int NOT NULL,
    parent_relationship varchar(50),
    
    FOREIGN KEY (student_lrn) REFERENCES Students(lrn)
)
