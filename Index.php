<?php

require_once "Onboarding.php";

while (true) {

    echo "\n===== Candidate Management System =====\n";
    echo "1. Add Candidate\n";
    echo "2. Search Candidate\n";
    echo "3. Update Candidate\n";
    echo "4. Delete Candidate\n";
    echo "5. Exit\n";

    $choice = trim(readline("Enter your choice: "));

    switch ($choice) {

        case "1":

            try {
                $candidate = new Candidate();
                $candidate->addCandidate();
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage() . "\n";
            }

            break;

        case "2":

            $cid = trim(readline("Enter Candidate ID: "));

            $candidate = new Candidate($cid);
            $candidate->searchCandidate();

            break;

        case "3":

            $cid = trim(readline("Enter Candidate ID: "));

            $candidate = new Candidate($cid);
            $candidate->updateCandidate();

            break;

        case "4":

            $cid = trim(readline("Enter Candidate ID: "));

            $candidate = new Candidate($cid);
            
            $candidate->deleteCandidate();

            break;

        case "5":

            echo "Program Exited\n";
            exit;

        default:

            echo "Invalid Choice\n";
    }
}
