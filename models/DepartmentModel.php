<?php


class DepartmentModel
{
    private static $table = 'departments';

    protected $dept_no;
    protected $dept_name;

    private $con;

    public function __construct()
    {
        global $con;
        
        $this->con = $con;
    }

    /**
     * @return mixed
     */
    public function getDeptNo()
    {
        return $this->dept_no;
    }

    /**
     * @param mixed $dept_no
     */
    public function setDeptNo($dept_no): void
    {
        $this->dept_no = $dept_no;
    }

    /**
     * @return mixed
     */
    public function getDeptName()
    {
        return $this->dept_name;
    }

    /**
     * @param mixed $dept_name
     */
    public function setDeptName($dept_name): void
    {
        $this->dept_name = $dept_name;
    }

    public static function getCurrentDepartmentOfEmployee($employeeID){
        global $con;

        $department = new DepartmentModel();

        $query = "SELECT d.dept_name, d.dept_no
                    FROM current_dept_emp cde
                    JOIN ".self::$table." d on d.dept_no = cde.dept_no
                    WHERE cde.emp_no = ".$employeeID." AND (cde.from_date <= NOW() AND cde.to_date >= NOW())
                    LIMIT 1";

        if($result = mysqli_query($con, $query)){
            if($row = mysqli_fetch_array($result)){
                $department->setDeptName($row['dept_name']);
                $department->setDeptNo($row['dept_no']);
            }
        }

        return $department;
    }

    public static function getDepartmentTypes(){
        global $con;

        $departments = array();

        $query = "SELECT dept_name, dept_no
                    FROM ".self::$table." 
                    ORDER BY dept_no";

        if($result = mysqli_query($con, $query)){
            while($row = mysqli_fetch_array($result)){
                $department = new DepartmentModel();
                $department->setDeptName($row['dept_name']);
                $department->setDeptNo($row['dept_no']);

                $departments []= $department;
            }
        }

        return $departments;
    }
}