```php
<?php

class Candidate
{
    private $cid;
    private $name;
    private $age;
    private $email;
    private $contact;
    private $alternativeNumber;
    private $panNumber;
    private $searchValue;



    private $file;





    public function __construct($searchValue = null)
    {
        $this->file = __DIR__ . "/candidate.json";
        $this->searchValue = $searchValue;
    }



    // Setters
    public function setCid($cid)
    {
        $this->cid = $cid;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setAge($age)
    {
        $this->age = $age;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setContact($contact)
    {
        $this->contact = $contact;
    }

    public function setAlternativeNumber($alternativeNumber)
    {
        $this->alternativeNumber = $alternativeNumber;
    }

    public function setPanNumber($panNumber)
    {
        $this->panNumber = $panNumber;
    }

    // Getters
    public function getCid()
    {
        return $this->cid;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getContact()
    {
        return $this->contact;
    }

    public function getAlternativeNumber()
    {
        return $this->alternativeNumber;
    }

    public function getPanNumber()
    {
        return $this->panNumber;
    }

    // Add Candidate
    public function addCandidate()
    {
        // Get User Input

        $this->setCid(readline("Enter Candidate ID: "));
        $this->setName(readline("Enter Name: "));
        $this->setAge(readline("Enter Age: "));
        $this->setEmail(readline("Enter Email: "));
        $this->setContact(readline("Enter Contact Number: "));
        $this->setAlternativeNumber(readline("Enter Alternative Number: "));
        $this->setPanNumber(readline("Enter PAN Number: "));

        // Validation

        if (empty($this->getCid())) {
            throw new Exception("Candidate ID is required");
        }

        if (!preg_match("/^[a-zA-Z\s'-]+$/", $this->getName())) {
            throw new Exception("Invalid Name");
        }

        if (!is_numeric($this->getAge()) || $this->getAge() < 18) {
            throw new Exception("Invalid Age");
        }

        if (!filter_var($this->getEmail(), FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid Email");
        }

        if (!preg_match("/^[0-9]{10}$/", $this->getContact())) {
            throw new Exception("Invalid Contact Number");
        }

        if (!preg_match("/^[0-9]{10}$/", $this->getAlternativeNumber())) {
            throw new Exception("Invalid Alternative Number");
        }

        if (!preg_match("/^[A-Z]{5}[0-9]{4}[A-Z]$/i", $this->getPanNumber())) {
            throw new Exception("Invalid PAN Number");
        }

        // Candidate Data

        $candidate = [
            "cid" => $this->getCid(),
            "name" => $this->getName(),
            "age" => $this->getAge(),
            "email" => $this->getEmail(),
            "contact" => $this->getContact(),
            "alternativeNumber" => $this->getAlternativeNumber(),
            "panNumber" => $this->getPanNumber()
        ];

        // Load Existing JSON

        $employees = [];

        if (file_exists($this->file)) {
            $employees = json_decode(
                file_get_contents($this->file),
                true
            );

            if (!is_array($employees)) {
                $employees = [];
            }
        }

        // Add New Candidate

        $employees[] = $candidate;

        // Save JSON

        file_put_contents(
            $this->file,
            json_encode($employees, JSON_PRETTY_PRINT)
        );

        echo "\nCandidate Added Successfully!\n";
    }

    public function searchCandidate()
    {
        if (!file_exists($this->file)) {
            echo "No data found\n";
            return;
        }

        $employees = json_decode(
            file_get_contents($this->file),
            true
        );

       // print_r($employees);
//exit;

        foreach ($employees as $employee) {

            if ( isset($employee["cid"]) &&$employee["cid"] == $this->searchValue) {

                echo "\nCandidate Found\n";
                echo "CID : " . $employee["cid"] . "\n";
                echo "Name : " . $employee["name"] . "\n";
                echo "Age : " . $employee["age"] . "\n";
                echo "Email : " . $employee["email"] . "\n";
                echo "Contact : " . $employee["contact"] . "\n";
                echo "Alternative Number : " . $employee["alternativeNumber"] . "\n";
                echo "PAN Number : " . $employee["panNumber"] . "\n";

                return;
            }
        }

        echo "Candidate Not Found\n";
    }



    public function updateCandidate()
    {
        if (!file_exists($this->file)) {
            echo "No data found\n";
            return;
        }

        $employees = json_decode(
            file_get_contents($this->file),
            true
        );

        $found = false;

        foreach ($employees as &$employee) {

            if (isset($employee["cid"]) &&$employee["cid"] == $this->searchValue) {

                echo "\nCandidate Found\n";

                $employee["name"] =
                    readline("Enter New Name: ");

                $employee["age"] =
                    readline("Enter New Age: ");

                $employee["email"] =
                    readline("Enter New Email: ");

                $employee["contact"] =
                    readline("Enter New Contact Number: ");

                $employee["alternativeNumber"] =
                    readline("Enter New Alternative Number: ");

                $employee["panNumber"] =
                    readline("Enter New PAN Number: ");

                $found = true;
                break;
            }
        }

        if ($found) {

            file_put_contents(
                $this->file,
                json_encode($employees, JSON_PRETTY_PRINT)
            );

            echo "Candidate Updated Successfully\n";
        } else {

            echo "Candidate Not Found\n";
        }
    }

    
public function deleteCandidate()
{
    if (!file_exists($this->file)) {
        echo "No data found\n";
        return;
    }

    $employees = json_decode(
        file_get_contents($this->file),
        true
    );

    $found = false;

    foreach ($employees as $index => $employee) {

        if (isset($employee["cid"]) && $employee["cid"] == $this->searchValue) {

            unset($employees[$index]);

            $found = true;
            break;
        }
    }

    if ($found) {

        $employees = array_values($employees);

        file_put_contents(
            $this->file,
            json_encode($employees, JSON_PRETTY_PRINT)
        );

        echo "Candidate Deleted Successfully\n";

    } else {

        echo "Candidate Not Found\n";
    }
}

}


// Main Program
/*
try {
    $candidate = new Candidate();
    $candidate->addCandidate();
} catch (Exception $e) {
    echo "\nError: " . $e->getMessage() . "\n";
}


$cid = readline("Enter Candidate ID to Search: ");

$candidate = new Candidate($cid);

$candidate->searchCandidate();
*/

?>
