<?php

/**
 * Created by PhpStorm.
 * User: dinesh
 * Date: 7/9/17
 * Time: 11:53 AM
 */
class Pagination
{
    public $connection = "";

    function __construct()
    {
        $this->connection = new DB("dbSystem", 'FALSE');
    }

    /**
     * @param $filtersArr
     * @return string
     *
     * 1] for = input is $filtersArr["columnName"]=$value;
     *    for = 2nd method input is $filtersArr["columnName"]=array("operator",$value);
     *    example $filtersArr["id"]=array("=",10);
     *
     * 2] for LIKE,NOT LIKE,NOT MATCHES input is $filtersArr["columnName"]=array("LIKE",$value);
     *    example $filtersArr["id"]=array("LIKE","'%$value%'");
     *
     * 3] for IN input is $filtersArr["columnName"]=array("IN",$value);
     *    example $filtersArr["id"]=array("IN","('10','11','12','13')");
     *
     * 4] for NOT IN input is $filtersArr["columnName"]=array("NOT IN",$value);
     *    example $filtersArr["id"]=array("NOT IN","('10','11','12','13')");
     *
     * 5] for NOT IN input is $filtersArr["columnName"]=array("NOT IN",$value);
     *    example $filtersArr["id"]=array("NOT IN","('10','11','12','13')");
     *
     * 6] for <,>,<=,>=,!=,<> input is $filtersArr["columnName"]=array("any above operator",$value);
     *    example $filtersArr["id"]=array("any above operator",10);
     *
     * 7] for BETWEEN input is $filtersArr["columnName"]=array("BETWEEN",$value1,$value2);
     *    example $filtersArr["id"]=array("BETWEEN",10,100);
     *
     * 8] for MATCH AGAINST input is $filtersArr["columnName"]=array("MATCH",$value1,$value2);
     *    example $filtersArr["id"]=array("MATCH","(head, body)","('some words' IN BOOLEAN MODE)");
     */

    function contains_array($array)
    {
        foreach ($array as $value) {
            if (is_array($value)) {
                return true;
            }
        }
        return false;
    }

    function buildFilterQuery($filtersArr)
    {
        $buildFilters = "";
        foreach ($filtersArr as $key => $val) {
            if (gettype($val) == "array") {
                if ($this->contains_array($val)) {
                    $tempFilter = "";
                    foreach ($val as $values) {
                        $operator = strtolower($values[0]);
                        $notin = array("between", "match");
                        if (!in_array($operator, $notin)) {
                            $tempFilter = $this->handle_SingleOperator($values[1], $tempFilter, $key, $operator);
                        } else {
                            if ($operator == "between") {
                                $tempFilter = $this->handle_BETWEEN($values[1], $tempFilter, $key);
                            }

                            if ($operator == "match") {
                                $tempFilter = $this->handle_MATCH($values[1], $tempFilter, $key);
                            }
                        }
                    }
                } else {
                    $operator = strtolower($val[0]);
                    $notin = array("between", "match");

                    if (!in_array($operator, $notin)) {
                        $buildFilters = $this->handle_SingleOperator($val[1], $buildFilters, $key, $operator);
                    } else {

                        if ($operator == "between") {
                            $buildFilters = $this->handle_BETWEEN($val, $buildFilters, $key);
                        }

                        if ($operator == "match") {
                            $buildFilters = $this->handle_MATCH($val, $buildFilters, $key);
                        }
                    }
                }
            } else {
                if ($val != "") {
                    $buildFilters = $this->handle_SingleOperator($val, $buildFilters, $key, "=");
                }
            }

        }
        if ($buildFilters != "") {
            if($tempFilter!="")
            {
                $buildFilters .= $tempFilter;
            }
            $buildFilters .= " 1=1";
        }

        return $buildFilters;
    }

    function handle_MATCH($val, $buildFilters, $key)
    {
        if ($val[1] != "" && $val[2] != "") {
            if (gettype($val[1]) == "integer" || gettype($val[1]) == "int") {
                $buildFilters .= "{$key} MATCH {$val[1]} AGAINST {$val[2]} AND ";
            }

            if (gettype($val[1]) == "double" || gettype($val[1]) == "float") {
                $buildFilters .= "{$key} MATCH {$val[1]} AGAINST {$val[2]} AND ";
            }

            if (gettype($val[1]) == "string") {
                $buildFilters .= "{$key} MATCH {$val[1]} AGAINST {$val[2]} AND ";
            }
        }
        return $buildFilters;
    }

