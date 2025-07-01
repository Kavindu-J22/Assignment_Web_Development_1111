<?php
// ===== GET OVERALL RATING =====
// This file returns the overall rating data as JSON

require_once 'config.php';

header('Content-Type: application/json');

try {
    $overallRating = getOverallRating();
    
    echo json_encode([
        'success' => true,
        'rating' => $overallRating
    ]);
    
} catch (Exception $e) {
    // Log the error
    error_log("Get rating error: " . $e->getMessage());
    
    // Return default rating
    echo json_encode([
        'success' => false,
        'rating' => [
            'average' => 0,
            'count' => 0,
            'total' => 0
        ]
    ]);
}

?>
