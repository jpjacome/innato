<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "plants";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get plant ID from URL parameter, default to 1 if not provided
$plant_id = isset($_GET['id']) ? intval($_GET['id']) : 1;

// Get plant details using the view we created
$sql = "SELECT * FROM plant_details WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $plant_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $plant = $result->fetch_assoc();
} else {
    die("Plant not found");
}

// Get main images for the plant
$sql = "SELECT * FROM plant_images WHERE plant_id = ? ORDER BY image_order ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $plant_id);
$stmt->execute();
$mainImages = $stmt->get_result();

// Get thumbnail images from the latest maintenance log
$sql = "SELECT mi.* FROM maintenance_images mi 
        JOIN maintenance_logs ml ON mi.maintenance_id = ml.id 
        WHERE ml.plant_id = ? 
        ORDER BY ml.created_at DESC LIMIT 4";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $plant_id);
$stmt->execute();
$thumbnailImages = $stmt->get_result();

// Helper function to format dates nicely
function formatDate($dateStr) {
    if (empty($dateStr)) return 'Not scheduled';
    $date = new DateTime($dateStr);
    return $date->format('F j, Y');
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Boreal – <?php echo htmlspecialchars($plant['name']); ?></title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #f9f9f9;
      color: #333;
      line-height: 1.6;
      overflow-x: hidden;
    }

    header {
      background: #e7eef9;
      animation: fadeInDown 1s ease-in-out;
      padding: 1rem 0;
    }

    .header-container {
      max-width: 900px;
      margin: 0 auto;
      padding: 0 1rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo {
      max-width: 120px;
      height: auto;
    }

    .home-icon {
      font-size: 1.5rem;
      color: #333;
    }

    .main-title {
      text-align: left;
      margin: 2rem 0;
      font-size: 2rem;
      font-weight: 500;
      letter-spacing: 1px;
      animation: fadeIn 1.5s ease;
    }
    .container {
      max-width: 900px;
      margin: 0 auto;
      padding: 0 1rem 2rem;
    }

    section {
      margin-bottom: 2rem;
      animation: fadeIn 1.5s ease-in;
    }

    h2 {
      font-size: 1.4rem;
      color: #444;
      border-bottom: 1px solid #ddd;
      padding-bottom: 0.4rem;
      margin-bottom: 1rem;
    }

    .log-table {
      width: 100%;
      border-collapse: collapse;
    }

    .log-table td {
      padding: 0.5rem 1rem;
      border-bottom: 1px solid #e0e0e0;
    }

    .thumbnail-container {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
    }

    .thumbnail {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 4px;
      cursor: pointer;
      border: 1px solid #ddd;
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .thumbnail:hover {
      transform: scale(1.05);
      box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    .info-card p {
      margin: 0.3rem 0;
    }

    .slider {
      position: relative;
      width: 100%;
      overflow: hidden;
      border-radius: 8px;
    }

    .slide-wrapper {
      display: flex;
      transition: transform 0.5s ease;
      width: 100%;
    }

    .slide {
      min-width: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .slide img {
      max-width: 100%;
      max-height: 400px;
      object-fit: contain;
      cursor: pointer;
      border-radius: 8px;
    }

    .nav-btn {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: rgba(255, 255, 255, 0.8);
      border: none;
      font-size: 2rem;
      cursor: pointer;
      z-index: 2;
      padding: 0 0.5rem;
      border-radius: 5px;
    }

    .prev { left: 10px; }
    .next { right: 10px; }

    .fade-in {
      animation: fadeIn 1.5s ease;
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 10;
      left: 0; top: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.85);
      justify-content: center;
      align-items: center;
    }

    .modal img {
      max-width: 90%;
      max-height: 90%;
      border-radius: 10px;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInDown {
      from { opacity: 0; transform: translateY(-30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 600px) {
      .main-title { font-size: 1.5rem; }
      .logo { max-width: 100px; }
    }
  </style>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

  <header>
    <div class="header-container">
      <img src="assets/imgs/logo-boreal-black.png" alt="Boreal Logo" class="logo">
      <i class="fas fa-home home-icon"></i>
    </div>
  </header>

  <div class="container">
    <h1 class="main-title"><?php echo htmlspecialchars($plant['name']); ?></h1>
    
    <section>
      <h2>Maintenance Log</h2>
      <table class="log-table">
        <tr><td><strong>Last Watering:</strong></td><td><?php echo formatDate($plant['last_watering']); ?></td></tr>
        <tr><td><strong>Next Watering:</strong></td><td><?php echo formatDate($plant['next_watering']); ?></td></tr>
        <tr><td><strong>Last Fertilization:</strong></td><td><?php echo formatDate($plant['last_fertilization']); ?></td></tr>
        <tr><td><strong>Next Fertilization:</strong></td><td><?php echo formatDate($plant['next_fertilization']); ?></td></tr>
        <tr><td><strong>Last Pruning:</strong></td><td><?php echo formatDate($plant['last_pruning']); ?></td></tr>
        <tr><td><strong>Next Pruning:</strong></td><td><?php echo formatDate($plant['next_pruning']); ?></td></tr>
        <tr><td><strong>Pest/Disease Inspection:</strong></td><td><?php echo htmlspecialchars($plant['pest_disease_inspection']); ?></td></tr>
        <?php if ($thumbnailImages->num_rows > 0): ?>
        <tr>
          <td><strong>Latest Images:</strong></td>
          <td>
            <div class="thumbnail-container">
              <?php while ($image = $thumbnailImages->fetch_assoc()): ?>
                <img src="<?php echo htmlspecialchars($image['image_path']); ?>" alt="<?php echo htmlspecialchars($plant['name']); ?> thumbnail" class="thumbnail">
              <?php endwhile; ?>
            </div>
          </td>
        </tr>
        <?php endif; ?>
      </table>
    </section>

    <?php if ($mainImages->num_rows > 0): ?>
    <section class="slider-section">
      <h2>Images</h2>
      <div class="slider">
        <button class="nav-btn prev">&#10094;</button>
        <div class="slide-wrapper" id="slideWrapper">
          <?php $count = 1; while ($image = $mainImages->fetch_assoc()): ?>
            <div class="slide"><img src="<?php echo htmlspecialchars($image['image_path']); ?>" alt="<?php echo htmlspecialchars($plant['name']) . ' ' . $count++; ?>"></div>
          <?php endwhile; ?>
        </div>
        <button class="nav-btn next">&#10095;</button>
      </div>
    </section>
    <?php endif; ?>

    <section class="info-card fade-in">
      <h2>Botanical Information</h2>
      <p><strong>Common Names:</strong> <?php echo htmlspecialchars($plant['common_names']); ?></p>
      <p><strong>Family:</strong> <?php echo htmlspecialchars($plant['family']); ?></p>
      <p><strong>Native Range:</strong> <?php echo htmlspecialchars($plant['native_range']); ?></p>
      <p><strong>Age:</strong> <?php echo htmlspecialchars($plant['age']); ?></p>
      <p><strong>Current Height:</strong> <?php echo htmlspecialchars($plant['current_height']); ?></p>
      <p><strong>Expected Height:</strong> <?php echo htmlspecialchars($plant['expected_height']); ?></p>
      <p><strong>Leaf Type:</strong> <?php echo htmlspecialchars($plant['leaf_type']); ?></p>
      <p><strong>Bloom Time:</strong> <?php echo htmlspecialchars($plant['bloom_time']); ?></p>
      <p><strong>Flower Color:</strong> <?php echo htmlspecialchars($plant['flower_color']); ?></p>
      <p><strong>Fruit:</strong> <?php echo htmlspecialchars($plant['fruit']); ?></p>
      <p><strong>Light:</strong> <?php echo htmlspecialchars($plant['light']); ?></p>
      <p><strong>Soil:</strong> <?php echo htmlspecialchars($plant['soil']); ?></p>
      <p><strong>Hardiness:</strong> <?php echo htmlspecialchars($plant['hardiness']); ?></p>
    </section>

    <?php if (!empty($plant['other_comments'])): ?>
    <section>
      <h2>Other Comments</h2>
      <p><?php echo nl2br(htmlspecialchars($plant['other_comments'])); ?></p>
    </section>
    <?php endif; ?>

  </div>

  <!-- Modal for full-screen images -->
  <div class="modal" id="imageModal">
    <img id="modalImg" src="" alt="Full View">
  </div>

  <script>
    const wrapper = document.querySelector('.slide-wrapper');
    const slides = document.querySelectorAll('.slide');
    const prev = document.querySelector('.prev');
    const next = document.querySelector('.next');
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImg');
    let index = 0;

    function updateSlider() {
      if (wrapper) {
        wrapper.style.transform = `translateX(-${index * 100}%)`;
      }
    }

    if (prev && next && slides.length > 0) {
      prev.addEventListener('click', () => {
        index = (index <= 0) ? slides.length - 1 : index - 1;
        updateSlider();
      });

      next.addEventListener('click', () => {
        index = (index + 1) % slides.length;
        updateSlider();
      });

      slides.forEach(slide => {
        slide.querySelector('img').addEventListener('click', () => {
          modal.style.display = 'flex';
          modalImg.src = slide.querySelector('img').src;
        });
      });
    }

    // Add click event for thumbnails
    document.querySelectorAll('.thumbnail').forEach(thumbnail => {
      thumbnail.addEventListener('click', () => {
        modal.style.display = 'flex';
        modalImg.src = thumbnail.src;
      });
    });

    modal.addEventListener('click', () => {
      modal.style.display = 'none';
    });
  </script>
</body>
</html> 