CREATE DATABASE StudentRegistrationDB;
GO

USE StudentRegistrationDB;
GO

CREATE TABLE Programs
(
    ProgramId   INT IDENTITY(1,1)
                CONSTRAINT PK_Programs PRIMARY KEY,
    ProgramCode VARCHAR(20) NOT NULL
                CONSTRAINT UQ_Programs_ProgramCode UNIQUE,
    ProgramName VARCHAR(100) NOT NULL,
    IsActive    BIT NOT NULL
                CONSTRAINT DF_Programs_IsActive DEFAULT 1,
    CreatedAt   DATETIME2 NOT NULL
                CONSTRAINT DF_Programs_CreatedAt DEFAULT SYSDATETIME()
);
GO

INSERT INTO Programs (ProgramCode, ProgramName)
VALUES
('TI',  'Teknik Informatika'),
('SI',  'Sistem Informasi'),
('MNJ', 'Manajemen'),
('TE',  'Teknik Elektro'),
('DKV', 'Desain Komunikasi Visual');
GO

CREATE TABLE Students
(
    StudentId   INT IDENTITY(1,1)
                CONSTRAINT PK_Students PRIMARY KEY,
    NIM         VARCHAR(20) NOT NULL
                CONSTRAINT UQ_Students_NIM UNIQUE,
    Name        VARCHAR(100) NOT NULL,
    ProgramId   INT NOT NULL,
    BirthDate   DATE NULL,
    Address     VARCHAR(250) NULL,
    PhoneNumber VARCHAR(20) NULL,
    CreatedAt   DATETIME2 NOT NULL
                CONSTRAINT DF_Students_CreatedAt DEFAULT SYSDATETIME(),
    UpdatedAt   DATETIME2 NULL,
    CONSTRAINT FK_Students_Programs
        FOREIGN KEY (ProgramId) REFERENCES Programs(ProgramId)
);
GO

INSERT INTO Students (NIM, Name, ProgramId, BirthDate, Address, PhoneNumber)
VALUES
('20231001', 'Ahmad Rizki',   1, '2003-03-12', 'Jl. Merdeka No. 123, Surabaya',   '081234567890'),
('20231002', 'Siti Aisyah',   2, '2004-07-21', 'Jl. Diponegoro No. 45, Surabaya', '082233445566'),
('20231003', 'Budi Santoso',  1, '2003-11-05', 'Jl. Ahmad Yani No. 10, Surabaya', '081355667788'),
('20231004', 'Citra Lestari', 3, '2004-01-18', 'Jl. Darmo No. 20, Surabaya',      '089900112233'),
('20231005', 'Dimas Prayoga', 4, '2003-09-27', 'Jl. Raya ITS, Surabaya',          '081288776655');
GO

SELECT * FROM Students;

DELETE FROM Students;
GO

INSERT INTO Students (NIM, Name, ProgramId, BirthDate, Address, PhoneNumber)
VALUES
('20241011', 'Raka Pratama', 1, '2004-02-15', 'Jl. Kenanga No. 12, Surabaya', '081267891234'),
('20241012', 'Nadia Permata', 2, '2004-06-08', 'Jl. Mawar No. 27, Surabaya', '082178945623'),
('20241013', 'Fajar Maulana', 1, '2003-12-19', 'Jl. Melati No. 8, Surabaya', '085612347890'),
('20241014', 'Alya Safitri', 3, '2004-04-23', 'Jl. Cempaka No. 31, Surabaya', '089512678934'),
('20241015', 'Rizky Aditya', 4, '2003-10-11', 'Jl. Anggrek No. 16, Surabaya', '081398765421');
GO

SELECT * FROM Students;

DELETE FROM Students;
DBCC CHECKIDENT ('Students', RESEED, 0);
GO