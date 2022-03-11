<?php
include_once 'DepartmentModel.php';
include_once 'SalaryModel.php';
include_once 'TitleModel.php';

class EmployeeModel
{
    private static $table = 'employees';

    protected $emp_no;
    protected $birth_date;
    protected $first_name;
    protected $last_name;
    protected $gender;
    protected $hire_date;
    protected $department;
    protected $salary;
    protected $title;

    private $con;

    public function __construct()
    {
        global $con;
        
        $this->con = $con;
    }

    public function findById($id){
        $objectFound = false;

        $query = "SELECT *
                    FROM ".EmployeeModel::$table."
                    WHERE emp_no = ".$id."
                    LIMIT 1";

        if($result = mysqli_query($this->con, $query)){
            if($row = mysqli_fetch_array($result)){

                $this->setEmpNo($row['emp_no']);
                $this->setBirthDate($row['birth_date']);
                $this->setFirstName($row['first_name']);
                $this->setLastName($row['last_name']);
                $this->setGender($row['gender']);
                $this->setHireDate($row['hire_date']);

                if($department = DepartmentModel::getCurrentDepartmentOfEmployee($row['emp_no'])){
                    $this->setDepartment($department);
                }

                if($salary = SalaryModel::getCurrentSalaryOfEmployee($row['emp_no'])){
                    $this->setSalary($salary);
                }

                if($title = TitleModel::getCurrentTitleOfEmployee($row['emp_no'])){
                    $this->setTitle($title);
                }

                $objectFound = true;
            }
        }

        return $objectFound;
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
    public function getBirthDate()
    {
        return $this->birth_date;
    }

    /**
     * @param mixed $birth_date
     */
    public function setBirthDate($birth_date): void
    {
        $this->birth_date = $birth_date;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     */
    public function setFirstName($first_name): void
    {
        $this->first_name = $first_name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     */
    public function setLastName($last_name): void
    {
        $this->last_name = $last_name;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @return mixed
     */
    public function getHireDate()
    {
        return $this->hire_date;
    }

    /**
     * @param mixed $hire_date
     */
    public function setHireDate($hire_date): void
    {
        $this->hire_date = $hire_date;
    }

    /**
     * @return DepartmentModel
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * @param mixed $department
     */
    public function setDepartment($department): void
    {
        $this->department = $department;
    }

    /**
     * @return SalaryModel
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
     * @return TitleModel
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function update(){
        $objectUpdated = false;

        $query = "UPDATE ".EmployeeModel::$table."
                    SET 
                    birth_date = '".$this->getBirthDate()."',
                    first_name = '".$this->getFirstName()."',
                    last_name = '".$this->getLastName()."',
                    gender = '".$this->getGender()."',
                    hire_date = '".$this->getHireDate()."'
                    
                    WHERE emp_no = ".$this->getEmpNo()."
                    LIMIT 1";

        if($result = mysqli_query($this->con, $query)){
            $objectUpdated = true;
        }

        return $objectUpdated;
    }

    public static function getList($page, $pageSize = 20, $orderBy = 'emp_no', $orderWay = 'ASC', $filterColumn = '', $filterValue = ''){
        global $con;
        //todo: prevent sql injection

        $elements = array();

        $offset = ($page - 1) * $pageSize;

        $query = "select e.emp_no, e.birth_date, e.gender, e.first_name, e.last_name, e.hire_date, 
                    t.title, t.from_date, t.to_date, 
                    d.dept_no, d.dept_name
                    from employees e 
                    join titles t on t.emp_no = e.emp_no
                    join current_dept_emp cde on cde.emp_no = e.emp_no
                    join departments d on d.dept_no = cde.dept_no
                    where t.from_date <= now() and t.to_date >= now() and cde.from_date <= now() and cde.to_date >= now()
                    ".(($filterColumn!=''&&$filterValue!='')?"AND ".$filterColumn." LIKE '%".$filterValue."%'":"")."
                    ORDER BY ".$orderBy." ".$orderWay."
                    LIMIT ".$pageSize." OFFSET ".$offset;

        if($result = mysqli_query($con, $query)){
            while ($row = mysqli_fetch_array($result)){
                $employeeObj = new EmployeeModel();

                $employeeObj->setEmpNo($row['emp_no']);
                $employeeObj->setBirthDate($row['birth_date']);
                $employeeObj->setFirstName($row['first_name']);
                $employeeObj->setLastName($row['last_name']);
                $employeeObj->setGender($row['gender']);
                $employeeObj->setHireDate($row['hire_date']);

                $department = new DepartmentModel();
                $department->setDeptName($row['dept_name']);
                $department->setDeptNo($row['dept_no']);

                $title = new TitleModel();
                $title->setTitle($row['title']);
                $title->setFromDate($row['from_date']);
                $title->setToDate($row['to_date']);

                $employeeObj->setDepartment($department);
                $employeeObj->setTitle($title);

                $elements []= $employeeObj;
            }
        }

        return $elements;
    }

    public static function getNumberOfPages($pageSize = 20, $filterColumn = '', $filterValue = ''){
        global $con;
        $count = 0;
        $numberOfPages = 0;

        $query = "select count(*) as count
                    from employees e 
                    join titles t on t.emp_no = e.emp_no
                    join current_dept_emp cde on cde.emp_no = e.emp_no
                    join departments d on d.dept_no = cde.dept_no
                    where t.from_date <= now() and t.to_date >= now() and cde.from_date <= now() and cde.to_date >= now()
                    ".(($filterColumn!=''&&$filterValue!='')?"AND ".$filterColumn." LIKE '%".$filterValue."%'":"");

        if($result = mysqli_query($con, $query)){
            if($row = mysqli_fetch_array($result)){
                $count = $row['count'];

                $numberOfPages = ceil($count / $pageSize);
            }
        }

        return $numberOfPages;
    }

}