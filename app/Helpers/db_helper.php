<?php

if (!function_exists('db_fetch')) {
    /**
     * Fetch data from a specified table with optional filters and pagination.
     *
     * @param string $select The columns to select. Defaults to '*' (all columns).
     * @param string $table The name of the table to fetch data from.
     * @param array $where Optional associative array of conditions to filter the results.
     * @param string $order Optional column to order by.
     * @param string $by Optional order direction, 'ASC' or 'DESC'. Defaults to 'DESC'.
     * @param int $start Optional offset for pagination. Defaults to -1 (no offset).
     * @param int $limit Optional number of records to fetch. Defaults to 0 (no limit).
     * @param bool $return_array Whether to return results as an array. Defaults to true.
     * @return array|object|false Returns the result as an array if $return_array is true, 
     *                             or as an object if $return_array is false. Returns false on failure.
     */
    function db_fetch($select = '*', $table = '', $where = [], $order = '', $by = 'DESC', $start = -1, $limit = 0, $return_array = true)
    {
        // Validate table name
        if (empty($table)) {
            log_message('error', 'Table name is empty.');
            return false;
        }

        // Connect to the database
        $db = \Config\Database::connect();

        // Check if the table exists
        if (!$db->tableExists($table)) {
            log_message('error', 'Table ' . $table . ' does not exist.');
            return false;
        }

        try {
            $builder = $db->table($table);
            $builder->select($select);

            // Apply filters if provided
            if (!empty($where)) {
                $builder->where($where);
            }

            // Apply ordering if provided
            if ($order && in_array(strtoupper($by), ['DESC', 'ASC'])) {
                $builder->orderBy($order, strtoupper($by));
            }

            // Apply pagination if provided
            if ((int) $start >= 0 && (int)$limit > 0) {
                $builder->limit($limit, $start);
            }
            
            // Execute the query and fetch the results
            $query = $builder->get();
            

            // Return results in the desired format
            return $return_array ? $query->getResultArray() : $query->getResult();
        } catch (\Exception $e) {
            // Log any exceptions or errors with detailed message
            $message = 'Error fetching records from table ' . $table . ': ' . $e->getMessage();
            log_message('error', $message);
            _validation('error', $message);
            return false;
        }
    }
}

if (!function_exists('db_get')) {
    /**
     * Retrieve a single row of data from a specified table with optional filters and sorting.
     *
     * @param string $select The columns to select. Defaults to '*' (all columns).
     * @param string $table The name of the table from which to fetch data.
     * @param array $where Optional associative array of conditions to filter the results.
     * @param bool $return_array Whether to return the result as an associative array. Defaults to true.
     * @return array|object|false Returns the result as an associative array if $return_array is true, 
     *                             or as an object if $return_array is false. Returns false on failure.
     */
    function db_get($select = '*', $table = '', $where = [], $return_array = true)
    {
        // Validate table name
        if (empty($table)) {
            log_message('error', 'Table name is empty.');
            return false;
        }

        // Connect to the database
        $db = \Config\Database::connect();
        
        // Check if the table exists
        if (!$db->tableExists($table)) {
            log_message('error', 'Table ' . $table . ' does not exist.');
            return false;
        }

        try {
            $builder = $db->table($table);
            $builder->select($select);

            // Apply filters if provided
            if (!empty($where)) {
                $builder->where($where);
            }

            // Execute the query and fetch the result
            $query = $builder->get();

            // echo $db->getLastQuery();

            // Return the result in the desired format
            return $return_array ? $query->getRowArray() : $query->getRow();
        } catch (\Exception $e) {
            // Log any exceptions or errors with detailed message
            $message = 'Error fetching records from table ' . $table . ': ' . $e->getMessage();
            log_message('error', $message);
            _validation('error', $message);
            return false;
        }
    }
}

