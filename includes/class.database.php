<?php

ini_set('memory_limit', '-1');

// ============================================================================= //
// Script: class.database.php                                                    //
// Version 2.4.0                                                                 //
// Author: Matt DeKok (C) 2009                                                   //
// Contact: http://www.animestreamers.com/contact/                               //
// Documentation: http://www.animestreamers.com/portfolio/class_database/        //
// Demo: http://www.animestreamers.com/portfolio/class_database_demo/            //
// ============================================================================= //
// Description:                                                                  //
// The Advanced MySQL Database Class is probably one of the simplest database    //
// objects/classes to use for PHP. The number of lines of code that you need to  //
// use for any function in this class is just 1!  Any query at all can be called //
// and return a result whether it be data or true/false. Other things this class //
// can do is: retrieve database information, backup one or all of your databases //
// to either a SQL string variable or a SQL file, execute queries from a SQL     //
// file, print a results table, sort a non-indexed table's records, and prevent  //
// SQL injection.                                                                //
// ============================================================================= //
// Updates Log:                                                                  //
//                                                                               //
// Version 1.0 - Years ago                                                       //
// - Old class that was not very user friendly                                   //
//                                                                               //
// Version 2.0.0 - 07/27/2009                                                    //
// - New user-friendly class that is more functional than version 1.0.           //
// - Unlike the previous version, this class comes with a single query function  //
//   capable of handling all queries.                                            //
// - It includes several new functions such as:                                  //
//     - get_table_fields                                                        //
//     - get_tables                                                              //
//     - get_databases                                                           //
//     - get_mysql_variables                                                     //
//     - write_backup_sql                                                        //
//                                                                               //
// Version 2.1.0 - 07/31/2009                                                    //
// - Updates log added                                                           //
// - New function: sort_nonindexed_table (For more information, read below.)     //
//                                                                               //
// Version 2.1.1 - 08/01/2009                                                    //
// - __construct() improved by not requiring a database selection. Not all       //
//   queries require one.                                                        //
// - New function: select_db                                                     //
//   The purpose of this function is to allow a database selection if one is not //
//   selected during the construction of the database object. Also it will allow //
//   the user to switch between databases while using just one object.           //
// - write_backup_sql() function was improved by putting quotes around numbers   //
//   that contain non-numeric characters. It also puts a NULL value in fields    //
//   that are primary keys and auto incremented.                                 //
//                                                                               //
// Version 2.1.2 - 08/03/2009                                                    //
// - New function: disconnect (For more information, read below.)                //
//                                                                               //
// Version 2.2.0 - 08/04/2009                                                    //
// - You can now return just one record with multiple fields to a 1-dimensional  //
//   array using database::GET_ROW in the query function's parameters.           //
// - New function: execute_file (For more information, read below.)              //
// - New function: sql_date_format (For more information, read below.)           //
// - Improved error handling                                                     //
//                                                                               //
// Version 2.2.1 - 08/05/2009                                                    //
// - Fixed a bug in the write_backup_sql function by changing how it handles     //
//   generating code for CREATE TABLE commands.                                  //
//                                                                               //
// Version 2.3.0 - 08/09/2009                                                    //
// - New function: print_table (For more information, read below.)               //
//                                                                               //
// Version 2.4.0 - 08/20/2009                                                    //
// - New function: prevent_injection                                             //
//   Basically if you use this function on the values being updated or inserted  //
//   in your database it will prevent injected SQL from causing any harm to your //
//   database. NOTE: Do not use quotes around your non-numeric values if you use //
//   this function, it will add them for you.                                    //
//                                                                               //
// ============================================================================= //

class database extends CacheHandler {

    public $affected_rows = 0;          // Use after calling query function
    public $insert_id = null;           // Use after calling an insert query
    public $connection;                 // For use with mysql php functions
    public $result;                     // For use with mysql php functions
    private $crlf = "\r\n";
    private $as_file = false;
    private $tmp_buffer = "";
    private $db_host = "localhost";
    private $db_user = "golubhai_farukh";
    private $db_pass = "26061986";
    private $db_name = "golubhai_mobishine";
    private $cache_time = 18000;

    const GET_ARRAY = 0;
    const GET_ROW = 1;
    const GET_FIELD = 2;
    const VTYPE_BOTH = "BOTH";
    const VTYPE_SESSION = "SESSION";
    const VTYPE_GLOBAL = "GLOBAL";

