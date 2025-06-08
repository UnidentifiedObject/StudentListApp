# StudentListApp
A simple management web app to Add, Delete, Search and Edit students.


I made this web app Using Php, Html, Css and MySQL.
If you wanna use this, You must Create a MySQL database and a students table with the following structure:

CREATE TABLE students (
    number INT PRIMARY KEY,
    names VARCHAR(255) NOT NULL
);


Features:

-Add new students with student number and name

-Edit existing student details

-Delete students by their student number

-Search for students by student number

-Display a list of all students

-Uses prepared statements for database security

-Simple and responsive design with CSS

# StudentlistApp

Ekleme, Silme, Düzenleme ve Arama yapabileceğiniz, Basit bir yönetim web uygulaması.

Bu web uygulamasını Php, Hmtl, Css ve MySql kullanarak yaptım.
Eğer kullanmak isterseniz, MySql veritabanı oluşturup, içine "students" isimli bir tablo oluşturup, aşağıdaki kodu girmelisiniz:

CREATE TABLE students (
    number INT PRIMARY KEY,
    names VARCHAR(255) NOT NULL
);


Özellikler:

-Numara ve isimleri ile yeni öğrenci ekleyin.

-Mevcut öğrenci bilgilerini düzenleyin.

-Öğrenci numaraları ile öğrencileri silin.

-Öğrenci numaraları ile Öğrencileri bulun.

-Tüm öğrencilerin listesini görüntüleyin.

-Basit ve kullanışlı bir tasarım.

