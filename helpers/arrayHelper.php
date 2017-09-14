<?php
/**
 * Created by PhpStorm.
 * User: trilok
 * Date: 28/11/16
 * Time: 7:02 PM
 */

function printArr($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

function array_push_assoc($oldArr, $newKey, $newval)
{
    return array_merge($oldArr, array("{$newKey}" => "{$newval}"));
}


function my_array_search($array, $key, $value)
{
    $results = array();
    if (is_array($array)) {
        if (isset($array[$key]) && $array[$key] == $value) {
            $results[] = $array;
        }
        foreach ($array as $subarray) {
            $results = array_merge($results, my_array_search($subarray, $key, $value));
        }
    }
    return $results;
}


function array_sort_by_column(&$arr, $col, $dir) {
    $sort_col = array();
    foreach ($arr as $key=> $row) {
        $sort_col[$key] = $row[$col];
    }

    array_multisort($sort_col, $dir, $arr);
}


function sortBy($field, &$array, $direction = 'asc')
{
    usort($array, create_function('$a, $b', '
		$a = $a["' . $field . '"];
		$b = $b["' . $field . '"];

		if ($a == $b)
		{
			return 0;
		}

		return ($a ' . ($direction == 'desc' ? '>' : '<') .' $b) ? -1 : 1;
	'));

    return true;
}



function array_merge_numeric_values()
{
    $arrays = func_get_args();
    $merged = array();
    foreach ($arrays as $array)
    {
        foreach ($array as $key => $value)
        {
            if ( ! is_numeric($value))
            {
                continue;
            }
            if ( ! isset($merged[$key]))
            {
                $merged[$key] = $value;
            }
            else
            {
                $merged[$key] += $value;
            }
        }
    }
    return $merged;
}



function search_arr($array, $key, $value)
{
    $results = array();

    if (is_array($array)) {
        if (isset($array[$key]) && $array[$key] == $value) {
            $results[] = $array;
        }

        foreach ($array as $subarray) {
            $results = array_merge($results, $this->search_arr($subarray, $key, $value));
        }
    }

    return $results;
}
?>