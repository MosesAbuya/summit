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
