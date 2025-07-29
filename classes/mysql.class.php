<?php
if (!isset($_SESSION)) session_start();
include_once("config.inc.php");
class mysql
{
    protected $con;
    public $debug = false;

    function connect($db_name = null)
    {
        $this->con = mysqli_connect(ENV::DB_HOST, ENV::DB_USERNAME, ENV::DB_PASSWORD);
        mysqli_select_db($this->con, $db_name);
    }

    function query($query)
    {
        if (!$query) return null;

        $rs = mysqli_query($this->con, $query);
        if (mysqli_error($this->con)) {
            dump2($query);
            debug();
        }
        return $rs;
    }

    function commit()
    {
        $query = mysqli_query($this->con, "COMMIT");
        return $query;
    }

    function begin()
    {
        $query = mysqli_query($this->con, "BEGIN");
        return $query;
    }
    function rollback()
    {
        $query = mysqli_query($this->con, "ROLLBACK");
        return $query;
    }

    function fetch_array($query)
    {
        if (!$query) return null;
        $query = mysqli_fetch_array($query);
        return $query;
    }

    function fetch_assoc($query)
    {
        if (!$query) return null;
        $query = mysqli_fetch_assoc($query);
        return $query;
    }

    function fetch_row($query)
    {
        $query = mysqli_fetch_row($query);
        return $query;
    }

    function num_rows($query)
    {
        if (!$query) return null;
        $query = mysqli_num_rows($query);
        return $query;
    }

    //for insert and get binary file purpose
    function insert_id()
    {
        $query = mysqli_insert_id($this->con);
        return $query;
    }

    function result($result, $int, $value)
    {
        if (mysqli_num_rows($result) > 0) {
            $query = mysqli_result($result, $int, $value);
            return $query;
        } else {
            return '';
        }
    }

    function free_result($result)
    {
        $query = mysqli_free_result($result);
        return $query;
    }

    function escape($string)
    {
        $string = mysqli_real_escape_string($this->con, $string);
        return $string;
    }

    function PromptMsg($msg)
    {
        echo "<div align=center><font color=red face=tahoma style='FONT-SIZE: 12px;'>" . $msg . "</font></div><br>";
        echo "<div align=center><a href='javascript:history.go(-1);'><font face=tahoma style='FONT-SIZE: 13px;'>Go Back</a></div>";
        exit;
    }

    function close()
    {
        // static::$pcon = null;
        // mysqli_close($this->con);
    }


    /*
    NEW FUNCTION ADDED BY THOR 12/14/2021
    Refer to Laravel CRUD Style
  */
    function insert_from_arr($table_name, $arr)
    {
        $columns_arr = [];
        $values_arr = [];

        foreach ($arr as $k => $v) {
            if (
                is_numeric($v)
                && substr($v, 0, 1) != '0' // PREVENT Postcode & IC issue
                && stripos($v, 'e') === false
            ) {
                $value = $v;
            } elseif (is_array($v)) {
                $value = count($v) == 0 ? 'null' : implode(',', $v);
                if ($value != 'null') $value = "'$value'";
            } elseif ($v === null) {
                $value = 'null';
            } else {
                $value = '"' . $this->escape($v) . '"';
            }

            $columns_arr[] = "`$k`";
            $values_arr[] = $value;
        }

        $columns = implode(',', $columns_arr);
        $values = implode(',', $values_arr);

        if (strpos($table_name, '.') !== false) {
            $sql = "INSERT INTO " . $table_name . " ($columns) VALUES ($values)";
        } else {
            $sql = "INSERT INTO `" . $table_name . "` ($columns) VALUES ($values)";
        }

        $this->SQL_EXECUTED[] = $sql;
        mysqli_query($this->con, $sql);

        //check primary

        $id = mysqli_insert_id($this->con);
        if (mysqli_error($this->con)) {
            dump2("MYSQL ERROR INSERT: " . mysqli_error($this->con));
            dump2($sql);
            debug();
        }


        $changes_logs = new ChangesLogs;
        $changes_logs->insertAddLogs($table_name, $arr);


        return $id;
    }

