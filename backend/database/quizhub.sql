CREATE DATABASE IF NOT EXISTS quizhub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE quizhub;

DROP TABLE IF EXISTS attempts;
DROP TABLE IF EXISTS answers;
DROP TABLE IF EXISTS questions;
DROP TABLE IF EXISTS quizzes;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin','user') NOT NULL DEFAULT 'user',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE quizzes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(150) NOT NULL,
  description TEXT,
  category_id INT NOT NULL,
  created_by INT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (category_id) REFERENCES categories(id),
  FOREIGN KEY (created_by) REFERENCES users(id)
) ENGINE=InnoDB;

CREATE TABLE questions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  quiz_id INT NOT NULL,
  text TEXT NOT NULL,
  FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE answers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  question_id INT NOT NULL,
  text VARCHAR(255) NOT NULL,
  is_correct BOOLEAN NOT NULL DEFAULT FALSE,
  FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE attempts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  quiz_id INT NOT NULL,
  score INT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Sample data (both test users have the password Test1234!)
INSERT INTO users (name, email, password_hash, role) VALUES
('Admin User', 'admin@example.com', '$2y$10$6oNzkRZKP2BR8iWu8kDULeGSo/cPKq993JdMhTTwggW.izVqaljCm', 'admin'),
('Test User', 'test@example.com', '$2y$10$6oNzkRZKP2BR8iWu8kDULeGSo/cPKq993JdMhTTwggW.izVqaljCm', 'user');

INSERT INTO categories (name) VALUES ('Science'), ('History'), ('Sports');

INSERT INTO quizzes (title, description, category_id, created_by) VALUES
('Space Basics', 'Questions about planets and stars.', 1, 1),
('World War II', 'Questions about key events.', 2, 1),
('Football Legends', 'Questions about football.', 3, 1);

INSERT INTO questions (quiz_id, text) VALUES
(1, 'Which planet is closest to the Sun?'),
(1, 'Which is the largest planet in the Solar System?'),
(2, 'In which year did World War II end?'),
(2, 'Which city was the capital of the Roman Empire?'),
(3, 'How many players does one team have on the field in football?'),
(3, 'Which country won the 2018 FIFA World Cup?');

INSERT INTO answers (question_id, text, is_correct) VALUES
(1, 'Venus', FALSE), (1, 'Mercury', TRUE), (1, 'Mars', FALSE), (1, 'Earth', FALSE),
(2, 'Saturn', FALSE), (2, 'Neptune', FALSE), (2, 'Jupiter', TRUE), (2, 'Uranus', FALSE),
(3, '1943', FALSE), (3, '1944', FALSE), (3, '1945', TRUE), (3, '1946', FALSE),
(4, 'Athens', FALSE), (4, 'Rome', TRUE), (4, 'Paris', FALSE), (4, 'Cairo', FALSE),
(5, '9', FALSE), (5, '10', FALSE), (5, '11', TRUE), (5, '12', FALSE),
(6, 'Croatia', FALSE), (6, 'Brazil', FALSE), (6, 'Germany', FALSE), (6, 'France', TRUE);

INSERT INTO attempts (user_id, quiz_id, score) VALUES
(2, 1, 2), (2, 2, 1), (2, 3, 2);