    function connect() {

        if (!$this->connection) {

            //connect to database
            $connection = mysql_connect($this->db_host, $this->db_user, $this->db_pass);
            if (!$connection) {
                $this->show_error('Could not connect to database server.');
            }
            $this->connection = $connection;
            //select database
            if ($this->db_name != '') {
                $db = mysql_select_db($this->db_name, $connection);
                if (!$db) {
                    $this->show_error('Could not connect to database.');
                }
            }
        }
    }

    function __construct($db_host, $db_user, $db_pass, $db_name = '') {
        parent::CacheHandler();
        $this->db_host = $db_host;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_name = $db_name;
        /*        $this->db_host = $db_host;
          $this->db_user = $db_user;
          $this->db_pass = $db_pass;
          $this->db_name = $db_name;

          //connect to database
          $connection = @mysql_connect($db_host, $db_user, $db_pass);
          if (!$connection) {
          $this->show_error('Could not connect to database server.');
          }
          $this->connection = $connection;
          //select database
          if ($db_name != '') {
          $db = @mysql_select_db($db_name, $connection);
          if (!$db) {
          $this->show_error('Could not connect to database.');
          }
          } */
    }

    // -----------------------------------------------
    // select_db($db_name)
    // -----------------------------------------------
    // Description: Allows you to switch databases
    //
    // Parameters:
    // $db_name = Name of the database to connect to
    // -----------------------------------------------
    public function select_db($db_name) {
        $db = mysql_select_db($db_name, $this->connection);
        if (!$db) {
            $this->show_error('Could not connect to database.');
            return false;
        }

        return true;
    }

    // -----------------------------------------------
    // disconnect()
    // -----------------------------------------------
    // Description: Disconnects the connection
    //
    // Parameters: none
    // -----------------------------------------------
    public function disconnect() {
        if($this->connection)
            return @mysql_close($this->connection);
        else
            return false;
    }

    // -----------------------------------------------
    // numrow($query)
    // -----------------------------------------------
    // Description: Count table total row
    //
    // Parameters:
    // $query       = MySQL query
    // $id       = Your key column field
    //
    // Notes:
    // 1. nothing !!!
    // -----------------------------------------------
    public function numrow($query, $id) {
        $this->connect();
        // Determine query type
        $q = trim($query);
        $qarr = explode(' ', $q);
        // Proceed based on query type
        if (strtoupper($qarr[0]) == "SELECT") {
            // Send query
            $newquery = $qarr[0];
            $qarr = explode(' from', $q);
            $newquery .= " count($id) as total_row from " . $qarr[1];
            $this->result = @mysql_query($newquery);

            if (!$this->result) {
                $this->show_error(mysql_error());
                @mysql_free_result($this->result);
                return false;
            } else {
                // Run through data returned
                $row = mysql_fetch_array($this->result, MYSQL_ASSOC);

                // Free result
                @mysql_free_result($this->result);
                // Show error
                return $row['total_row'];
                ;
            }
        }
    }

