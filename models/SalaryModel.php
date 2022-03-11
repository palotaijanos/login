<?php


class SalaryModel
{
    private static $table = 'salaries';

    protected $emp_no;
    protected $salary;
    protected $from_date;
    protected $to_date;

    private $con;

    public function __construct()
    {
        global $con;
        
        $this->con = $con;
    }

    /**
     * @return mixed
     */
    public function getEmpNo()
    {
        return $this->emp_no;
    }

    /**
     * @param mixed $emp_no
     */
    public function setEmpNo($emp_no): void
    {
        $this->emp_no = $emp_no;
    }

    /**
     * @return mixed
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * @param mixed $salary
     */
    public function setSalary($salary): void
    {
        $this->salary = $salary;
    }

    /**
     * @return mixed
     */
    public function getFromDate()
    {
        return $this->from_date;
    }

    /**
     * @param mixed $from_date
     */
    public function setFromDate($from_date): void
    {
        $this->from_date = $from_date;
    }

    /**
     * @return mixed
     */
    public function getToDate()
    {
        return $this->to_date;
    }

    /**
     * @param mixed $to_date
     */
    public function setToDate($to_date): void
    {
        $this->to_date = $to_date;
    }

    public static function getCurrentSalaryOfEmployee($employeeID){
        global $con;

        $salary = new SalaryModel();

        $query = "SELECT *
                    FROM ".self::$table."
                    WHERE emp_no = ".$employeeID." AND (from_date <= NOW() AND to_date >= NOW())
                    LIMIT 1";

        if($result = mysqli_query($con, $query)){
            if($row = mysqli_fetch_array($result)){
                $salary->setEmpNo($row['dept_name']);
                $salary->setSalary($row['salary']);
                $salary->setFromDate($row['from_date']);
                $salary->setToDate($row['to_date']);
            }
        }

        return $salary;
    }

}