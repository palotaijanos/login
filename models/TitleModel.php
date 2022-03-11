<?php


class TitleModel
{
    private static $table = 'titles';

    protected $emp_no;
    protected $title;
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

    public static function getCurrentTitleOfEmployee($employeeID){
        global $con;

        $title = new TitleModel();

        $query = "SELECT *
                    FROM ".self::$table."
                    WHERE emp_no = ".$employeeID." AND (from_date <= NOW() AND to_date >= NOW())
                    LIMIT 1";

        if($result = mysqli_query($con, $query)){
            if($row = mysqli_fetch_array($result)){
                $title->setEmpNo($row['emp_no']);
                $title->setTitle($row['title']);
                $title->setFromDate($row['from_date']);
                $title->setToDate($row['to_date']);
            }
        }

        return $title;
    }

    public static function getTitleTypes(){
        global $con;

        $titles = array();

        $query = "SELECT distinct title
                    FROM ".self::$table." 
                    ORDER BY title asc";

        if($result = mysqli_query($con, $query)){
            while($row = mysqli_fetch_array($result)){
                $title = new TitleModel();
                $title->setTitle($row['title']);

                $titles []= $title;
            }
        }

        return $titles;
    }
}