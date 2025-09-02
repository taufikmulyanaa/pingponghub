-- PingPong+ Database Schema
-- MySQL 8.0+ compatible

CREATE DATABASE IF NOT EXISTS pingpong_hub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE pingpong_hub;

-- 1. users
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    age INT,
    photo VARCHAR(500),
    location VARCHAR(255),
    online BOOLEAN DEFAULT FALSE,
    elo INT DEFAULT 0,
    skill ENUM('Divisi 1', 'Divisi 2', 'Divisi 3', 'Divisi 4', 'Divisi 5', 'Divisi 6', 'Divisi 7', 'Divisi 8', 'Divisi 9', 'Divisi 10'),
    style ENUM('Menyerang', 'Bertahan', 'All-round'),
    club_id INT,
    club_role ENUM('player', 'coach', 'admin') DEFAULT 'player',
    rating DECIMAL(3,2) DEFAULT 0.00,
    reviews INT DEFAULT 0,
    last_active VARCHAR(50),
    distance DECIMAL(5,2),
    availability VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (club_id) REFERENCES clubs(id) ON DELETE SET NULL
);

-- 2. user_stats
CREATE TABLE user_stats (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    matches INT DEFAULT 0,
    wins INT DEFAULT 0,
    win_rate INT DEFAULT 0,
    tournaments INT DEFAULT 0,
    rank INT DEFAULT 0,
    points INT DEFAULT 0,
    monthly_matches INT DEFAULT 0,
    avg_score DECIMAL(3,2) DEFAULT 0.00,
    club_matches INT DEFAULT 0,
    club_wins INT DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 3. user_equipment
CREATE TABLE user_equipment (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    blade VARCHAR(255),
    rubber_fh VARCHAR(255),
    rubber_bh VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 4. user_achievements
CREATE TABLE user_achievements (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    icon VARCHAR(50),
    date_achieved DATE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 5. user_preferences
CREATE TABLE user_preferences (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    play_time JSON,
    skill_range JSON,
    max_distance INT DEFAULT 10,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 6. clubs
CREATE TABLE clubs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    short_name VARCHAR(10),
    city VARCHAR(100),
    region VARCHAR(100),
    province VARCHAR(100),
    address TEXT,
    established YEAR,
    logo VARCHAR(500),
    description TEXT,
    members INT DEFAULT 0,
    active_members INT DEFAULT 0,
    coaches INT DEFAULT 0,
    rating DECIMAL(3,2) DEFAULT 0.00,
    reviews INT DEFAULT 0,
    verified BOOLEAN DEFAULT FALSE,
    team_ranking INT DEFAULT 0,
    recent_matches INT DEFAULT 0,
    win_rate INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 7. club_facilities
CREATE TABLE club_facilities (
    id INT PRIMARY KEY AUTO_INCREMENT,
    club_id INT NOT NULL,
    facility VARCHAR(255) NOT NULL,
    FOREIGN KEY (club_id) REFERENCES clubs(id) ON DELETE CASCADE
);

-- 8. club_photos
CREATE TABLE club_photos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    club_id INT NOT NULL,
    photo_url VARCHAR(500) NOT NULL,
    FOREIGN KEY (club_id) REFERENCES clubs(id) ON DELETE CASCADE
);

-- 9. club_achievements
CREATE TABLE club_achievements (
    id INT PRIMARY KEY AUTO_INCREMENT,
    club_id INT NOT NULL,
    achievement VARCHAR(255) NOT NULL,
    FOREIGN KEY (club_id) REFERENCES clubs(id) ON DELETE CASCADE
);

-- 10. club_contact
CREATE TABLE club_contact (
    id INT PRIMARY KEY AUTO_INCREMENT,
    club_id INT NOT NULL,
    phone VARCHAR(20),
    email VARCHAR(255),
    website VARCHAR(255),
    FOREIGN KEY (club_id) REFERENCES clubs(id) ON DELETE CASCADE
);

-- 11. club_membership
CREATE TABLE club_membership (
    id INT PRIMARY KEY AUTO_INCREMENT,
    club_id INT NOT NULL,
    type ENUM('monthly', 'yearly', 'student', 'youth') NOT NULL,
    price INT NOT NULL,
    FOREIGN KEY (club_id) REFERENCES clubs(id) ON DELETE CASCADE
);

-- 12. tournaments
CREATE TABLE tournaments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    date DATE,
    location VARCHAR(255),
    category VARCHAR(100),
    fee INT DEFAULT 0,
    participants INT DEFAULT 0,
    max_participants INT,
    status ENUM('Open', 'Full', 'Closed') DEFAULT 'Open',
    prize INT DEFAULT 0,
    organizer VARCHAR(255),
    description TEXT,
    type ENUM('individual', 'club') DEFAULT 'individual',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 13. tournament_rules
CREATE TABLE tournament_rules (
    id INT PRIMARY KEY AUTO_INCREMENT,
    tournament_id INT NOT NULL,
    rule VARCHAR(255) NOT NULL,
    FOREIGN KEY (tournament_id) REFERENCES tournaments(id) ON DELETE CASCADE
);

-- 14. tournament_schedule
CREATE TABLE tournament_schedule (
    id INT PRIMARY KEY AUTO_INCREMENT,
    tournament_id INT NOT NULL,
    round VARCHAR(100) NOT NULL,
    time VARCHAR(50) NOT NULL,
    FOREIGN KEY (tournament_id) REFERENCES tournaments(id) ON DELETE CASCADE
);

-- 15. venues
CREATE TABLE venues (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    distance DECIMAL(5,2),
    rating DECIMAL(3,2) DEFAULT 0.00,
    reviews INT DEFAULT 0,
    tables INT DEFAULT 0,
    type VARCHAR(100),
    price INT DEFAULT 0,
    price_unit VARCHAR(20) DEFAULT 'per jam',
    photo VARCHAR(500),
    open_hours VARCHAR(50),
    phone VARCHAR(20),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 16. venue_facilities
CREATE TABLE venue_facilities (
    id INT PRIMARY KEY AUTO_INCREMENT,
    venue_id INT NOT NULL,
    facility VARCHAR(255) NOT NULL,
    FOREIGN KEY (venue_id) REFERENCES venues(id) ON DELETE CASCADE
);

-- 17. marketplace
CREATE TABLE marketplace (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    price INT NOT NULL,
    condition ENUM('Baru', 'Baik', 'Seperti Baru') DEFAULT 'Baik',
    location VARCHAR(255),
    photo VARCHAR(500),
    seller_id INT NOT NULL,
    status ENUM('Tersedia', 'Terjual') DEFAULT 'Tersedia',
    category VARCHAR(100),
    brand VARCHAR(100),
    posted_date DATE,
    description_notes TEXT,
    meeting_point VARCHAR(255),
    reason VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (seller_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 18. marketplace_images
CREATE TABLE marketplace_images (
    id INT PRIMARY KEY AUTO_INCREMENT,
    marketplace_id INT NOT NULL,
    image_url VARCHAR(500) NOT NULL,
    FOREIGN KEY (marketplace_id) REFERENCES marketplace(id) ON DELETE CASCADE
);

-- 19. feed
CREATE TABLE feed (
    id INT PRIMARY KEY AUTO_INCREMENT,
    type ENUM('match_report', 'event', 'achievement', 'club_match_announce', 'club_recruitment', 'tournament_announce', 'training_tip') NOT NULL,
    user_id INT,
    club_id INT,
    time VARCHAR(50),
    content TEXT,
    image VARCHAR(500),
    likes INT DEFAULT 0,
    comments INT DEFAULT 0,
    score VARCHAR(10),
    opponent VARCHAR(255),
    venue VARCHAR(255),
    location VARCHAR(255),
    event_date DATE,
    event_time VARCHAR(20),
    max_players INT,
    current_players INT,
    badge VARCHAR(100),
    old_rating INT,
    new_rating INT,
    match_id INT,
    tournament_id INT,
    verified BOOLEAN DEFAULT FALSE,
    deadline DATE,
    prize INT,
    category VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (club_id) REFERENCES clubs(id) ON DELETE SET NULL,
    FOREIGN KEY (match_id) REFERENCES inter_club_matches(id) ON DELETE SET NULL,
    FOREIGN KEY (tournament_id) REFERENCES tournaments(id) ON DELETE SET NULL
);

-- 20. chats
CREATE TABLE chats (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    unread INT DEFAULT 0,
    last_message TEXT,
    time VARCHAR(20),
    last_active VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 21. notifications
CREATE TABLE notifications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    type ENUM('match_request', 'tournament', 'achievement') NOT NULL,
    from_user VARCHAR(255),
    message TEXT NOT NULL,
    time VARCHAR(50),
    read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 22. inter_club_matches
CREATE TABLE inter_club_matches (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    home_club_id INT,
    away_club_id INT,
    date DATE,
    time VARCHAR(20),
    venue VARCHAR(255),
    format VARCHAR(100),
    status ENUM('scheduled', 'registration_open', 'completed') DEFAULT 'scheduled',
    description TEXT,
    home_score INT DEFAULT 0,
    away_score INT DEFAULT 0,
    prize INT DEFAULT 0,
    max_clubs INT,
    entry_fee INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (home_club_id) REFERENCES clubs(id) ON DELETE SET NULL,
    FOREIGN KEY (away_club_id) REFERENCES clubs(id) ON DELETE SET NULL
);

-- 23. match_participants
CREATE TABLE match_participants (
    id INT PRIMARY KEY AUTO_INCREMENT,
    match_id INT NOT NULL,
    participant_name VARCHAR(255) NOT NULL,
    team ENUM('home', 'away') NOT NULL,
    FOREIGN KEY (match_id) REFERENCES inter_club_matches(id) ON DELETE CASCADE
);

-- 24. match_registered_clubs
CREATE TABLE match_registered_clubs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    match_id INT NOT NULL,
    club_id INT NOT NULL,
    FOREIGN KEY (match_id) REFERENCES inter_club_matches(id) ON DELETE CASCADE,
    FOREIGN KEY (club_id) REFERENCES clubs(id) ON DELETE CASCADE,
    UNIQUE KEY unique_match_club (match_id, club_id)
);

-- Indexes for Performance
CREATE INDEX idx_users_club_id ON users(club_id);
CREATE INDEX idx_users_location ON users(location);
CREATE INDEX idx_users_elo ON users(elo);
CREATE INDEX idx_users_online ON users(online);

CREATE INDEX idx_clubs_city ON clubs(city);
CREATE INDEX idx_clubs_province ON clubs(province);
CREATE INDEX idx_clubs_verified ON clubs(verified);
CREATE INDEX idx_clubs_team_ranking ON clubs(team_ranking);

CREATE INDEX idx_tournaments_date ON tournaments(date);
CREATE INDEX idx_tournaments_status ON tournaments(status);
CREATE INDEX idx_tournaments_type ON tournaments(type);

CREATE INDEX idx_venues_distance ON venues(distance);
CREATE INDEX idx_venues_rating ON venues(rating);

CREATE INDEX idx_marketplace_seller_id ON marketplace(seller_id);
CREATE INDEX idx_marketplace_status ON marketplace(status);
CREATE INDEX idx_marketplace_category ON marketplace(category);
CREATE INDEX idx_marketplace_price ON marketplace(price);

CREATE INDEX idx_feed_type ON feed(type);
CREATE INDEX idx_feed_user_id ON feed(user_id);
CREATE INDEX idx_feed_club_id ON feed(club_id);
CREATE INDEX idx_feed_created_at ON feed(created_at);

CREATE INDEX idx_chats_user_id ON chats(user_id);
CREATE INDEX idx_chats_unread ON chats(unread);

CREATE INDEX idx_notifications_type ON notifications(type);
CREATE INDEX idx_notifications_read ON notifications(read);
CREATE INDEX idx_notifications_created_at ON notifications(created_at);

CREATE INDEX idx_inter_club_matches_date ON inter_club_matches(date);
CREATE INDEX idx_inter_club_matches_status ON inter_club_matches(status);
CREATE INDEX idx_inter_club_matches_home_club ON inter_club_matches(home_club_id);
CREATE INDEX idx_inter_club_matches_away_club ON inter_club_matches(away_club_id);