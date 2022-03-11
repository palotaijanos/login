<?php

include_once('models/EmployeeModel.php');


class EmployeeController
{
    private $pageLinksShown = 0;
    private $pageLinksMax = 10;

    private $departmentTypes;
    private $departmentOptions;
    private $titleTypes;
    private $titleOptions;
    /**
     * EmployeeController constructor.
     */
    public function __construct()
    {
        $this->departmentTypes = DepartmentModel::getDepartmentTypes();

        $this->departmentOptions = array();
        $this->departmentOptions []= array(
            '' => ''
        );

        foreach ($this->departmentTypes as $departmentType){
            /* @var DepartmentModel $departmentType */
            $this->departmentOptions []= array(
                $departmentType->getDeptNo() => $departmentType->getDeptName()
            );
        }

        $this->titleTypes = TitleModel::getTitleTypes();


        $this->titleOptions = array();
        $this->titleOptions []= array(
            '' => ''
        );

        foreach ($this->titleTypes as $titleType){
            /* @var TitleModel $titleType */
            $this->titleOptions []= array(
                $titleType->getTitle() => $titleType->getTitle()
            );
        }
    }

    public function getView(){
        $view = 'list';

        if(isset($_GET['view'])){
            $view = $_GET['view'];
        }

        switch ($view){
            case 'list':
                $this->list();
                break;
            case 'form':
                if(isset($_GET['id_employee'])){
                    $id = $_GET['id_employee'];
                    $this->form($id);
                }
                break;
        }
    }

    protected function list(){
        $currentPage = $_GET['page']??1;

        include_once('views/list/employee.php');
    }

    public function ajax(){

        $tableColumns = array(
            'first_name' => array(
                'label' => 'First name',
                'type' => 'text'
            ),
            'last_name' => array(
                'label' => 'Last name',
                'type' => 'text'
            ),
            'hire_date' => array(
                'label' => 'Hire Date',
                'type' => 'text'
            ),
            'dept_name' => array(
                'label' => 'Department',
                'type' => 'select',
                'options' => $this->departmentOptions
            ),
            'title' =>  array(
                'label' => 'Title',
                'type' => 'select',
                'options' => $this->titleOptions
            )
        );
        $currentOrderBy = $_GET['order_by']??'emp_no';
        $currentOrderWay = $_GET['order_way']??'asc';
        $filterColumn = $_GET['filter_column']??'';
        $filterValue = $_GET['filter_value']??'';

        $pageSize = 20;

        $pageLinksShown = $this->pageLinksShown;
        $pageLinksMax = $this->pageLinksMax;

        $currentPage = $_GET['page']??1;
        $isAjax = $_GET['ajax']??0;

        $startPagination = $currentPage;

        if(($startPagination - ceil($pageLinksMax / 2)) > 0){
            $startPagination -= ceil($pageLinksMax / 2);
        }else{
            $startPagination = 1;
        }

        $pageSize = 20;

        $numberOfPages = EmployeeModel::getNumberOfPages($pageSize, $filterColumn, $filterValue);

        $employees = EmployeeModel::getList($currentPage, $pageSize, $currentOrderBy, $currentOrderWay, $filterColumn, $filterValue);

        include_once('views/ajax/employee.php');
    }

    protected function form($id){
        //todo: fix error after getFirstName
        //todo: set department, title
        $error = '';
        $success = '';
        $departmentOptions = $this->departmentOptions;
        $titleOptions = $this->titleOptions;

        $employee = new EmployeeModel();
        if($employee->findById($id)){
            if(isset($_POST['edit'])){
                //TODO : value validations
                $birthDate = $_POST['birth_date'];
                $firstName = $_POST['first_name'];
                $lastName = $_POST['last_name'];
                $gender = $_POST['gender'];
                $hireDate = $_POST['hire_date'];

                $employee->setBirthDate($birthDate);
                $employee->setFirstName($firstName);
                $employee->setLastName($lastName);
                $employee->setGender($gender);
                $employee->setHireDate($hireDate);


                if($employee->update()){
                    $success = 'Employee updated successfully';
                }
            }
        }else{
            $error = 'Employee not found for this id : '.$id;
        }


        include_once('views/form/employee.php');
    }
}