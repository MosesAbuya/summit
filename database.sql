CREATE DATABASE IF NOT EXISTS summit;
USE summit;

CREATE TABLE IF NOT EXISTS enquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    registration_type VARCHAR(100) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50),
    organization VARCHAR(255) NOT NULL,
    country VARCHAR(100) NOT NULL,
    passport VARCHAR(100),
    dietary_requirements VARCHAR(100),
    accessibility_needs TEXT,
    track_alignment VARCHAR(100) NOT NULL,
    pro_bono_pledge TINYINT(1) DEFAULT 0,
    status VARCHAR(50) DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS mailer_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    form_type VARCHAR(50) UNIQUE NOT NULL, -- e.g., 'contact', 'registration'
    company_email VARCHAR(255),
    smtp_host VARCHAR(255),
    smtp_port INT DEFAULT 465,
    smtp_user VARCHAR(255),
    smtp_pass VARCHAR(255),
    from_email VARCHAR(255),
    from_name VARCHAR(255),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    excerpt TEXT NOT NULL,
    content LONGTEXT NOT NULL,
    image_url VARCHAR(255),
    status VARCHAR(50) DEFAULT 'Published',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert Dummy Data for Settings
INSERT IGNORE INTO mailer_settings (form_type, company_email, smtp_host, smtp_port, smtp_user, smtp_pass, from_email, from_name) VALUES 
('contact', 'info@jitoleegoodfriendsfoundation.org', 'mail.summit.localhost', 465, 'sales@summit.localhost', 'password123', 'info@jitoleegoodfriendsfoundation.org', 'Summit Africa'),
('registration', 'registrations@jitoleegoodfriendsfoundation.org', 'mail.summit.localhost', 465, 'sales@summit.localhost', 'password123', 'registrations@jitoleegoodfriendsfoundation.org', 'Summit Africa Reg');