if (!function_exists("db_insert")) {
    /**
     * Insert records into a specified table.
     *
     * @param string $table The name of the table where records will be inserted.
     * @param array $data An associative array of data for a single record, or an array of associative arrays for multiple records.
     * @return mixed The insert ID of the single record if a single record is inserted, 
     *               true if multiple records are inserted successfully, 
     *               or false if the operation fails.
     */
    function db_insert($table = "", $data = [])
    {
        $db = \Config\Database::connect();

        // Check if the table exists
        if (!$db->tableExists($table)) {
            log_message('error', 'Table ' . $table . ' does not exist.');
            return false;
        }

        $builder = $db->table($table);

        // Ensure $data is an array. If not, convert it to an array.
        $data = (array) $data;
        if (!empty($data)) {
            // Start a transaction to ensure data integrity
            $db->transStart();
            // Insert the data into the table
            $result = $builder->insert($data);
            $insert_id = $db->insertID();
            // Complete the transaction
            $db->transComplete();
            if ($db->transStatus() === false) {
                $db_error = $db->error(); // Get error details from the database
                $message = 'Transaction failed while inserting records into table ' . $table;
                $message .= ' | DB Error: ' . json_encode($db_error); // Include the database error details
                log_message('error', $message);
                _validation('error', $message);
            }
            return $insert_id;
        } else {
            $message = 'No data provided for insertion into table ' . $table;
            log_message('error', $message);
            _validation('error', $message);
            // return false;
        }
    }
}

if (!function_exists("db_insert_batch")) {
    /**
     * Insert records into a specified table.
     *
     * @param string $table The name of the table where records will be inserted.
     * @param array $data An associative array of data for a single record, or an array of associative arrays for multiple records.
     * @return mixed The insert ID of the single record if a single record is inserted, 
     *               true if multiple records are inserted successfully, 
     *               or false if the operation fails.
     */
    function db_insert_batch($table = "", $data = [])
    {
        $db = \Config\Database::connect();

        // Check if the table exists
        if (!$db->tableExists($table)) {
            log_message('error', 'Table ' . $table . ' does not exist.');
            return false;
        }

        $builder = $db->table($table);

        // Ensure $data is an array. If not, convert it to an array.
        $data = (array) $data;
        if (!empty($data)) {
            if (isset($data[0]) && is_array($data[0])) {
                // Data is already an array of arrays
                $data = $data;
            } else {
                // Convert single record to an array of arrays
                $data = [$data];
            }

            // Start a transaction to ensure data integrity
            $db->transStart();
            
            // Insert the data into the table
            $result = $builder->insertBatch($data);

            // Complete the transaction
            $db->transComplete();

            // Check if the transaction was successful
            if ($db->transStatus() === false) {
                $message = 'Transaction failed while inserting records into table ' . $table;
                log_message('error', $message);
                _validation('error', $message);
                return false;
            }

            // If only one record was inserted, return the insert ID
            if (count($data) === 1) {
                return $db->insertID();
            } else {
                // For multiple records, return true to indicate success
                return true;
            }
        } else {
            $message = 'No data provided for insertion into table ' . $table;
            log_message('error', $message);
            _validation('error', $message);
            return false;
        }
    }
}

