USE travel_agency;

-- Insert admin user (password: admin123)
INSERT INTO users (username, email, password, first_name, last_name, is_admin) 
VALUES (
    'admin',
    'admin@travelagency.com',
    '$2y$10$i1uBFsrW1SXzUwWJvOhnpOgARSmb5CbQe3ADh9ceiyQB8VZtEz592',
    'Admin',
    'User',
    1
); 