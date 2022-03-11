<?php
/* @var $employee EmployeeModel */
/* @var $departmentOptions Array */
/* @var $titleOptions Array */

if($error != ''){
    ?>
    <p class="error"><?=$error?></p>
    <?php
}
if($success != ''){
    ?>
    <p class="success"><?=$success?></p>
    <?php
}
?>
<div id="form-table">
    <form method="post">
        <table>
            <tr>
                <th>
                    Employee number:
                </th>
                <td>
                    <?=$employee->getEmpNo()?>
                </td>
            </tr>
            <tr>
                <th>
                    Current department:
                </th>
                <td>
                    <select name="department">
                    <?php
                    foreach ($departmentOptions as $option){
                        foreach ($option as $optionValue => $optionName){
                            echo '<option value="'.$optionValue.'" '.(($employee->getDepartment()->getDeptNo()==$optionValue)?'selected':'').'>'.$optionName.'</option>';
                        }
                    }
                    ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>
                    Current salary:
                </th>
                <td>
                    <?=$employee->getSalary()->getSalary()?>
                </td>
            </tr>
            <tr>
                <th>
                    Current title:
                </th>
                <td>
                    <select name="title">
                        <?php
                        foreach ($titleOptions as $option){
                            foreach ($option as $optionValue => $optionName){
                                echo '<option value="'.$optionValue.'" '.(($employee->getTitle()->getTitle()==$optionValue)?'selected':'').'>'.$optionName.'</option>';
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>
                    First name:
                </th>
                <td>
                    <input type='text" name="first_name" value="<?=$employee->getFirstName()?>">
                </td>
            </tr>
            <tr>
                <th>
                    Last name:
                </th>
                <td>
                    <input type="text" name="last_name" value="<?=$employee->getLastName()?>">
                </td>
            </tr>
            <tr>
                <th>
                    Birth date:
                </th>
                <td>
                    <input type="text" name="birth_date" value="<?=$employee->getBirthDate()?>">
                </td>
            </tr>
            <tr>
                <th>
                    Gender:
                </th>
                <td>
                    <select name="gender">
                        <option value="F" <?=($employee->getGender()=='F'?'selected':'')?>>
                            Female
                        </option>
                        <option value="M" <?=($employee->getGender()=='M'?'selected':'')?>>
                            Male
                        </option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>
                    Hire date:
                </th>
                <td>
                    <input type="text" name="hire_date" value="<?=$employee->getHireDate()?>">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" value="Szerkesztés" name="edit">
                </td>
            </tr>
        </table>
    </form>
</div>
<a href="index.php">Back to list</a>