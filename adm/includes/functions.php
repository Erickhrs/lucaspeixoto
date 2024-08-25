<?php
    function total($mysqli, $chart, $where) {
        $sql = "SELECT COUNT(*) as total FROM $chart $where";
        $result = $mysqli->query($sql);
        
        if ($result && $result->num_rows > 0) {
            $final = $result->fetch_assoc();
            return $final['total'];
        } else {
            return 0;
        }
    }

    function totalUni($mysqli, $chart, $column, $where = '') {
        $sql = "SELECT COUNT(DISTINCT $column) as total FROM $chart $where";  
        $result = $mysqli->query($sql);
        if ($result && $result->num_rows > 0) {
            $final = $result->fetch_assoc();
            return $final['total'];
        } else {
            return 0;
        }
    }

?>