    // -----------------------------------------------
    // query($query, $return_type = self::GET_ARRAY)
    // -----------------------------------------------
    // Description: Runs a MySQL query
    //
    // Parameters:
    // $query       = MySQL query
    // $return_type = database::GET_ARRAY (default)
    //                Returns results to a 2-dimensional array
    //                database::GET_ROW
    //                Returns result record to an array
    //                database::GET_FIELD
    //                Returns result to a variable
    //
    // Notes:
    // 1. After a query is called if it affected any rows, then you can use
    //    the included $db->affected_rows variable to get the number of
    //    rows the query affected. ($db is just an example)
    // 2. After calling an INSERT query, you can use $db->insert_id to get
    //    the value of the ID generated.
    // 3. Will store the connection and result resource variables in public
    //    variables that may be used outside of this class with mysql_
    //    functions.
    // -----------------------------------------------
    public function query($query, $return_type = self::GET_ARRAY,$cachewhat = 'yes') {


        // Determine query type
        $q = trim($query);
        $qarr = explode(' ', $q);
        // Proceed based on query type
        if (strtoupper($qarr[0]) == "SELECT" || strtoupper($qarr[0]) == "SHOW" ||
                strtoupper($qarr[0]) == "EXPLAIN" || strtoupper($qarr[0]) == "DESCRIBE" ||
                strtoupper($qarr[0]) == "HELP") {
            // Send query
            if ($cachewhat == 'yes')
                $content = $this->retrieve_cache($query . $return_type, 75);
            else
                $content = false;

            if ($content == false) {
                $this->connect();
                $this->result = mysql_query($query);
                if (!$this->result) {
                    $this->show_error(mysql_error());
                    @mysql_free_result($this->result);
                    return false;
                } else {
                    // Output number of affected rows
                    $this->affected_rows = mysql_affected_rows();
                    // Get array of field names
                    $fields = array();
                    $num_fields = mysql_num_fields($this->result);
                    for ($i = 0; $i < $num_fields; $i++) {
                        $fields[] = mysql_field_name($this->result, $i);
                    }
                    // Run through data returned
                    $n = 0;
                    $data = array();
                    while ($row = mysql_fetch_array($this->result, MYSQL_ASSOC)) {
                        if ($return_type == self::GET_ROW) {
                            $this->cache_content($query . $return_type, $row, $this->cache_time);
                            return $row;
                        }
                        foreach ($fields as $f) {
                            $field = trim($f);
                            if ($return_type == self::GET_FIELD) {
                                $this->cache_content($query . $return_type, $row[$field], $this->cache_time);
                                return $row[$field];
                            }
                            $data[$n] = $row;
                        }
                        $n++;
                    }
                }
                // Free result
                mysql_free_result($this->result);
                // Show error
                $this->cache_content($query . $return_type, $data, $this->cache_time);
                return $data;
            } else {
                //echo 'from cache::';
                return $content;
            }
        } else {
            $this->connect();
            // Send query
            $this->result = @mysql_query($query);
            if (!$this->result) {
                $this->show_error(mysql_error());
                return false;
            } else {
                // Output number of affected rows
                $this->affected_rows = mysql_affected_rows();
            }
            // If the query was an INSERT query, then store the insert_id
            if (strtoupper($qarr[0]) == "INSERT")
                $this->insert_id = mysql_insert_id();
            // Free result
            @mysql_free_result($this->result);
            // Return result
            return true;
        }
    }

    // -----------------------------------------------
    // get_table_fields($table_name, $exclude = array())
    // -----------------------------------------------
    // Description: Returns an array of fields in the chosen table
    //
    // Parameters:
    // $table_name = Name of a table to retrieve the fields from
    // $exclude    = Array of fields to exclude from results (i.e. id fields)
    //
    // Notes:
    // 1. It will return information about each field including Field, Type,
    //    Null, Key, Default, and Extra
    // -----------------------------------------------
    public function get_table_fields($table_name, $exclude = array()) {
        $this->connect();
        $structure = $this->query("SHOW COLUMNS FROM `$table_name`;");
        if (is_array($structure)) {
            $fields = array();
            foreach ($structure as $k => $v) {
                if (!in_array($v["Field"], $exclude)) {
                    $fields[] = $v;
                }
            }
            return $fields;
        }
        return false;
    }

    // -----------------------------------------------
    // get_tables($exclude = array())
    // -----------------------------------------------
    // Description: Returns an array of tables in the database
    //
    // Parameters:
    // $exclude = Array of tables to exclude from results
    // -----------------------------------------------
    public function get_tables($exclude = array()) {
        $this->connect();
        $structure = $this->query("SHOW TABLES FROM `" . $this->db_name . "`;");
        if (is_array($structure)) {
            $tables = array();
            foreach ($structure as $k => $v) {
                if (!in_array($v["Tables_in_" . $this->db_name], $exclude)) {
                    $tables[] = $v["Tables_in_" . $this->db_name];
                }
            }
            return $tables;
        }
        return false;
    }

    // -----------------------------------------------
    // get_databases($exclude = array())
    // -----------------------------------------------
    // Description: Returns an array of databases excluding system databases
    //
    // Parameters:
    // $exclude = Array of databases to exclude from results
    // -----------------------------------------------
    public function get_databases($exclude = array()) {
        $this->connect();
        $exc = array('information_schema', 'mysql');
        $exclude_all = array_merge($exclude, $exc);
        $structure = $this->query("SHOW DATABASES;");
        if (is_array($structure)) {
            $databases = array();
            foreach ($structure as $k => $v) {
                if (!in_array($v["Database"], $exclude_all)) {
                    $databases[] = $v["Database"];
                }
            }
            return $databases;
        }
        return false;
    }

    // -----------------------------------------------
    // get_mysql_variables()
    // -----------------------------------------------
    // Description: Returns an array of the MySQL variables and their values
    //
    // Parameters:
    // $variable_type = They type of variable
    //                  database::VTYPE_BOTH (default)
    //                  database::VTYPE_SESSION
    //                  database::VTYPE_GLOBAL
    // -----------------------------------------------
    public function get_mysql_variables($variable_type = self::VTYPE_BOTH) {
        $this->connect();
        return $this->query('SHOW ' . ($variable_type != self::BOTH ? $variable_type : '') . ' VARIABLES;');
    }

