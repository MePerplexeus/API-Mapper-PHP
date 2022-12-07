<?php

function sqlf_dt() {
    return date("Y-m-d H:i:s");
}

function sql_init($h, $u, $p, $db) {
    define('DB_HOST', $h);
    define('DB_USER', $u);
    define('DB_PASS', $p);
    define('DB_TABLE', $db);
}


function presuf(&$value, $key, $count) {
    $ps = '`';
    $pse = ($key < ($count-1)) ? '`, ' : '`';
    $value = $ps . esc_str($value) . $pse;
}

function conditionString($conditions, $link) {
    $s = [];
    foreach ($conditions as $column => $value) {
        array_push($s, "`".esc_str($column)."`='".esc_str($value)."'");
    }
    return implode(' AND ', $s);
}

function esc_str($str) {
    // SET LINK
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_TABLE);
    return mysqli_real_escape_string($link, $str);
}

function sqlCustom($query, $type="SELECT", $charset=false) {
    
    // SET LINK
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_TABLE);

    if ($charset) {
        mysqli_set_charset($link, $charset);
    }

    if ($res = mysqli_query($link, $query)) {
        
        $output = [
            "detail" => [
                "output" => $res, // rows
                "query" => $query,
                "error" => "There were no errors",
            ],
            "result" => true,   
            "message" => "Successful sqliQuery!",   
        ];

        if ($type === "SELECT") {
            if (mysqli_num_rows($res) > 0) {
                $rows = mysqli_fetch_all($res);
            } else {
                $rows = [];
                $output['result'] = false;
                $output['Message'] = "Failed to fetch rows";
            }
            $output['detail']['rows'] = $rows;
            $output['detail']['count'] = mysqli_num_rows($res);

        } elseif ($type === "INSERT") {
            $output['detail']['row_id'] = mysqli_insert_id($link);

        } elseif ($type === "UPDATE") {
            $output['detail']['affected'] = mysqli_affected_rows($link);

        } elseif ($type === "DELETE") {
            $output['detail']['affected'] = mysqli_affected_rows($link);

        }
        return $output;
        
    }
    
    return [
        "detail" => [
            "output" => $res,
            "row_id" => mysqli_insert_id($link),
            "affected" => mysqli_affected_rows($link),
            "query" => $query,
            "error" => mysqli_error($link),
        ],
        "result" => false,   
        "message" => "Failed sqliQuery!",   
    ];

}

function sqlCrt($items, $table) {
    // If successful insert
    /*returns [
        "detail" => [
            "rowID" => row ID of the created entry,
            "tablename" => tablename,
            "error" => "There were no errors",
        ],
        "result" => true,   
        "message" => "Successful Insert!",   
    ] */
    // else
    /*returns [
        "detail" => [
            "rowID" => 0,
            "tablename" => tablename,
            "error" => the error,
        ],
        "result" => false,   
        "message" => "Failed Insert!",   
    ] */

    // SET LINK
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_TABLE);
    
    $cols = [];
    $vals = [];

    foreach ($items as $column => $value) {
        array_push($cols, "`".$column."`");
        array_push($vals, "'".esc_str($value)."'");
    }

    $query = "INSERT INTO `" . esc_str($table) . "` ( " . esc_str(implode(', ', $cols)) . " ) VALUES ( " . implode(', ', $vals) . " )";

    if ($res = mysqli_query($link, $query)) {
        
        $last_id = mysqli_insert_id($link);
        return [
            "detail" => [
                "rowID" => $last_id,
                "tablename" => $table,
                "error" => "There were no errors",
            ],
            "result" => true,   
            "message" => "Successful Insert!",   
        ];
        
    }
    
    return [
        "detail" => [
            "rowID" => 0,
            "tablename" => $table,
            "error" => mysqli_error($link),
        ],
        "result" => false,   
        "message" => "Failed Insert!",   
    ];

}