    function handle_BETWEEN($val, $buildFilters, $key)
    {
        if ($val[1] != "" && $val[2] != "") {
            if (gettype($val[1]) == "integer" || gettype($val[1]) == "int") {
                $buildFilters .= "{$key} BETWEEN ({$val[1]} AND {$val[2]}) AND ";
            }

            if (gettype($val[1]) == "double" || gettype($val[1]) == "float") {
                $buildFilters .= "{$key} BETWEEN ({$val[1]} AND {$val[2]}) AND ";
            }

            if (gettype($val[1]) == "string") {
                $buildFilters .= "{$key} BETWEEN ({$val[1]} AND {$val[2]}) AND ";
            }
        }
        return $buildFilters;
    }

    function handle_SingleOperator($val, $buildFilters, $key, $operator)
    {
        if ($val != "") {

            if (gettype($val) == "integer" || gettype($val) == "int") {
                $buildFilters .= "{$key} {$operator} {$val} AND ";
            }

            if (gettype($val) == "double" || gettype($val) == "float") {
                $buildFilters .= "{$key} {$operator} {$val} AND ";
            }

            if (gettype($val) == "string") {
                $buildFilters .= "{$key} {$operator} {$val} AND ";
            }
        }

        return $buildFilters;
    }


    function getTableCount($tableName, $filtersArr) //get table rows count
    {

        $filter = $this->buildFilterQuery($filtersArr);
        if ($filter != "") {
            $query = "SELECT COUNT(*) as count FROM {$tableName} where {$filter};";
        } else {
            $query = "SELECT COUNT(*) as count FROM {$tableName};";
        }

        return $this->connection->query($query);

    }

    function getTableData($tableName, $filtersArr, $page_position, $item_per_page, $orderBy, $columnNames = "*")
    {
        $filter = $this->buildFilterQuery($filtersArr);
        $columnNames = $this->getColumnNames($columnNames);
        if ($filter != "") {
            $query = "SELECT {$columnNames} FROM {$tableName} where {$filter} ORDER BY {$orderBy} LIMIT $page_position, $item_per_page";
        } else {
            $query = "SELECT {$columnNames} FROM {$tableName} ORDER BY {$orderBy} LIMIT $page_position, $item_per_page";
        }

        return $this->connection->query($query);

    }

    function getColumnNames($columnNames)
    {
        if (gettype($columnNames) == "array") {
            $columnNameData = "";
            foreach ($columnNames as $val) {
                $columnNameData .= $val . ",";
            }
            $columnNames = rtrim($columnNameData, ",");
        } else {
            if ($columnNames == "" || $columnNames == "*") {
                $columnNames = "*";
            }
        }

        return $columnNames;
    }