    /*
    Shorter name for insert_from_arr
  */
    function insert($table_name, $arr)
    {
        return $this->insert_from_arr($table_name, $arr);
    }


    function update_from_arr_by_id($table_name, $arr, $id, $id_name = 'id')
    {
        $update_arr = [];

        foreach ($arr as $k => $v) {
            if (is_numeric($v)) {
                $value = $v;
            } elseif (is_array($v)) {
                $value = count($v) == 0 ? 'null' : "'" . implode(',', $v) . "'";
            } elseif ($v == null) {
                $value = 'null';
            } else {
                $value = '"' . $v . '"';
            }
            $update_arr[] = " `$k` = $value ";
        }

        $update = implode(',', $update_arr); //update 6 Dec 21

        if (strpos($table_name, '.')) {
            $table_arr = explode('.', $table_name);
            $str_table_name =   $table_arr[0] . '.' . $table_arr[1];
        } else {
            $str_table_name = "`$table_name`";
        }

        // GET ORIGINAL 
        $changes_logs = new ChangesLogs;
        $changes_logs->setOriginal($table_name, [$id_name => $id]);

        $sql = "
      UPDATE $str_table_name SET
      $update
      WHERE `$id_name` = '$id'
    ";
        $this->SQL_EXECUTED[] = $sql;

        $data = mysqli_query($this->con, $sql);
        if (mysqli_error($this->con)) {
            dump2($sql);
            dump2("MYSQL ERROR UPDATE BY ID: " . mysqli_error($this->con));
        }

        // INSERT LOG
        $changes_logs->insertUpdateLogs($table_name, [$id_name => $id]);

        return $data;
    }

    /*
    Enhanced update function, allow custom key instead of id 
  */
    function update($table_name, $condition, $arr)
    {
        if (empty($condition)) {
            echo ('ERROR: update_or_insert\' $condition cannot be empty');
            return;
        }
        if (empty($arr)) {
            echo ('ERROR: update_or_insert\' $arr cannot be empty');
            return;
        }

        $update_arr = [];

        foreach ($arr as $k => $v) {
            if (
                is_numeric($v)
                && substr($v, 0, 1) != '0' // PREVENT Postcode & IC issue
            ) {
                $value = $v;
            } elseif (is_callable($v) && !is_string($v)) {
                // becareful using this due to it bypass the db escape below.
                // useful when we want to update the data with mysql function or based on another column data
                $value = $v();
            } elseif (is_array($v)) {
                $value = count($v) == 0 ? 'null' : "'" . implode(',', $v) . "'";
            } elseif ($v == null) {
                $value = 'null';
            } else {
                $value = '"' . $this->escape($v) . '"';
            }
            $update_arr[] = " `$k` = $value ";
        }

        $update = implode(',', $update_arr);

        if (strpos($table_name, '.')) {
            $table_arr = explode('.', $table_name);
            $str_table_name =   $table_arr[0] . '.' . $table_arr[1];
        } else {
            $str_table_name = "`$table_name`";
        }

        $sql_condition = '';
        foreach ($condition as $key => $val) {
            if (is_array($val)) {
                $sql_condition .= " AND $key IN (" . implode(',', $val) . ")";
            } else if ($val === null) {
                $sql_condition .= " AND $key IS NULL";
            } else {
                $sql_condition .= " AND $key = '$val'";
            }
        }


        // GET ORIGINAL 
        $changes_logs = new ChangesLogs;
        $changes_logs->setOriginal($table_name, $condition);

        $sql = "
      UPDATE $str_table_name SET
      $update
      WHERE 1 $sql_condition
    ";
        $this->SQL_EXECUTED[] = $sql;
        $data = mysqli_query($this->con, $sql);
        if (mysqli_error($this->con)) {
            dump($sql);
            dump2("MYSQL ERROR: UPDATE" . mysqli_error($this->con));
        }

        // INSERT LOG
        $changes_logs->insertUpdateLogs($table_name, $condition);

        return $data;
    }