    // -----------------------------------------------
    // sort_nonindexed_table($table_name, $columns = array())
    // -----------------------------------------------
    // Description: Sorts a table with no index column by the chosen column.
    //
    //
    // Parameters:
    // $table_name = Name of table being sorted
    // $columns    = Array of columns/fields being sorted by
    //               Example syntaxes:
    //               As an array: array('`column_1` ASC','`column_2` DESC')
    //               As a string: '`column_1` ASC, `column_2` ASC'
    //
    // Returns:
    // Success = true
    // Failure = false
    //
    // Notes:
    // The table will not stay sorted after INSERTs and UPDATEs.
    // -----------------------------------------------
    public function sort_nonindexed_table($table_name, $columns = array()) {
        $this->connect();
        if (is_array($columns))
            $c = implode(", ", $columns);
        else
            $c = $columns;
        return $this->query("ALTER TABLE `$table_name` ORDER BY $c;");
    }

    // -----------------------------------------------
    // write_backup_sql($generate_file = false, $all_dbs = false)
    // -----------------------------------------------
    // Description: Write MySQL backup code for your database
    //
    // Parameters:
    // $generate_file = User can opt to have this generate an SQL file.
    //                  If true, then this function must be called before
    //                  anything is output to browser when headers are called.
    // $all_dbs       = User may also opt to have this function backup all the
    //                  databases on their host. (Better when $generate_file = true)
    //
    // Returns:
    // If $generate_file = true, then result is an SQL file.
    // If $generate_file = false, then result is a string.
    // -----------------------------------------------
    public function write_backup_sql($generate_file = false, $all_dbs = true) {
        // If the user wants to generate an SQL file, then convert the Content Type
        if ($generate_file) {
            $this->as_file = $generate_file;
            header('Content-Type: application/octetstream');
            header('Content-Disposition: filename="' . $this->db_name . '.sql"');
        }

        // Write header
        $dump_buffer = "# MySQL Database Dump" . $this->crlf;
        $dump_buffer .= "# Backup made: " . date("F j, Y, g:i a") . $this->crlf;
        $dump_buffer .= "# Database: " . ($all_dbs == true ? 'All Databases' : $this->db_name) . $this->crlf;
        if (!$all_dbs)
            $dump_buffer .= "# Backed up tables: " . count($this->get_tables()) . $this->crlf;
        else
            $dump_buffer .= "# Backed up databases: " . count($this->get_databases()) . $this->crlf;
        $dump_buffer .= "# Generated by: class_database by Matt DeKok" . $this->crlf;

        if ($all_dbs) {
            // Retrieve SQL dump for each database
            $db_name = $this->db_name;
            $dbs = $this->get_databases();
            foreach ($dbs as $db) {
                $this->db_name = $db;
                $dump_buffer .= $this->generate_sql($generate_file, $db);
            }
            $this->db_name = $db_name;
        } else {
            // Retrieve SQL dump for each table
            $dump_buffer .= $this->generate_sql($generate_file, $this->db_name);
        }

        // Output SQL dump
        if ($generate_file) {
            echo $dump_buffer;
            exit;
        } else {
            return $dump_buffer;
        }
    }

    // -----------------------------------------------
    // execute_file($file)
    // -----------------------------------------------
    // Description: Execute the MySQL commands inside a file
    //
    // Parameters:
    // $file = The path of the file
    //
    // Returns:
    // On success = true
    // On failure = false
    // -----------------------------------------------
    public function execute_file($file) {
        if (!file_exists($file)) {
            $this->show_error("File '$file' does not exist.");
            return false;
        }
        $content = file_get_contents($file);
        if (!$content) {
            $this->show_error("Unable to read '$file'.");
            return false;
        }
        $sql = explode(";", $content);
        foreach ($sql as $command) {
            if (!empty($command)) {
                if (!$this->query($command))
                    return false;
            }
        }
        return true;
    }

    // -----------------------------------------------
    // sql_date_format($date)
    // -----------------------------------------------
    // Description: Converts a timestamp or string format date
    //              to MySQL format so it can be inserted into
    //              a table
    //
    // Parameters:
    // $date = A numeric timestamp or a string date
    // -----------------------------------------------
    public function sql_date_format($date) {
        if (gettype($date) == 'string')
            $value = strtotime($date);
        return date('Y-m-d H:i:s', $value);
    }