    function getPaginationDataForTable($limit, $tableName, $filtersArr, $orderBy, $columns = "*")
    {

        $resultsData = array();
//Get page number from Ajax
        if (isset($_POST["pageno"])) {
            $page_number = (int)filter_var($_POST["pageno"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
            if (!is_numeric($page_number)) {
                die('Invalid page number!');
            } //incase of invalid page number
        } else {
            $page_number = 1; //if there's no page number, set it to 1
        }
        if ($page_number == 0) {
            $page_number = 1;
        }
        $item_per_page = $limit;
        $get_total_rows = $this->getTableCount($tableName, $filtersArr)["data"]["result"][0]["count"];
        $total_pages = ceil($get_total_rows / $item_per_page);

//position of records
        $page_position = (($page_number - 1) * $item_per_page);
        $lastpage = ceil($total_pages);


        $results = $this->getTableData($tableName, $filtersArr, $page_position, $item_per_page, $orderBy, $columns);
        $results = $results["data"]["result"];
        $count = count($results);

        if ($count == 0) {
            $page_number = $page_number - 1; //if there's no page number, set it to 1
            $item_per_page = $limit;
            $get_total_rows = $this->getTableCount($tableName, $filtersArr)["data"]["result"][0]["count"];

            $total_pages = ceil($get_total_rows / $item_per_page);

//position of records
            $page_position = (($page_number - 1) * $item_per_page);
            $lastpage = ceil($total_pages);
            $checkStr = substr($page_position, 0, 1);
            if ($checkStr == "-") {
                $results = array();
            } else {
                $results = $this->getTableData($tableName, $filtersArr, $page_position, $item_per_page, $orderBy, $columns);
                $results = $results["data"]["result"];
            }


        }

        $resultsData["result"] = $results;
        $resultsData["lastpage"] = $lastpage;
        $resultsData["page_number"] = $page_number;
        $resultsData["get_total_rows"] = $get_total_rows;
        $resultsData["item_per_page"] = $item_per_page;
        return $resultsData;
    }

    function buildPageParameters($filtersArr)
    {
        $buildFilters = "";
        foreach ($filtersArr as $key => $val) {
            $buildFilters .= "'$val'" . ",";
        }
        return rtrim($buildFilters, ",");
    }

    function getPaginationDataJs($lastpage, $pageno, $limit, $filtersArr, $Fname)
    {
        ?>
        <span class="pull-left recordCountsShow-styled-select"> Show
            <select id="LimitedResult">
                 <option value="5" <?php if ($limit == 5) {
                     echo "selected";
                 } ?>> 5 </option>
                    <option value="10" <?php if ($limit == 10) {
                        echo "selected";
                    } ?>> 10 </option>
                    <option value="20" <?php if ($limit == 20) {
                        echo "selected";
                    } ?>> 20 </option>
                    <option value="30" <?php if ($limit == 30) {
                        echo "selected";
                    } ?>> 30 </option>
                    <option value="40" <?php if ($limit == 40) {
                        echo "selected";
                    } ?>> 40 </option>
                    <option value="50" <?php if ($limit == 50) {
                        echo "selected";
                    } ?>> 50 </option>
                </select>
            </span>
        </div>
        <?php
        $filtersArr["limit"] = $limit;
        echo '<input type="text" id="hiddenagentpage" name="hiddenagentpage" value="' . $pageno . '" hidden>';
        echo '<div style="" class="box-footer clearfix">';
        echo '<ul class="pagination pagination-sm no-margin pull-right" style="font-weight: bold">';


        if ($pageno > 1) {

            $pagenum = 1;
            $filtersArr["pageNumber"] = $pagenum;
            $query = $this->buildPageParameters($filtersArr);
            print('<li><a href="#" onclick=' . $Fname . '(' . $query . ')>&laquo;</a></li>');
        }

        if ($pageno > 1) {
            $pagenumber = $pageno - 1;
            $filtersArr["pageNumber"] = $pagenumber;
            $query = $this->buildPageParameters($filtersArr);
            print('<li><a href="#" onclick=' . $Fname . '(' . $query . ')>Previous</a></li>');
        }

        if ($pageno == 1) {
            $startLoop = 1;
            $endLoop = ($lastpage < 5) ? $lastpage : 5;
        } else if ($pageno == $lastpage) {
            $startLoop = (($lastpage - 5) < 1) ? 1 : ($lastpage - 5);
            $endLoop = $lastpage;
        } else {
            $startLoop = (($pageno - 3) < 1) ? 1 : ($pageno - 3);
            $endLoop = (($pageno + 3) > $lastpage) ? $lastpage : ($pageno + 3);
        }

        for ($i = $startLoop; $i <= $endLoop; $i++) {
            if ($i == $pageno) {
                print('   <li class = "active"><a href = "#">' . $pageno . '</a></li>');
            } else {
                $pagenumber = $i;
                $filtersArr["pageNumber"] = $pagenumber;
                $query = $this->buildPageParameters($filtersArr);
                print('<li><a href="#" onclick=' . $Fname . '(' . $query . ')>' . $i . '</a></li>');
            }
        }
        if ($pageno < $lastpage) {
            $pagenumber = $pageno + 1;
            $filtersArr["pageNumber"] = $pagenumber;
            $query = $this->buildPageParameters($filtersArr);
            print('<li><a href="#" onclick=' . $Fname . '(' . $query . ')>Next</a></li>');

        }

        if ($pageno != $lastpage) {
            $filtersArr["pageNumber"] = $lastpage;
            $query = $this->buildPageParameters($filtersArr);
            print('<li><a href="#" onclick=' . $Fname . '(' . $query . ')>&raquo;</a></li>');
        }
        echo '</ul>';
        echo '</div>';
    }

}