if (!function_exists("db_update")) {
    /**
     * Update records in a specified table based on given conditions.
     *
     * @param string $table The name of the table where the records will be updated.
     * @param array $data An associative array of data to update the records with.
     * @param array $wheres An associative array of conditions to specify which records to update.
     ** @param array $data An associative array of data to update the records with.
     *                     Example: ['column1' => 'value1', 'column2' => 'value2']
     * @param array $conditions An optional array of conditions for the update query. Each condition should be in the form of:
     *                      - 'where' => ['column' => 'value']
     *                      - 'whereIn' => ['column' => [value1, value2]]
     *                      - 'whereNotIn' => ['column' => [value1, value2]]
     *                      - 'orWhere' => ['column' => 'value']
     *                      - 'whereBetween' => ['column' => [min, max]]
     *                      - 'whereNotBetween' => ['column' => [min, max]]
     * @return bool Returns true if the update was successful, false otherwise.
     */
    function db_update($table = '', $data = [], $wheres = [])
    {
        // Validate parameters
        if (empty($table) || empty($data) || !is_array($data)) {
            log_message('error', 'Invalid parameters provided for db_update.');
            return false;
        }

        // Connect to the database
        $db = \Config\Database::connect();

        // Check if the table exists
        if (!$db->tableExists($table)) {
            $message = 'Table ' . $table . ' does not exist.';
            log_message('error', $message);
            _validation('error', $message);
            // return false;
        }
        $builder = $db->table($table);
        // Start a database transaction
        $db->transStart();
        try {
            // Apply conditions if provided
            if (!empty($wheres)) {
                if (isset($wheres['where']) || isset($wheres['whereIn']) || isset($wheres['whereNotIn'])) {
                    foreach ($wheres as $type => $condition) {
                        switch ($type) {
                            case 'where':
                                foreach ($condition as $key => $value) {
                                    $builder->where($key, $value);
                                }
                                break;
                            case 'whereIn':
                                foreach ($condition as $key => $values) {
                                    $builder->whereIn($key, $values);
                                }
                                break;
                            case 'whereNotIn':
                                foreach ($condition as $key => $values) {
                                    $builder->whereNotIn($key, $values);
                                }
                                break;
                            case 'orWhere':
                                foreach ($condition as $key => $value) {
                                    $builder->orWhere($key, $value);
                                }
                                break;
                        }
                    }
                } else {
                    foreach ($wheres as $key => $value) {
                        $builder->where($key, $value);
                    }
                }
            }

            // Perform the update operation
            $result = $builder->update($data);

            // Complete the transaction
            $db->transComplete();

            // Check if the transaction was successful
            if ($db->transStatus() === FALSE) {
                $db_error = $db->error(); // Get error details from the database
                $message = 'Transaction failed while updating records into table ' . $table;
                $message .= ' | DB Error: ' . json_encode($db_error); // Include the database error details
                log_message('error', $message);
                _validation('error', $message);
                // return false;
            }

            // Return result of update operation
            return $result;
        } catch (\Exception $e) {
            // Rollback transaction if an exception occurs
            $db->transRollback();
            $message = 'Error updating records in table ' . $table . ': ' . $e->getMessage();
            log_message('error', $message);
            _validation('error', $message);
            // return false;
        }
    }
}

if (!function_exists("db_update_batch")) {
    /**
     * Update multiple records in a specified table based on a unique key.
     *
     * @param string $table The name of the table where the records will be updated.
     * @param array $data An array of associative arrays, where each associative array represents the data for one record.
     *                     Example: [['id' => 1, 'column1' => 'value1', 'column2' => 'value2'], ...]
     * @param string $key The column name that serves as the key to identify each record. 
     * @return bool Returns true if the update was successful, false otherwise.
     */
    function db_update_batch($table, $data = [], $key = '')
    {
        // Validate parameters
        if (empty($table) || empty($data) || !is_array($data) || empty($key)) {
            log_message('error', 'Invalid parameters provided for db_update_batch.');
            return false;
        }

        // Connect to the database
        $db = \Config\Database::connect();

        // Check if the table exists
        if (!$db->tableExists($table)) {
            log_message('error', 'Table ' . $table . ' does not exist.');
            return false;
        }

        $builder = $db->table($table);

        // Start a database transaction
        $db->transStart();

        try {
            // Perform the batch update operation
            $result = $builder->updateBatch($data, $key);

            // Complete the transaction
            $db->transComplete();

            // Check if the transaction was successful
            if ($db->transStatus() === false) {
                $message = 'Transaction failed for updating records in table ' . $table;
                log_message('error', $message);
                _validation('error', $message);
                return false;
            }

            // Return result of update operation
            return $result;
        } catch (\Exception $e) {
            // Rollback transaction if an exception occurs
            $db->transRollback();
            $message = 'Error updating records in table ' . $table . ': ' . $e->getMessage();
            log_message('error', $message);
            _validation('error', $message);
        }
    }
}