-- Insert Dummy News Data
INSERT INTO news (title, excerpt, content, image_url) VALUES 
('Summit 2026 Registration Opens', 'We are thrilled to announce that early bird registration for the Global Summit on Pro Bono Practice is now live.', 'Full content for registration opening. Join us in Nairobi to be part of the multidisciplinary revolution...', 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&q=80&w=800'),
('New Keynote Speaker Announced', 'Dr. Amina Mohamed joins the Summit to discuss the intersection of Policy, Compliance & ESG.', 'Full content about the keynote speaker. Dr. Amina will shed light on the regulatory frameworks impacting pro bono work...', 'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&q=80&w=800'),
('Safaricom Joins as Platinum Sponsor', 'Telecommunications giant Safaricom has committed to the Platinum Sponsorship tier, supercharging our ESG goals.', 'Safaricom is leading the charge in corporate social responsibility. Their partnership will enable the sponsorship of 50 grassroots delegates...', 'https://images.unsplash.com/photo-1515187029135-18ee286d815b?auto=format&fit=crop&q=80&w=800');

-- --------------------------------------------------------
-- New Tables for Dynamic Content
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS partners (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    image_url VARCHAR(255),
    is_major TINYINT(1) DEFAULT 0,
    website_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS speakers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    title VARCHAR(255),
    bio TEXT,
    image_url VARCHAR(255),
    is_keynote TINYINT(1) DEFAULT 0,
    video_url VARCHAR(255),
    theme VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS accommodations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hotel_name VARCHAR(255) NOT NULL,
    description TEXT,
    booking_link VARCHAR(255),
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert dummy data for partners
INSERT INTO partners (name, description, image_url, is_major) VALUES
('Safaricom', 'Telecommunications partner advancing digital inclusion.', 'assets/safaricom.png', 1),
('Global Pro Bono Network', 'Co-host driving the multidisciplinary revolution.', 'assets/globalprobono.png', 1),
('Jitolee Good Friends Foundation', 'Co-host championing grassroots impact.', 'assets/jitoleelogo.png', 1);

-- Insert dummy data for speakers
INSERT INTO speakers (name, title, bio, image_url, is_keynote, video_url, theme) VALUES
('Fredrick Sadia', 'Founder & Co-host', 'Visionary leader for the Summit.', 'assets/fredsadia.png', 1, 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'Pillar I'),
('Amina Mohamed', 'Policy Expert', 'Advocating for institutional excellence.', 'assets/avatar.png', 1, '', 'Pillar II');

-- Insert dummy data for accommodations
INSERT INTO accommodations (hotel_name, description, booking_link, image_url) VALUES
('Safari Park Hotel', 'Official Summit Venue and Accommodation Partner', 'https://safaripark-hotel.com', 'assets/venues/venue1.jpg'),
('Radisson Blu Upper Hill', 'Premium partner hotel in the business district', 'https://radissonhotels.com', 'assets/venues/venue2.jpg');

CREATE TABLE IF NOT EXISTS ticket_packages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price_usd DECIMAL(10,2) NOT NULL,
    price_kes DECIMAL(10,2) NOT NULL,
    slots INT NULL DEFAULT NULL,
    is_active TINYINT(1) DEFAULT 1,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS promo_codes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) UNIQUE NOT NULL,
    discount_usd DECIMAL(10,2) DEFAULT 0,
    discount_kes DECIMAL(10,2) DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS ticket_orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_ref VARCHAR(50) UNIQUE NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50),
    organization VARCHAR(255),
    country VARCHAR(100),
    job_title VARCHAR(255),
    dietary_requirements VARCHAR(100),
    accessibility_needs TEXT,
    visa_required TINYINT(1) DEFAULT 0,
    passport_number VARCHAR(100),
    emergency_contact_name VARCHAR(255),
    emergency_contact_phone VARCHAR(50),
    subtotal_usd DECIMAL(10,2) DEFAULT 0,
    discount_usd DECIMAL(10,2) DEFAULT 0,
    total_usd DECIMAL(10,2) DEFAULT 0,
    subtotal_kes DECIMAL(10,2) DEFAULT 0,
    discount_kes DECIMAL(10,2) DEFAULT 0,
    total_kes DECIMAL(10,2) DEFAULT 0,
    promo_code VARCHAR(50),
    payment_status VARCHAR(50) DEFAULT 'pending',
    transaction_code VARCHAR(100),
    payment_proof_url VARCHAR(255),
    payment_confirmed_at DATETIME,
    admin_notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS ticket_order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    package_id INT NOT NULL,
    package_name VARCHAR(255) NOT NULL,
    unit_price_usd DECIMAL(10,2) NOT NULL,
    unit_price_kes DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL,
    subtotal_usd DECIMAL(10,2) NOT NULL,
    subtotal_kes DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES ticket_orders(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert revised 2026 promo packages
INSERT INTO ticket_packages (name, description, price_usd, price_kes, slots, sort_order, is_active) VALUES
('Students', 'Valid student ID required at summit venue', 100.00, 10000.00, 20, 1, 1),
('EAC Members', 'East African Community (Kenya, Uganda, Tanzania, Rwanda, Burundi, South Sudan, DRC, Somalia)', 250.00, 25000.00, 20, 2, 1),
('Speakers', 'Approved speakers, panellists, moderators, and session presenters', 250.00, 25000.00, 50, 3, 1),
('GPBN Members', 'Global Pro Bono Network certified members and affiliates', 350.00, 35000.00, 50, 4, 1),
('Academia', 'Researchers, university faculty, and educational institutions', 350.00, 35000.00, 20, 5, 1),
('NGOs/Civil Society/VIOs (Individual)', 'Non-profit, civil society & volunteer-involving individual delegate', 250.00, 25000.00, 50, 6, 1),
('NGOs/Civil Society/VIOs (Table of 5)', 'Delegation pass for 5 representatives from non-profit / civil society / VIOs', 1250.00, 125000.00, 10, 7, 1),
('NGOs/Civil Society/VIOs (Table of 10)', 'Delegation pass for 10 representatives from non-profit / civil society / VIOs', 2500.00, 250000.00, 5, 8, 1),
('Corporate (Individual)', 'Corporate sector, business enterprise & ESG leader individual delegate', 300.00, 30000.00, 50, 9, 1),
('Corporate (Table of 5)', 'Corporate delegation pass for 5 executives / representatives', 1500.00, 150000.00, 10, 10, 1),
('Corporate (Table of 10)', 'Corporate delegation pass for 10 executives / representatives', 3000.00, 300000.00, 5, 11, 1),
('Daily Pass', 'Single-day summit access pass (valid for 1 day of conference sessions)', 60.00, 6000.00, 50, 12, 1),
('Virtual Pass (Subject to the numbers)', 'Full virtual streaming and digital session participation access', 50.00, 5000.00, 100, 13, 1);