    /*
    Enhanced update function, allow custom key instead of id 
  */
    function exists($table_name, $condition)
    {
        if (empty($condition)) {
            echo ('ERROR: update_or_insert\' $condition cannot be empty');
            return;
        }

        if (strpos($table_name, '.')) {
            $table_arr = explode('.', $table_name);
            $str_table_name =   $table_arr[0] . '.' . $table_arr[1];
        } else {
            $str_table_name = "`$table_name`";
        }

        $sql_condition = '';
        foreach ($condition as $key => $val) {
            if (is_array($val)) {
                $sql_condition .= " AND $key IN (" . implode(',', $val) . ")";
            } else if ($val === null) {
                $sql_condition .= " AND $key IS NULL";
            } else {
                $sql_condition .= " AND $key = '$val'";
            }
        }

        $sql = "
      SELECT * FROM $str_table_name  
      WHERE 1 $sql_condition
    ";
        $this->SQL_EXECUTED[] = $sql;
        $data = $this->first($sql);
        if (mysqli_error($this->con)) {
            dump($sql);
            dump2("MYSQL ERROR: Exists()" . mysqli_error($this->con));
        }
        return $data;
    }


    function delete_by_id($table_name, $id, $id_name = "id")
    {
        $db = new mysql;
        $db->connect();
        $sql = "DELETE FROM `$table_name` WHERE `$id_name` = $id ";
        $this->SQL_EXECUTED[] = $sql;
        $data = mysqli_query($this->con, $sql);
        if (mysqli_error($this->con)) {
            dump2("MYSQL ERROR: " . mysqli_error($this->con));
        }
        return $data;
    }

    /*
    Enhanced delete function, allow custom key instead of id 
  */
    function delete($table_name, $condition)
    {
        if (empty($condition)) {
            echo ('ERROR: DELETE \' $condition cannot be empty');
            return;
        }
        if (strpos($table_name, '.')) {
            $table_arr = explode('.', $table_name);
            $str_table_name =   $table_arr[0] . '.' . $table_arr[1];
        } else {
            $str_table_name = "`$table_name`";
        }

        $sql_condition = '';
        foreach ($condition as $key => $val) {
            if (is_array($val)) {
                $sql_condition .= " AND $key IN (" . implode(',', $val) . ")";
            } else {
                $sql_condition .= " AND $key = '$val'";
            }
        }
        if (empty($sql_condition)) {
            echo ('ERROR: DELETE \' $condition cannot be empty');
            return;
        }

        // GET ORIGINAL 
        $changes_logs = new ChangesLogs;
        $changes_logs->setOriginal($table_name, $condition);

        $sql = "
        DELETE FROM $str_table_name
        WHERE 1 $sql_condition
      ";

        $data = mysqli_query($this->con, $sql);
        if (mysqli_error($this->con)) {
            dump2("MYSQL ERROR DELETE: " . mysqli_error($this->con));
        } else {
            $changes_logs->insertDeleteLogs($table_name, $condition);
        }
        return $data;
    }

    function get($rs)
    {
        if (is_string($rs)) {
            $rs = $this->query($rs);
        } else {
            mysqli_data_seek($rs, 0);
        }

        if (is_bool($rs) && isDev()) {
            debug();
        }

        $data = [];
        while ($row = mysqli_fetch_assoc($rs)) {
            $data[] = $row;
        }
        return $data;
    }

