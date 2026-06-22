<?php

require "Onboarding.php";

class Employee extends Candidate
{
    private $eid;
    private $designation;
    private $salary;

    public function setEid($_eid)
    {
        $this->eid = $_eid;
    }

    public function setDesignation($_designation)
    {
        $this->designation = $_designation;
    }

    public function setSalary($_salary)
    {
        $this->salary = $_salary;
    }

    public function toArray()
    {
        return [
            "Cid" => $this->getCid(),
            "Eid" => $this->eid,
            "Designation" => $this->designation,
            "Salary" => $this->salary
        ];
    }
}

$file = "employees2.json";

$employees = [];

if (file_exists($file)) {

    $data = file_get_contents($file);

    $employees = json_decode($data, true);

    if (!is_array($employees)) {
        $employees = [];
    }
}

$employee = new Employee();

$employee->setCid(readline("Enter Candidate ID: "));
$employee->setEid(readline("Enter Employee ID: "));
$employee->setDesignation(readline("Enter Designation: "));
$employee->setSalary(readline("Enter Salary: "));

$employees[] = $employee->toArray();

file_put_contents(
    $file,
    json_encode($employees, JSON_PRETTY_PRINT)
);

echo "Employee Saved Successfully.\n";