function sqlGet($item_col, $table, $conditions=[]) {
    // $res['result'][row:0][col_value:0]
    /*returns [
        "count" => number of rows in result,
        "result" => [
            all rows array as result
            $rows [
                row1 [
                    value1,
                    value2,
                    value3,
                ],
            ]
        ],   
        "message" => "Successful Fetch!" / error message,   
    ] */

    // SET LINK
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_TABLE);

    if (is_array($item_col)) {
        array_walk($item_col, "presuf", count($item_col));
        $item_cols = implode("", $item_col);
    } else {
        $item_cols = '`'.$item_col.'`';
    }

    $conditions = conditionString($conditions, $link);
    
    
    $query = 'SELECT '.esc_str($item_cols).' FROM `'.esc_str($table)."`".(($conditions !== "") ? (' WHERE '.$conditions) : '');

    if ($uidd = mysqli_query($link, $query)) {
        
        if (mysqli_num_rows($uidd) > 0) {

            $rows = mysqli_fetch_all($uidd);

            return [
                "count" => mysqli_num_rows($uidd),
                "result" => $rows,
                "message" => "Successful Fetch!",
            ];

        } else {

            $error = "There were error(s) [SUB]: \n";

            return [
                "count" => 0,
                "result" => [],
                "message" => $error . mysqli_error($link).'\n'.$query,
            ];

        }

    } else {

        $error = "There were error(s) [MAIN]: \n";

        return [
            "count" => 0,
            "result" => [],
            "message" => $error . mysqli_error($link).'\n'.$query,
        ];

    }

    echo $query;

}

function sqlUpd($table, $conditions, $items) {
    // $table = 'table_name'
    // $conditions = [
    //     "column_name" => "value"
    // ]
    // $items = [
    //     "column_name" => "value"
    // ]
    

    // SET LINK
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_TABLE);
    
    function partialQueryStringGenerator($items, $link, $conditions=false) {
        $s = [];
        foreach ($items as $column => $value) {
            array_push($s, "`".esc_str($column)."`='".esc_str($value)."'");
        }
        return ($conditions) ? implode(' AND ', $s) : implode(', ', $s);
    }

    $items = partialQueryStringGenerator($items, $link);
    $conditions = partialQueryStringGenerator($conditions, $link, true);

    $query = "UPDATE `" . esc_str($table) . "` SET" . $items . (($conditions !== "") ? (' WHERE '.$conditions) : '');

    if ($uidd = mysqli_query($link, $query)) {
        // Row Updated Successfully
        $affectedRowCount = mysqli_affected_rows($link);
        return [
            "updated" => $affectedRowCount,
            "result" => [
                true,
                "Row(s) Successfully Updated In `".$table."`",
                mysqli_error($link),
                $query,
            ],
            "message" => "Row(s) Successfully Updated In `".$table."`",
        ];
    }

    // Unexpected error occured while trying to update the row
    $affectedRowCount = mysqli_affected_rows($link);
    return [
        "updated" => $affectedRowCount,
        "result" => [
            false,
            "Unexpected error occured while trying to update the row(s)",
            mysqli_error($link),
            $query,
        ],
        "message" => "Unexpected error occured while trying to delete the row(s)\n" . mysqli_error($link).'\n'.$query,
    ];

}

function sqlDel($table, $conditions) {
    // $table = 'table_name'
    // $conditions = [
    //     "column_name" => "value"
    // ]
    

    // SET LINK
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_TABLE);

    $conditions = conditionString($conditions, $link);

    $query = "DELETE FROM `" . esc_str($table) . "`".(($conditions !== "") ? (' WHERE '.$conditions) : '');

    if ($uidd = mysqli_query($link, $query)) {
        // Row Deleted Successfully
        $affectedRowCount = mysqli_affected_rows($link);
        return [
            "deleted" => $affectedRowCount,
            "result" => [
                true,
                "Row(s) Successfully Deleted From `".$table."`",
                mysqli_error($link),
                $query,
            ],
            "message" => "Row(s) Successfully Deleted From `".$table."`",
        ];
    }

    // Unexpected error occured while trying to delete the row
    $affectedRowCount = mysqli_affected_rows($link);
    return [
        "deleted" => $affectedRowCount,
        "result" => [
            false,
            "Unexpected error occured while trying to delete the row",
            mysqli_error($link),
            $query,
        ],
        "message" => "Unexpected error occured while trying to delete the row\n" . mysqli_error($link).'\n'.$query,
    ];

}


// IMPORTS_CHECK
import_check('SQL Connect Library Loaded!', true);

?>