    // -----------------------------------------------
    // print_table($results,
    //             $row_color = null,
    //             $alternate_row_color = null,
    //             $row_style = null,
    //             $table_style = null,
    //             $header_row_style = null)
    // -----------------------------------------------
    // Description: Prints a table from a query.
    //
    // Parameters:
    // $results             = The associative array returned from the query function
    // $row_color           = The primary row color
    // $alternate_row_color = The alternate row color
    // $row_style           = The style of every row
    // $table_style         = The table style
    // $header_row_style    = The header row style
    // -----------------------------------------------
    public function print_table($results, $row_color = null, $alternate_row_color = null, $row_style = null, $table_style = null, $header_row_style = null) {
        if (!is_array($results))
            return false;
        if ($row_color == null)
            $row_color = "#fff";
        if ($alternate_row_color == null)
            $alternate_row_color = "#ddd";
        if ($row_style == null)
            $row_style = "vertical-align: top;";
        if ($table_style == null)
            $table_style = "border: 2px solid #888; border-collapse: collapse;";
        if ($header_row_style == null)
            $header_row_style = "text-align: left; background-color: #ccc; border-bottom: 2px solid #888; color: #000;";
        $headers = array_keys($results[0]);
        echo "<div style=\"overflow: auto; overflow-y: hidden;\">\n";
        echo "<table style=\"$table_style\">\n";
        echo "    <tr>\n";
        foreach ($headers as $header) {
            echo "        <th style=\"$header_row_style\">$header</th>\n";
        }
        echo "    </tr>\n";
        $i = 0;
        foreach ($results as $result) {
            $i++;
            if (floor($i / 2) == $i / 2)
                $style_row = "background-color: $row_color; $row_style";
            else
                $style_row = "background-color: $alternate_row_color; $row_style";
            echo "    <tr style=\"$style_row\">\n";
            foreach ($headers as $header) {
                $item = $result[$header];
                echo "        <td>$item</td>\n";
            }
            echo "    </tr>\n";
        }
        echo "</table>\n";
        echo "</div>\n";
    }

    // -----------------------------------------------
    // prevent_injection($value)
    // -----------------------------------------------
    // Description: If you use this on all your values for UPDATE
    //              and INSERT queries.
    //
    // Note: It will be better to let this add the quotes to your
    // strings for you.
    // -----------------------------------------------
    public function prevent_injection($value) {
        $this->connect();
        // Stripslashes
        if (get_magic_quotes_gpc ()) {
            $value = stripslashes($value);
        }
        // Quote if not a number or a numeric string
        if (!is_numeric($value)) {
            $value = "'" . mysql_real_escape_string($value) . "'";
        }
        return $value;
    }

    // -----------------------------------------------
    // Pay no mind to the following functions
    // -----------------------------------------------
    private function show_error($error) {
        echo "<p><strong>Error:</strong> " . $error . "</p>";
    }

    private function get_table_def($table) {
        $this->error = array();

        $schema_create = "DROP TABLE IF EXISTS `" . $this->db_name . "`.`$table`;" . $this->crlf;
        $db = $table;

        $structure = $this->query("SHOW CREATE TABLE `$table`;");
        $schema_create = $structure[0]['Create Table'];
        $schema_create = str_replace("`$table`", "`" . $this->db_name . "`.`$table`", $schema_create);

        if (get_magic_quotes_gpc ()) {
            return (stripslashes($schema_create));
        } else {
            return ($schema_create);
        }
    }

