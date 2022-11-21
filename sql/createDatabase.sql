CREATE DATABASE BMIS_DB;
USE BMIS_DB;

CREATE TABLE school_years(
    school_year varchar(9) not null UNIQUE,
    isActive boolean,

    PRIMARY KEY (school_year)
);
CREATE TABLE Students(
    lrn varchar(12) NOT NULL UNIQUE,
    first_name varchar(50) NOT NULL,
    middle_name varchar(50),
    last_name varchar(50) NOT NULL,
    suffix varchar(2),
    gender varchar(6) NOT NULL,
    birth_date date NOT NULL,
    birth_place varchar(100) NOT NULL,
    contact_number varchar(11) NOT NULL,
    email varchar(255) NOT NULL,
    grade_level int NOT NULL,
    house_address varchar(255) NOT NULL,
    barangay varchar(255) NOT NULL,
    city varchar(255) NOT NULL,
    province varchar(255) NOT NULL,
    last_school varchar(255) NOT NULL,
    last_school_address varchar(255) NOT NULL,
    student_picture varchar(255) NOT NULL,
    report_card varchar(255) NOT NULL,
    birth_certificate varchar(255) NOT NULL,
    isActive boolean,

    PRIMARY KEY (lrn)
);
CREATE TABLE Parent_Information(
    student_lrn varchar(12) NOT NULL UNIQUE,
    parent_name varchar(255) NOT NULL,
    parent_contact varchar(11) NOT NULL,
    parent_relationship varchar(50),
    
    FOREIGN KEY (student_lrn) REFERENCES Students(lrn)
);
CREATE TABLE Enrollees(
    student_lrn varchar(12) NOT NULL UNIQUE,
    FOREIGN KEY (student_lrn) REFERENCES Students(lrn)
)