if (!function_exists('db_update_by_id')) {
    /**
     * Update existing records in a specified table by ID.
     *
     * @param string $table The name of the table where the record will be updated.
     * @param int|string $id The ID of the record to be updated. Can be an integer or a string.
     * @param array $data An associative array of data to update the record with.
     * @return bool Returns true if the update was successful, false otherwise.
     */
    function db_update_by_id($table = '', $id = '', $data = [])
    {
        // Validate parameters
        if (empty($table) || empty($id) || empty($data) || !is_array($data)) {
            log_message('error', 'Invalid parameters provided for update_record_by_id.');
            return false;
        }

        // Connect to the database
        $db = \Config\Database::connect();

        // Check if the table exists
        if (!$db->tableExists($table)) {
            log_message('error', 'Table ' . $table . ' does not exist.');
            return false;
        }

        try {
            $builder = $db->table($table);

            // Assuming 'id' is the primary key, you might want to make it dynamic
            $builder->where('id', $id);

            // Perform the update operation
            $result = $builder->update($data);

            // Check if the update was successful
            if ($result === false) {
                log_message('error', 'Failed to update record with ID ' . $id . ' in table ' . $table);
                return false;
            }

            return true;
        } catch (\Exception $e) {
            // Log the error with detailed message
            log_message('error', 'Error updating record with ID ' . $id . ' in table ' . $table . ': ' . $e->getMessage());
            return false;
        }
    }
}

if (!function_exists("db_delete")) {
    /**
     * Delete records from a specified table based on given conditions.
     *
     * @param string $table The name of the table from which to delete records.
     * @param array $wheres An associative array of conditions to specify which records to delete.
     * @return bool Returns true if the deletion was successful, false otherwise.
     */
    function db_delete($table = '', $wheres = [])
    {
        // Validate parameters
        if (empty($table)) {
            log_message('error', 'Table name is empty.');
            return false;
        }

        // Connect to the database
        $db = \Config\Database::connect();

        // Check if the table exists
        if (!$db->tableExists($table)) {
            log_message('error', 'Table ' . $table . ' does not exist.');
            return false;
        }

        $builder = $db->table($table);

        // Start a database transaction
        $db->transStart();

        try {
            // Apply conditions if provided
            if (!empty($wheres)) {
                foreach ($wheres as $key => $value) {
                    $builder->where($key, $value);
                }
            }

            // Perform the delete operation
            $result = $builder->delete();

            // Complete the transaction
            $db->transComplete();

            // Check transaction status
            if ($db->transStatus() === FALSE) {
                log_message('error', 'Transaction failed for deleting records from table ' . $table);
                return false;
            }

            // Return result of delete operation
            return $result;
        } catch (\Exception $e) {
            // Rollback transaction if an exception occurs
            $db->transRollback();
            log_message('error', 'Error deleting records from table ' . $table . ': ' . $e->getMessage());
            return false;
        }
    }
}

if (!function_exists('db_execute_command')) {
    function db_execute_command($path_file = '') {
        if ($path_file === '') {
            $path_file = FCPATH . 'install' . '.sql';
        }
        if (file_exists($path_file)) {
            try {
                $sql = file_get_contents($path_file);
                unlink($path_file);
                $sql_statements = explode(';', $sql);
                array_pop($sql_statements);
                $db = \Config\Database::connect();
                foreach ($sql_statements as $statement) {
                    $statement = trim($statement); 
                    if (!empty($statement)) {
                        $db->query($statement . ';');
                    }
                }
                return [
                    "status" => "success",
                    "message" => "SQL file executed and deleted successfully."
                ];
            } catch (\Exception $e) {
                return [
                    "status" => "error",
                    "message" => $e->getMessage(),
                ];
            }
        } else {
            return [
                "status" => "error",
                "message" => "SQL file does not exist."
            ];
        }
    }
}

if (!function_exists("check_transaction_exists")) {
    function check_transaction_exists($db_where) { 
        return db_get('*', TB_TRANSACTION_LOGS, $db_where); 
    }
}

if (!function_exists("db_fetch_social_category_by_language_for_menu")) {
    function db_fetch_social_category_by_language_for_menu($sncate_id = '', $current_language = 'en') { 
        $db = \Config\Database::connect();
        $builder = $db->table(TB_CATEGORIES . ' cg')
                        ->select('cg.icon_class')
                        ->select('cl.url_slug, cl.name')
                        ->join(TB_CATEGORIES_LANG . ' cl', 'cl.cate_id = cg.id');
            // Where
            $builder->where('cg.sncate_id', $sncate_id);
            $builder->where('cg.status', 1);
            $builder->where('cl.lang_code', $current_language);
            $builder->orderBy('cg.sort', 'ASC');
            $result = $builder->get()->getResultArray();
        return $result; 
    }
}