    private function get_table_content($table, $limit_from = 0, $limit_to = 0) {
        // Defines the offsets to use
        if ($limit_from > 0) {
            $limit_from--;
        } else {
            $limit_from = 0;
        }

        if ($limit_to > 0 && $limit_from >= 0) {
            $add_query = " LIMIT $limit_from, $limit_to";
        } else {
            $add_query = '';
        }

        $result = mysql_query('SELECT * FROM ' . $this->db_name . '.' . $table . $add_query);
        if (!$result) {
            $this->show_error(mysql_error());
            return false;
        } else {

            @set_time_limit(1200); // 20 Minutes
            // Checks whether the field is an integer or not
            for ($j = 0; $j < mysql_num_fields($result); $j++) {
                $field_set[$j] = mysql_field_name($result, $j);
                $type[$j] = mysql_field_type($result, $j);
                $primary[$j] = substr_count(mysql_field_flags($result, $j), "primary_key");
                $auto[$j] = substr_count(mysql_field_flags($result, $j), "auto_increment");
                if ($type[$j] == 'tinyint' || $type[$j] == 'smallint' || $type[$j] == 'mediumint' || $type[$j] == 'int' || $type[$j] == 'bigint' || $type[$j] == 'timestamp') {
                    $field_num[$j] = true;
                } else {
                    $field_num[$j] = false;
                }
            } // end for
            // Get the scheme
            if (isset($GLOBALS['showcolumns'])) {
                $fields = implode('`, `', $field_set);
                $schema_insert = "INSERT INTO `" . $this->db_name . "`.`$table` (`$fields`) VALUES (";
            } else {
                $schema_insert = "INSERT INTO `" . $this->db_name . "`.`$table` VALUES (";
            }

            $field_count = mysql_num_fields($result);

            $search = array("\x0a", "\x0d", "\x1a", "'"); //\x08\\x09, not required
            $replace = array("\\n", "\\r", "\Z", "\\'");

            while ($row = mysql_fetch_row($result)) {
                for ($j = 0; $j < $field_count; $j++) {
                    if (!isset($row[$j]) || ($primary[$j] && $auto[$j])) {
                        $values[] = 'NULL';
                    } elseif (!empty($row[$j])) {
                        // a number
                        if ($field_num[$j] && is_numeric($row[$j])) {
                            $values[] = $row[$j];
                        }
                        // a string
                        else {
                            $values[] = "'" . str_replace($search, $replace, $row[$j]) . "'";
                        }
                    } else {
                        $values[] = "''";
                    } // end if
                } // end for

                $insert_line = $schema_insert . implode(', ', $values) . ')';
                unset($values);
                // Call the handler
                $this->handler($insert_line);
            } // end while
        }

        return true;
    }

    private function handler($sql_insert) {
        if (!$this->as_file)
            $this->tmp_buffer .= htmlspecialchars("$sql_insert;" . $this->crlf);
        else
            $this->tmp_buffer .= "$sql_insert;" . $this->crlf;
    }

    private function faqe_db_error() {
        return mysql_error();
    }

    private function faqe_db_insert_id($result) {
        return mysql_insert_id($result);
    }

    private function generate_sql($generate_file, $db_name) {
        $dump_buffer = "";

        $dump_buffer .= $this->crlf . "# --------------------------------------------------------" . $this->crlf . $this->crlf;
        $dump_buffer .= "#" . $this->crlf;
        $dump_buffer .= "# Database structure for database '$db_name'" . $this->crlf;
        $dump_buffer .= "#" . $this->crlf;
        $dump_buffer .= "DROP DATABASE IF EXISTS `$db_name`;" . $this->crlf;
        $cdb = $this->query("SHOW CREATE DATABASE `$db_name`;");
        $dump_buffer .= str_replace(" /*!40100 DEFAULT CHARACTER SET latin1 */", ";", $cdb[0]["Create Database"]) . $this->crlf;
        $dump_buffer .= $this->crlf;

        $tables = $this->query("SHOW TABLES FROM `" . $db_name . "`;");
        $num_tables = $this->affected_rows;

        // Check if tables were found
        if ($num_tables == 0) {
            if ($generate_file) {
                echo "# 0 tables found";
            } else {
                return false;
            }
        }
        foreach ($tables as $table) {
            $table = $table["Tables_in_$db_name"];
            // Write table structure
            $dump_buffer .= "# --------------------------------------------------------" . $this->crlf;
            $dump_buffer .= $this->crlf . "#" . $this->crlf;
            $dump_buffer .= "# Table structure for table '$table'" . $this->crlf;
            $dump_buffer .= "#" . $this->crlf;
            $dump_buffer .= $this->get_table_def($table) . ";" . $this->crlf;
            // Write table data
            $dump_buffer .= $this->crlf . "#" . $this->crlf;
            $dump_buffer .= "# Dumping data for table '$table'" . $this->crlf;
            $dump_buffer .= "#" . $this->crlf;
            $this->tmp_buffer = "";
            $this->get_table_content($table, 0, 0);
            $dump_buffer .= $this->tmp_buffer;
            $dump_buffer .= $this->crlf;
        }

        return $dump_buffer;
    }

    private function get_column_type($table_name, $column_name) {
        $result = $this->query("SELECT $column_name FROM $table_name;");
        if (!$result) {
            return false;
        }
        $type = mysql_field_type($result, 0);
        if (!$type) {
            $this->show_error(mysql_error());
            $return = false;
        }

        @mysql_free_result($result);
        return $type;
    }

}

?>