# PingPong+ Database Schema

## Overview
This document contains the MySQL database schema for the PingPong+ application, designed based on the data structures found in `index (1).html`.

## Database Creation
```sql
CREATE DATABASE pingpong_plus CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE pingpong_plus;
```

## Tables

### 1. users
```sql
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    age INT,
    photo VARCHAR(500),
    location VARCHAR(255),
    online BOOLEAN DEFAULT FALSE,
    elo INT DEFAULT 0,
    skill ENUM('Pemula', 'Menengah', 'Mahir', 'Expert'),
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
```

### 2. user_stats
```sql
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
```

### 3. user_equipment
```sql
CREATE TABLE user_equipment (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    blade VARCHAR(255),
    rubber_fh VARCHAR(255),
    rubber_bh VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

### 4. user_achievements
```sql
CREATE TABLE user_achievements (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    icon VARCHAR(50),
    date_achieved DATE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

### 5. user_preferences
```sql
CREATE TABLE user_preferences (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    play_time JSON,
    skill_range JSON,
    max_distance INT DEFAULT 10,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

### 6. clubs
```sql
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
```

### 7. club_facilities
```sql
CREATE TABLE club_facilities (
    id INT PRIMARY KEY AUTO_INCREMENT,
    club_id INT NOT NULL,
    facility VARCHAR(255) NOT NULL,
    FOREIGN KEY (club_id) REFERENCES clubs(id) ON DELETE CASCADE
);
```

### 8. club_photos
```sql
CREATE TABLE club_photos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    club_id INT NOT NULL,
    photo_url VARCHAR(500) NOT NULL,
    FOREIGN KEY (club_id) REFERENCES clubs(id) ON DELETE CASCADE
);
```

### 9. club_achievements
```sql
CREATE TABLE club_achievements (
    id INT PRIMARY KEY AUTO_INCREMENT,
    club_id INT NOT NULL,
    achievement VARCHAR(255) NOT NULL,
    FOREIGN KEY (club_id) REFERENCES clubs(id) ON DELETE CASCADE
);
```

### 10. club_contact
```sql
CREATE TABLE club_contact (
    id INT PRIMARY KEY AUTO_INCREMENT,
    club_id INT NOT NULL,
    phone VARCHAR(20),
    email VARCHAR(255),
    website VARCHAR(255),
    FOREIGN KEY (club_id) REFERENCES clubs(id) ON DELETE CASCADE
);
```

### 11. club_membership
```sql
CREATE TABLE club_membership (
    id INT PRIMARY KEY AUTO_INCREMENT,
    club_id INT NOT NULL,
    type ENUM('monthly', 'yearly', 'student', 'youth') NOT NULL,
    price INT NOT NULL,
    FOREIGN KEY (club_id) REFERENCES clubs(id) ON DELETE CASCADE
);
```

### 12. tournaments
```sql
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
```

### 13. tournament_rules
```sql
CREATE TABLE tournament_rules (
    id INT PRIMARY KEY AUTO_INCREMENT,
    tournament_id INT NOT NULL,
    rule VARCHAR(255) NOT NULL,
    FOREIGN KEY (tournament_id) REFERENCES tournaments(id) ON DELETE CASCADE
);
```

### 14. tournament_schedule
```sql
CREATE TABLE tournament_schedule (
    id INT PRIMARY KEY AUTO_INCREMENT,
    tournament_id INT NOT NULL,
    round VARCHAR(100) NOT NULL,
    time VARCHAR(50) NOT NULL,
    FOREIGN KEY (tournament_id) REFERENCES tournaments(id) ON DELETE CASCADE
);
```

### 15. venues
```sql
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
```

### 16. venue_facilities
```sql
CREATE TABLE venue_facilities (
    id INT PRIMARY KEY AUTO_INCREMENT,
    venue_id INT NOT NULL,
    facility VARCHAR(255) NOT NULL,
    FOREIGN KEY (venue_id) REFERENCES venues(id) ON DELETE CASCADE
);
```

### 17. marketplace
```sql
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
```

### 18. marketplace_images
```sql
CREATE TABLE marketplace_images (
    id INT PRIMARY KEY AUTO_INCREMENT,
    marketplace_id INT NOT NULL,
    image_url VARCHAR(500) NOT NULL,
    FOREIGN KEY (marketplace_id) REFERENCES marketplace(id) ON DELETE CASCADE
);
```

### 19. feed
```sql
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
```

### 20. chats
```sql
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
```

### 21. notifications
```sql
CREATE TABLE notifications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    type ENUM('match_request', 'tournament', 'achievement') NOT NULL,
    from_user VARCHAR(255),
    message TEXT NOT NULL,
    time VARCHAR(50),
    read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### 22. inter_club_matches