    //by thor, 2022-09-02
    function paginate($sql)
    {
        $rs = $this->query($sql);

        //CALCULATE DATA Paginate Size
        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $results_per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 20;

        $number_of_result = mysqli_num_rows($rs);
        $number_of_page = ceil($number_of_result / $results_per_page);
        $page_first_result = ($page - 1) * $results_per_page;
        //END OF CALCULATE DATA Paginate Size

        //FETCH data with pagination
        $sql .= " LIMIT " . $page_first_result . ',' . $results_per_page;
        $rs = $this->query($sql);

        $data = [];
        while ($row = mysqli_fetch_assoc($rs)) {
            $data[] = $row;
        }

        //CREATE Pagination Data
        $links = [];
        for ($i = 1; $i <= $number_of_page; $i++) {
            $links[$i] = $i;
        }


        //take first 5 AND next 5
        $links_display = [];
        for ($x = 1; $x <= 5; $x++) {
            $index = $page - $x;
            if ($index == 1) continue; //first page is no need
            if (isset($links[$index])) {
                $links_display[$links[$index]] = $links[$index];
            }
        }

        if (isset($links[$page]) && $page != 1) {
            $links_display[$page] = $links[$page]; //own
        }

        for ($x = 1; $x <= 5; $x++) {
            $index = $page + $x;
            if (isset($links[$index])) {
                $links_display[$links[$index]] = $links[$index];
            }
        }

        ksort($links_display);
        // dd($links_display);
        //END OF take first 5 AND next 5

        $next_page = isset($links[$page + 1]) ? $links[$page + 1] : null;
        $prev_page = isset($links[$page - 1]) ? $links[$page - 1] : null;

        $arr = [
            "current_page" => $page,
            "links_display" => $links_display,
            "last_page" => end($links),
            "next_page" => $next_page,
            "per_page" => $results_per_page,
            "prev_page" =>  $prev_page,
            "total" => $number_of_result,
            "data" => $data,
        ];

        // $pagination = new Pagination($arr);
        return $arr;
    }
    //END OF pagination function

    function first($rs)
    {
        if (is_string($rs)) {
            $sql = $rs;
            $rs = $this->query($sql);
            if ($rs == false) {
                dump2("ERR: " . $sql);
                dump2("MYSQL ERROR FIRST: " . mysqli_error($this->con));
            }
        }

        //TODO VALIDATE IS RS
        $data = [];
        while ($row = mysqli_fetch_assoc($rs)) {
            $data[] = $row;
        }
        return count($data) > 0 ? current($data) : null;
    }

    function pluck($rs, $col_value, $col_key = '')
    {
        if (is_string($rs)) {
            $rs = $this->query($rs);
        } else {
            mysqli_data_seek($rs, 0);
        }

        $data = [];
        while ($row = mysqli_fetch_assoc($rs)) {
            $row_col_value = isset($row[$col_value]) ? $row[$col_value] : null;
            if (!empty($col_key)) {
                $data[$row[$col_key]] = $row_col_value;
            } else {
                $data[] = $row_col_value;
            }
        }
        return $data;
    }

    function update_or_insert($table, $condition, $arr)
    {
        if (empty($condition)) {
            echo ('ERROR: update_or_insert\' $condition cannot be empty');
            return;
        }
        if (empty($arr)) {
            echo ('ERROR: update_or_insert\' $arr cannot be empty');
            return;
        }

        $sql_check = "SELECT * FROM $table WHERE 1 ";
        foreach ($condition as $key => $val) {
            if ($val == null) {
                $sql_check .= " AND $key IS NULL";
            } else {
                $sql_check .= " AND $key = '$val'";
            }
        }
        $row_check = $this->first($sql_check);

        if ($row_check == null) {
            return $this->insert($table, $arr);
        } else {
            $result =  $this->update($table, $condition, $arr);
            if ($result === true) {
                $sql_primary_key = "SHOW KEYS FROM $table WHERE Key_name = 'PRIMARY'";
                $row_primary_key = $this->first($sql_primary_key);
                $primary_key = $row_primary_key['Column_name'];

                return $row_check[$primary_key];
            } else {
                return $result;
            }
        }
    }

