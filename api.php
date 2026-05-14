<?php
/*
    =================== api.php ===================
    Place this entire PHP block inside "api.php" file.
    Ensure MySQL is running, adjust credentials.
*/

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Database configuration
$host = 'localhost';
$dbname = 'cv_editor';
$username = 'root';      // change if needed
$password = '';          // change if needed

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

// Handle fetch all entries grouped by section_key
if ($action === 'fetchAll' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $stmt = $pdo->query("SELECT id, section_key, title, description FROM cv_entries ORDER BY id ASC");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $grouped = [];
        foreach ($rows as $row) {
            $key = $row['section_key'];
            if (!isset($grouped[$key])) $grouped[$key] = [];
            $grouped[$key][] = [
                'id' => (int)$row['id'],
                'title' => $row['title'],
                'description' => $row['description']
            ];
        }
        // ensure all sections from frontend exist (optional)
        echo json_encode(['success' => true, 'data' => $grouped]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

// Handle save (insert or update)
if ($action === 'saveItem' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!$input) {
        echo json_encode(['success' => false, 'message' => 'Invalid JSON']);
        exit;
    }
    
    $section = trim($input['section'] ?? '');
    $id = isset($input['id']) && $input['id'] ? (int)$input['id'] : null;
    $title = trim($input['title'] ?? '');
    $description = trim($input['description'] ?? '');
    
    if (!$section || !$title) {
        echo json_encode(['success' => false, 'message' => 'Section and title are required']);
        exit;
    }
    
    try {
        if ($id) {
            // update existing
            $stmt = $pdo->prepare("UPDATE cv_entries SET title = ?, description = ? WHERE id = ? AND section_key = ?");
            $stmt->execute([$title, $description, $id, $section]);
            if ($stmt->rowCount() === 0) {
                // maybe record belongs to different section but we still allow 
                // if id exists but section diff, we can still update but check exists
                $check = $pdo->prepare("SELECT id FROM cv_entries WHERE id = ?");
                $check->execute([$id]);
                if (!$check->fetch()) {
                    echo json_encode(['success' => false, 'message' => 'Record not found']);
                    exit;
                }
                // if section mismatch we update anyway
                $stmt2 = $pdo->prepare("UPDATE cv_entries SET title = ?, description = ?, section_key = ? WHERE id = ?");
                $stmt2->execute([$title, $description, $section, $id]);
            }
        } else {
            // insert new
            $stmt = $pdo->prepare("INSERT INTO cv_entries (section_key, title, description) VALUES (?, ?, ?)");
            $stmt->execute([$section, $title, $description]);
        }
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

// Handle delete
if ($action === 'deleteItem' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!$input) {
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
        exit;
    }
    $section = trim($input['section'] ?? '');
    $id = isset($input['id']) ? (int)$input['id'] : 0;
    if (!$id || !$section) {
        echo json_encode(['success' => false, 'message' => 'Missing parameters']);
        exit;
    }
    try {
        $stmt = $pdo->prepare("DELETE FROM cv_entries WHERE id = ? AND section_key = ?");
        $stmt->execute([$id, $section]);
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

// if no action matched
echo json_encode(['success' => false, 'message' => 'Invalid action']);
?>