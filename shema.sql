CREATE TABLE categories
(
    id   SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE employees
(
    id          SERIAL PRIMARY KEY,
    name        VARCHAR(255) NOT NULL,
    phone       VARCHAR(20) NOT NULL,
    email       VARCHAR(255) NOT NULL,
    category_id INTEGER NOT NULL,
    FOREIGN KEY (category_id) REFERENCES categories (id)
);

CREATE TABLE tasks
(
    id          SERIAL PRIMARY KEY,
    employee_id INTEGER NOT NULL,
    name        VARCHAR(255) NOT NULL,
    worktime    INTEGER DEFAULT 0,
    FOREIGN KEY (employee_id) REFERENCES employees (id)
);

--Test data
INSERT INTO categories (name)
VALUES ('Разработка программного обеспечения'),
       ('Дизайн'),
       ('Маркетинг'),
       ('Управление проектами'),
       ('Поддержка клиентов');

INSERT INTO employees (name, phone, email, category_id)
VALUES ('Иван', '89123456789', 'ivan@mail.com', 1),
       ('Мария', '89034567890', 'maria@gmail.com', 2),
       ('Алексей', '89154321678', 'alex@mail.com', 3),
       ('Елена', '89265478901', 'elena@mail.com', 1),
       ('Андрей', '89053456789', 'andrey@mail.com', 4),
       ('Анна', '89147654321', 'anna@mail.com', 2);

INSERT INTO tasks (employee_id, name, worktime)
VALUES (1, 'Разработка нового модуля', 120),
       (2, 'Дизайн мобильного приложения', 90),
       (3, 'Анализ рынка конкурент��в', 60),
       (4, 'Управление проектом X', 150),
       (1, 'Исправление ошибок в коде', 45),
       (5, 'Поддержка клиентов по электронной почте', 30),
       (6, 'Создание макетов для сайта', 75);