    function insert_if_not_exists($table, $condition, $arr)
    {
        if (empty($condition)) {
            echo ('ERROR: insert_if_not_exists\' $condition cannot be empty');
            return;
        }
        if (empty($arr)) {
            echo ('ERROR: insert_if_not_exists\' $arr cannot be empty');
            return;
        }

        $sql_check = "SELECT * FROM $table WHERE 1 ";
        foreach ($condition as $key => $val) {
            if ($val == null) {
                $sql_check .= " AND $key IS NULL";
            } else {
                $sql_check .= " AND $key = '$val'";
            }
        }

        $row_check = $this->first($sql_check);

        if ($row_check == null) {
            return $this->insert($table, $arr);
        } else {
            return $row_check;
        }
    }

    function count_table_primary_key($table_name)
    {
        $db_name = $_SESSION['db_name'];
        $sql = "
      SELECT COUNT(k.column_name) as count_col
      FROM information_schema.table_constraints t
      JOIN information_schema.key_column_usage k
      USING(constraint_name,table_schema,table_name)
      WHERE t.constraint_type='PRIMARY KEY'
        AND t.table_name='$table_name'
        AND t.table_schema='$db_name';
    ";
        $check = $this->first($sql);
        return !empty($check) ? $check['count_col'] : 0;
    }

    function get_last_sql()
    {
        return end($this->SQL_EXECUTED);
    }
    function update_str($table_name, $condition, $arr)
    {
        if (empty($condition)) {
            echo ('ERROR: update_or_insert\' $condition cannot be empty');
            return;
        }
        if (empty($arr)) {
            echo ('ERROR: update_or_insert\' $arr cannot be empty');
            return;
        }

        $update_arr = [];

        foreach ($arr as $k => $v) {
            if (
                is_numeric($v)
                && substr($v, 0, 1) != '0' // PREVENT Postcode & IC issue
            ) {
                $value = $v;
            } elseif (is_array($v)) {
                $value = count($v) == 0 ? 'null' : "'" . implode(',', $v) . "'";
            } elseif ($v == null) {
                $value = 'null';
            } else {
                $value = '"' . $this->escape($v) . '"';
            }
            $update_arr[] = " `$k` = $value ";
        }

        $update = implode(',', $update_arr);

        if (strpos($table_name, '.')) {
            $table_arr = explode('.', $table_name);
            $str_table_name =   $table_arr[0] . '.' . $table_arr[1];
        } else {
            $str_table_name = "`$table_name`";
        }

        $sql_condition = '';
        foreach ($condition as $key => $val) {
            if (is_array($val)) {
                $sql_condition .= " AND $key IN (" . implode(',', $val) . ")";
            } else {
                $sql_condition .= " AND $key = '$val'";
            }
        }

        $sql = "
      UPDATE $str_table_name SET
      $update
      WHERE 1 $sql_condition
    ";

        return $sql;
    }

    function insert_str($table_name, $arr)
    {
        $columns_arr = [];
        $values_arr = [];

        foreach ($arr as $k => $v) {
            if (
                is_numeric($v)
                && substr($v, 0, 1) != '0' // PREVENT Postcode & IC issue
            ) {
                $value = $v;
            } elseif (is_array($v)) {
                $value = count($v) == 0 ? 'null' : implode(',', $v);
                $value = "'$value'";
            } elseif ($v === null) {
                $value = 'null';
            } else {
                $value = '"' . $this->escape($v) . '"';
            }

            $columns_arr[] = "`$k`";
            $values_arr[] = $value;
        }

        $columns = implode(',', $columns_arr);
        $values = implode(',', $values_arr);

        if (strpos($table_name, '.') !== false) {
            $sql = "INSERT INTO " . $table_name . " ($columns) VALUES ($values)";
        } else {
            $sql = "INSERT INTO `" . $table_name . "` ($columns) VALUES ($values)";
        }

        return $sql;
    }
}
