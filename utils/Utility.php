<?php
namespace Revaycolizer\Utils;

class Utility{

    public static function safeQuery($query, $params = [], $query_type = 'SELECT', $one_row = null)
    {
        global $db;
        $conn = $db;

        try {
            if ($query_type == 'SELECT') {
                $result = $conn->executeQuery($query, $params);
            } else {
                $affectedRows = $conn->executeStatement($query, $params);
            }
        } catch (\Throwable $e) {
            error_log("Failed Query: $query. Error: " . $e->getMessage());
            throw new \Exception($e->getMessage());
        }

        if ($query_type == 'INSERT') {
            return $conn->lastInsertId();
        } elseif ($query_type == 'SELECT') {
            return $one_row ? $result->fetchAssociative() : $result->fetchAllAssociative();
        } else {
            return true;
        }
    }

     /**
     *
     * Prepare data before inserting, the output of this function is expected to be a
     * clean insert statement. General assumption is that field names on post corresponds to
     * table columns on the database
     * @param $table
     * @param $post_array
     *@return array{query: string, params: array}
     */
    public static function safePrepareInsertQuery(string $table, array $post_array)
    {
        $fields = [];
        $params = [];

        foreach ($post_array as $key => $value) {
            $value = strval($value);

            if ($value === '0' || (!empty($value) && $value !== 'null')) {
                $fields[] = "`$key` = ?";
                $params[] = $value;
            }
        }

        $fieldsStr = implode(', ', $fields);

        $query = "INSERT INTO `$table` SET $fieldsStr";

        return [
            'query' => $query,
            'params' => $params
        ];
    }

    public static function insert($table, $array_data)
    {
        $q = self::safePrepareInsertQuery($table, $array_data);
        return self::safeQuery($q['query'], $q['params'], 'INSERT');
    }

    /**
     * @param $table
     * @param $id
     * @param $post_array
     * @param $id_column
     * @return array{query: string, params: array}
     */
    public static function safePrepareUpdateQuery($table, $id, $post_array, $id_column = 'id')
    {
        $fields = [];
        $params = [];

        foreach ($post_array as $key => $value) {

            if ($value !== null) {
                $fields[] = "`$key` = ?";
                $params[] = $value;
            } else {
                $fields[] = "`$key` = NULL";
            }
        }

        $setClause = implode(', ', $fields);

        $query = "UPDATE `$table` SET $setClause WHERE `$id_column` = ?";
        $params[] = $id;

        return [
            'query' => $query,
            'params' => $params
        ];
    }

    /**
     * Updates a a row with a given key-value pair
     * @param String $table
     * @param int $id
     * @param Array $array_data
     * @return boolean
     * @throws Exception
     */
    public static function update($table, $id, $array_data)
    {
        $q = Utility::safePrepareUpdateQuery($table, $id, $array_data);
        try {
            return Utility::safeQuery($q['query'],$q['params'], "UPDATE");
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function delete($table, $id, $id_column_name = 'id')
    {
        $q = "DELETE FROM {$table} WHERE {$id_column_name} = ?";
        return Utility::safeQuery($q,[$id], "DELETE");
    }

      /**
     * UI Notifications (SWAL)
     * @param $text
     * @param string $type
     * @param null $title
     * @param int $buttons
     */
     public static function notify($text, $type = 'success', $title = null, $buttons = 1)
    {
    
        if ($title === null) {
            echo '<script>Swal.fire("' . $text . '"); </script>';
        } else {
            if (is_null($buttons)) {
                echo '<script>Swal.fire({html:"' . $text . '",title:"' . $title . '",icon:"' . $type . '", allowOutsideClick: true, showConfirmButton: false}); </script>';
            } else {
                echo '<script>Swal.fire({html:"' . $text . '",title:"' . $title . '",icon:"' . $type . '", showConfirmButton: true}); </script>';
            }
        }
    }

}