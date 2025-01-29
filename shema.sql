CREATE TABLE categories
(
    id   SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE employees
(
    id          SERIAL PRIMARY KEY,
    name        VARCHAR(255) NOT NULL,
    phone       VARCHAR(20),
    email       VARCHAR(255),
    category_id INTEGER,
    FOREIGN KEY (category_id) REFERENCES categories (id)
);

CREATE TABLE tasks
(
    id          SERIAL PRIMARY KEY,
    employee_id INTEGER,
    name        VARCHAR(255) NOT NULL,
    worktime    INTEGER,
    FOREIGN KEY (employee_id) REFERENCES employees (id)
);