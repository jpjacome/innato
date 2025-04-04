-- Plants Database Schema

-- Main plants table to store plant information
CREATE TABLE plants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    common_names TEXT,
    family VARCHAR(100),
    native_range TEXT,
    age VARCHAR(50),
    current_height VARCHAR(100),
    expected_height VARCHAR(100),
    leaf_type TEXT,
    bloom_time VARCHAR(255),
    flower_color VARCHAR(100),
    fruit TEXT,
    light VARCHAR(255),
    soil VARCHAR(255),
    hardiness VARCHAR(100),
    other_comments TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Plant images table to store paths to main gallery images
CREATE TABLE plant_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    plant_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    image_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (plant_id) REFERENCES plants(id) ON DELETE CASCADE
);

-- Maintenance logs for plants
CREATE TABLE maintenance_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    plant_id INT NOT NULL,
    last_watering DATE,
    next_watering DATE,
    last_fertilization DATE,
    next_fertilization DATE,
    last_pruning DATE,
    next_pruning DATE,
    pest_disease_inspection TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (plant_id) REFERENCES plants(id) ON DELETE CASCADE
);

-- Maintenance log images (thumbnails)
CREATE TABLE maintenance_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    maintenance_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (maintenance_id) REFERENCES maintenance_logs(id) ON DELETE CASCADE
);

-- Example insertion for Jacaranda Tree
INSERT INTO plants (
    name, 
    common_names, 
    family, 
    native_range, 
    age, 
    current_height, 
    expected_height, 
    leaf_type, 
    bloom_time, 
    flower_color, 
    fruit, 
    light, 
    soil, 
    hardiness, 
    other_comments
) VALUES (
    'Jacaranda Tree',
    'Blue Jacaranda, Black Poui, Green Ebony Tree',
    'Bignoniaceae',
    'Argentina and Bolivia',
    '5 years',
    '10-15 ft (3-4.5 m)',
    'Up to 50 ft (15 m)',
    'Bipinnately compound, bright green',
    'Late spring to early summer',
    'Lavender-blue',
    'Woody capsules with winged seeds',
    'Full sun (6-8 hrs/day)',
    'Sandy, well-drained',
    'USDA zones 10-11',
    'This 5-year-old Jacaranda is entering its first consistent blooming seasons. Excellent shape and health. Expected to reach shade canopy status in 3 years. Minimal maintenance required aside from seasonal watering and once-yearly pruning. Recommended for centerpiece display in subtropical zones.'
);

-- Get the ID of the inserted plant
SET @jacaranda_id = LAST_INSERT_ID();

-- Example maintenance log for Jacaranda
INSERT INTO maintenance_logs (
    plant_id,
    last_watering,
    next_watering,
    last_fertilization,
    next_fertilization,
    last_pruning,
    next_pruning,
    pest_disease_inspection
) VALUES (
    @jacaranda_id,
    '2025-04-01',
    '2025-04-08',
    '2025-03-15',
    '2025-04-15',
    '2025-02-10',
    '2026-02-01',
    'No issues observed as of April 1, 2025'
);

-- Get the maintenance log ID
SET @maintenance_id = LAST_INSERT_ID();

-- Example gallery images for Jacaranda
INSERT INTO plant_images (plant_id, image_path, image_order) VALUES 
(@jacaranda_id, 'https://th.bing.com/th/id/OIP.RoI-aOksCeTKZwm5wN-K_gHaE8?pid=ImgDet&rs=1', 1),
(@jacaranda_id, 'https://th.bing.com/th/id/OIP.RfEDaS3TfGYVKrgdVZNPOgHaE8?pid=ImgDet&rs=1', 2),
(@jacaranda_id, 'https://th.bing.com/th/id/OIP.GrIYbL1kouS5a9AuoJHfqwHaE8?pid=ImgDet&rs=1', 3),
(@jacaranda_id, 'https://th.bing.com/th/id/OIP.cKLiToShK9oLUYL3U4GgCgHaE4?pid=ImgDet&rs=1', 4);

-- Example thumbnail images for maintenance log
INSERT INTO maintenance_images (maintenance_id, image_path) VALUES 
(@maintenance_id, 'https://tse3.mm.bing.net/th?id=OIP.qo1rR-J3XU9TlZjCVYb-HAHaE7&pid=Api'),
(@maintenance_id, 'https://tse1.mm.bing.net/th?id=OIP.YQp3WdtdiNMfHlTzvx88BAHaE8&pid=Api'),
(@maintenance_id, 'https://tse2.mm.bing.net/th?id=OIP.g3z4CQLDGXRjYiWTJnFH-AHaFj&pid=Api'),
(@maintenance_id, 'https://tse3.mm.bing.net/th?id=OIP.x6NlKZbZ_5hPp6m8B5QN_QHaE7&pid=Api');

-- View query to get complete plant information with latest maintenance
CREATE VIEW plant_details AS
SELECT 
    p.*,
    m.last_watering,
    m.next_watering,
    m.last_fertilization,
    m.next_fertilization,
    m.last_pruning,
    m.next_pruning,
    m.pest_disease_inspection,
    m.id AS maintenance_id
FROM 
    plants p
LEFT JOIN 
    maintenance_logs m ON p.id = m.plant_id
WHERE 
    m.id = (SELECT MAX(id) FROM maintenance_logs WHERE plant_id = p.id)
    OR m.id IS NULL; 