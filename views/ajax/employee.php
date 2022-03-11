<table id="myTable">
    <thead>
    <tr>
        <?php
        /* @var $filterColumn string */
        /* @var $filterValue string */
        /* @var $currentOrderBy string */
        /* @var $currentOrderWay string */
        /* @var $tableColumns Array */
        foreach ($tableColumns as $column => $table){
            ?>
            <th>
                <?php
                switch ($table['type']){
                    case 'text':
                        echo '<input type="text" name="'.$column.'" class="filter_input" '.($filterColumn == $column?'value="'.$filterValue.'"':'').'>';
                        break;
                    case 'select':
                        echo '<select name="'.$column.'" class="filter_input">';
                        foreach ($table['options'] as $option){
                            foreach ($option as $optionValue => $optionName){
                                echo '<option value="'.$optionValue.'" '.(($filterColumn == $column&&$filterValue == $optionValue)?'selected':'').'>'.$optionName.'</option>';
                            }
                        }
                        echo '</select>';
                        break;
                }
                ?>
            </th>
            <?php
        }
        ?>
        <th></th>
    </tr>
    <tr>
        <?php
        /* @var $currentOrderBy string */
        /* @var $currentOrderWay string */
        /* @var $tableColumns Array */
        foreach ($tableColumns as $column => $table){
            $orderWay = 'asc desc';

            $sortOrderWay = 'asc';
            if($currentOrderBy == $column){
                if($currentOrderWay == 'asc'){
                    $sortOrderWay = 'desc';
                    $orderWay = 'desc';
                }else{
                    $orderWay = 'asc';
                }
            }

            ?>
            <th>
                <a href="index.php?page=1&order_by=<?=$column?>&order_way=<?=$sortOrderWay?>" class="orderby_link <?=$orderWay?>">
                    <?=$table['label']?>
                </a>
            </th>
            <?php
        }
        ?>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php
    /* @var $employees Array */
    foreach ($employees as $employee){
        /* @var $employee EmployeeModel */
        ?>
        <tr data-employeenum="<?=$employee->getEmpNo()?>">
            <td>
                <?=$employee->getFirstName()?>
            </td>
            <td>
                <?=$employee->getLastName()?>
            </td>
            <td>
                <?=$employee->getHireDate()?>
            </td>
            <td>
                <?=$employee->getDepartment()->getDeptName()?>
            </td>
            <td>
                <?=$employee->getTitle()->getTitle()?>
            </td>
            <td>
                <a class="action_btn" href="index.php?view=form&id_employee=<?=$employee->getEmpNo()?>">Szerkesztés</a>
                <a class="action_btn" href="index.php?view=form&id_employee=<?=$employee->getEmpNo()?>&delete=1">Törlés</a>
            </td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>

<div id="pagination">
    <?php
    /* @var $numberOfPages int */
    /* @var $startPagination int */
    /* @var $currentPage int */
    /* @var $pageLinksMax int */
    /* @var $pageLinksShown int */

    for($i = $startPagination;$i <= $numberOfPages;$i++){
        if($startPagination != 1 && $i == $startPagination){
            ?>
            <a href="index.php?page=1&order_by=<?=$currentOrderBy?>&order_way=<?=$currentOrderWay?><?=($filterValue!=''&&$filterColumn!=''?"&filter_column=".$filterColumn."&filter_value=".$filterValue:"")?>" class="paginate_link <?=($currentPage == $i?'current':'')?>">1</a> ...
            <?php
        }

        if($pageLinksShown < $pageLinksMax){
            ?>
            <a href="index.php?page=<?=$i?>&order_by=<?=$currentOrderBy?>&order_way=<?=$currentOrderWay?><?=($filterValue!=''&&$filterColumn!=''?"&filter_column=".$filterColumn."&filter_value=".$filterValue:"")?>" class="paginate_link <?=($currentPage == $i?'current':'')?>"><?=$i?></a>
            <?php
        }else{
            $i = $numberOfPages;
            ?>
            ... <a href="index.php?page=<?=$i?>&order_by=<?=$currentOrderBy?>&order_way=<?=$currentOrderWay?><?=($filterValue!=''&&$filterColumn!=''?"&filter_column=".$filterColumn."&filter_value=".$filterValue:"")?>" class="paginate_link <?=($currentPage == $i?'current':'')?>"><?=$i?></a>
            <?php
        }
        $pageLinksShown++;
    }
    ?>
</div>
