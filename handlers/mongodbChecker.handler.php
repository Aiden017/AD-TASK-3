<?php
function checkMongoConnection() {
    try {
        $mongo = new MongoDB\Driver\Manager("mongodb://host.docker.internal:21713");
        $command = new MongoDB\Driver\Command(["ping" => 1]);
        $mongo->executeCommand("admin", $command);
        return "✅ Connected to MongoDB successfully.";
    } catch (MongoDB\Driver\Exception\Exception $e) {
        return "❌ MongoDB connection failed: " . $e->getMessage();
    }
}