```sql
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
```

### 23. match_participants
```sql
CREATE TABLE match_participants (
    id INT PRIMARY KEY AUTO_INCREMENT,
    match_id INT NOT NULL,
    participant_name VARCHAR(255) NOT NULL,
    team ENUM('home', 'away') NOT NULL,
    FOREIGN KEY (match_id) REFERENCES inter_club_matches(id) ON DELETE CASCADE
);
```

### 24. match_registered_clubs
```sql
CREATE TABLE match_registered_clubs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    match_id INT NOT NULL,
    club_id INT NOT NULL,
    FOREIGN KEY (match_id) REFERENCES inter_club_matches(id) ON DELETE CASCADE,
    FOREIGN KEY (club_id) REFERENCES clubs(id) ON DELETE CASCADE,
    UNIQUE KEY unique_match_club (match_id, club_id)
);
```

## Indexes for Performance

```sql
-- Users table indexes
CREATE INDEX idx_users_club_id ON users(club_id);
CREATE INDEX idx_users_location ON users(location);
CREATE INDEX idx_users_elo ON users(elo);
CREATE INDEX idx_users_online ON users(online);

-- Clubs table indexes
CREATE INDEX idx_clubs_city ON clubs(city);
CREATE INDEX idx_clubs_province ON clubs(province);
CREATE INDEX idx_clubs_verified ON clubs(verified);
CREATE INDEX idx_clubs_team_ranking ON clubs(team_ranking);

-- Tournaments table indexes
CREATE INDEX idx_tournaments_date ON tournaments(date);
CREATE INDEX idx_tournaments_status ON tournaments(status);
CREATE INDEX idx_tournaments_type ON tournaments(type);

-- Venues table indexes
CREATE INDEX idx_venues_distance ON venues(distance);
CREATE INDEX idx_venues_rating ON venues(rating);

-- Marketplace table indexes
CREATE INDEX idx_marketplace_seller_id ON marketplace(seller_id);
CREATE INDEX idx_marketplace_status ON marketplace(status);
CREATE INDEX idx_marketplace_category ON marketplace(category);
CREATE INDEX idx_marketplace_price ON marketplace(price);

-- Feed table indexes
CREATE INDEX idx_feed_type ON feed(type);
CREATE INDEX idx_feed_user_id ON feed(user_id);
CREATE INDEX idx_feed_club_id ON feed(club_id);
CREATE INDEX idx_feed_created_at ON feed(created_at);

-- Chats table indexes
CREATE INDEX idx_chats_user_id ON chats(user_id);
CREATE INDEX idx_chats_unread ON chats(unread);

-- Notifications table indexes
CREATE INDEX idx_notifications_type ON notifications(type);
CREATE INDEX idx_notifications_read ON notifications(read);
CREATE INDEX idx_notifications_created_at ON notifications(created_at);

-- Inter club matches table indexes
CREATE INDEX idx_inter_club_matches_date ON inter_club_matches(date);
CREATE INDEX idx_inter_club_matches_status ON inter_club_matches(status);
CREATE INDEX idx_inter_club_matches_home_club ON inter_club_matches(home_club_id);
CREATE INDEX idx_inter_club_matches_away_club ON inter_club_matches(away_club_id);
```

## Data Integrity and Constraints

- All foreign keys use appropriate CASCADE or SET NULL actions
- ENUM types ensure data consistency
- DEFAULT values prevent NULL issues
- TIMESTAMP fields auto-update for audit trails
- UNIQUE constraints prevent duplicate registrations

## Notes

1. JSON fields are used for arrays (play_time, skill_range) - requires MySQL 5.7.8+
2. All text fields use appropriate VARCHAR lengths based on expected data
3. DECIMAL types used for ratings and distances for precision
4. YEAR type used for established dates
5. BOOLEAN fields for simple true/false values
6. TEXT fields for longer content like descriptions

This schema provides a solid foundation for the PingPong+ application with proper normalization and relationships.