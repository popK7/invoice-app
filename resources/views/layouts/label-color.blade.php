<?php
        //priority badge color
        function PriorityColor($val){
            switch ($val) {
                case "High":
                    echo ('<span class="badge bg-warning">' . $val . "</span>");
                    break;
                case "Medium":
                    echo ('<span class="badge bg-info">' . $val . "</span>");
                    break;
                case "Low":
                    echo ('<span class="badge bg-success">' . $val . "</span>");
                    break;
                case "Urgent":
                    echo ('<span class="badge bg-danger">' . $val . "</span>");
                    break;
                default:
                    echo ('<span class="badge bg-secondary">' . $val . "</span>");
            }
        } 

        //status badge color
        function ActiveColor($val){
            switch ($val) {
                case "Re-open":
                    echo ('<span class="badge badge-soft-info">' .$val ."</span>");
                    break;
                case "On-Hold":
                    echo ('<span class="badge badge-soft-secondary">' .$val ."</span>");
                    break;
                case "New":
                    echo ('<span class="badge badge-soft-success">' .$val ."</span>");
                    break;
                case "Inprogress":
                    echo ('<span class="badge badge-soft-warning">' .$val ."</span>");
                    break;
                case "Closed":
                    echo ('<span class="badge badge-soft-danger">' .$val ."</span>");
                    break;
                case "Active":
                    echo ('<span class="badge badge-soft-success">' .$val ."</span>");
                    break;
                case "Overdue":
                    echo ('<span class="badge bg-secondary">' . $val . "</span>");
                break;
                default:
                    echo ('<span class="badge badge-soft-success">' .$val ."</span>");
            }
        } 

    ?>
