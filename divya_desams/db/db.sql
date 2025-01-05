CREATE DATABASE divya_desams_108;

USE divya_desams_108;

-- Table for storing details of Divya Desams
CREATE TABLE divya_desam (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    location VARCHAR(255),
    description TEXT,
    latitude FLOAT,
    longitude FLOAT,
    image VARCHAR(255),
    gamification_points INT DEFAULT 0
);

-- Table for storing user details
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL, -- store encrypted password
    points INT DEFAULT 0
);

-- Table for storing user planner data (temples they plan to visit)
CREATE TABLE planner (
    user_id INT,
    temple_id INT,
    planned_date DATE,
    PRIMARY KEY (user_id, temple_id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (temple_id) REFERENCES divya_desam(id)
);

-- Table for storing temples a user has already visited
CREATE TABLE visited (
    user_id INT,
    temple_id INT,
    visit_date DATE,
    PRIMARY KEY (user_id, temple_id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (temple_id) REFERENCES divya_desam(id)
);
-- Insert Data into divya_desam table

INSERT INTO divya_desam (name, location, description, latitude, longitude, image, gamification_points) 
VALUES 
('Sri Ranganathaswamy Temple', 'Srirangam, Tamil Nadu', 'One of the most famous and revered Divya Desams, dedicated to Lord Ranganatha, a form of Lord Vishnu.', 10.8480, 78.7120, 'srirangam-temple.jpg', 0),
('Sri Parakala Mutt', 'Mysuru, Karnataka', 'The Parakala Mutt is one of the most important religious centers in South India, devoted to Lord Vishnu and His incarnations.', 12.2958, 76.6394, 'parakala-mutt.jpg', 0),
('Sri Ahobilam', 'Ahobilam, Andhra Pradesh', 'Ahobilam is known for the Ahobilam Narasimha Swamy temple, dedicated to Lord Narasimha, an incarnation of Lord Vishnu.', 14.1144, 78.3172, 'ahobilam-temple.jpg', 0),
('Sri Tirumala Venkateswara Temple', 'Tirumala, Andhra Pradesh', 'This temple is dedicated to Lord Venkateswara, a form of Vishnu, and is one of the most visited pilgrimage centers in the world.', 13.6288, 79.3944, 'tirumala-temple.jpg', 0),
('Sri Yadagirigutta Temple', 'Yadadri, Telangana', 'Dedicated to Lord Lakshmi Narasimha, this temple is one of the prominent Divya Desams and holds significant historical importance.', 17.5362, 78.9733, 'yadagirigutta-temple.jpg', 0),
('Sri Kanchipuram Varadaraja Perumal Temple', 'Kanchipuram, Tamil Nadu', 'This is a prominent temple dedicated to Lord Varadaraja Perumal, a form of Lord Vishnu, located in Kanchipuram.', 12.8315, 79.7081, 'kanchipuram-temple.jpg', 0),
('Sri Madurai Meenakshi Temple', 'Madurai, Tamil Nadu', 'This ancient temple is dedicated to Goddess Meenakshi, the consort of Lord Sundareswarar, and is a significant pilgrimage site.', 9.9196, 78.1198, 'madurai-meenakshi-temple.jpg', 0),
('Sri Badrinath Temple', 'Badrinath, Uttarakhand', 'The sacred temple dedicated to Lord Vishnu in his Badrinath incarnation is one of the four Char Dham pilgrimage sites in India.', 30.7343, 79.5061, 'badrinath-temple.jpg', 0),
('Sri Dwarka Temple', 'Dwarka, Gujarat', 'This temple is dedicated to Lord Krishna and is believed to be one of the four Dhams of Hinduism, located on the western coast of India.', 22.2390, 68.9778, 'dwarka-temple.jpg', 0),
('Sri Puri Jagannath Temple', 'Puri, Odisha', 'The Jagannath Temple is one of the most important and revered pilgrimage destinations in India, dedicated to Lord Jagannath, a form of Lord Vishnu.', 19.7983, 85.8198, 'puri-jagannath-temple.jpg', 0);
