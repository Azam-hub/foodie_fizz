<?php

require "../../_config.php";

if (isset($_POST['related_to']) && isset($_POST['search'])) {
    $search = $_POST['search'];
    $related_to = $_POST['related_to'];

    if ($related_to == "all") {
        $get_queries_sql = "SELECT * FROM `queries` WHERE (`name` LIKE '%$search%' OR `email` LIKE '%$search%' OR `phone` LIKE '%$search%' OR `subject` LIKE '%$search%') AND (`status`='opened') ORDER BY `id` DESC";
    } else if ($related_to == "billing") {
        $get_queries_sql = "SELECT * FROM `queries` WHERE (`name` LIKE '%$search%' OR `email` LIKE '%$search%' OR `phone` LIKE '%$search%' OR `subject` LIKE '%$search%') AND (`related_to`='billing') ORDER BY `id` DESC";
    } else if ($related_to == "technical") {
        $get_queries_sql = "SELECT * FROM `queries` WHERE (`name` LIKE '%$search%' OR `email` LIKE '%$search%' OR `phone` LIKE '%$search%' OR `subject` LIKE '%$search%') AND (`related_to`='technical') ORDER BY `id` DESC";
    } else if ($related_to == "food") {
        $get_queries_sql = "SELECT * FROM `queries` WHERE (`name` LIKE '%$search%' OR `email` LIKE '%$search%' OR `phone` LIKE '%$search%' OR `subject` LIKE '%$search%') AND (`related_to`='food') ORDER BY `id` DESC";
    } else if ($related_to == "other") {
        $get_queries_sql = "SELECT * FROM `queries` WHERE (`name` LIKE '%$search%' OR `email` LIKE '%$search%' OR `phone` LIKE '%$search%' OR `subject` LIKE '%$search%') AND (`related_to`='other') ORDER BY `id` DESC";
    } else if ($related_to == "closed") {
        $get_queries_sql = "SELECT * FROM `queries` WHERE (`name` LIKE '%$search%' OR `email` LIKE '%$search%' OR `phone` LIKE '%$search%' OR `subject` LIKE '%$search%') AND (`status`='closed') ORDER BY `id` DESC";
    }

    $get_queries_res = mysqli_query($conn, $get_queries_sql);
    $get_queries_rows = mysqli_num_rows($get_queries_res);

    if ($get_queries_rows > 0) {
        
        $output = '<table>
        <tr>
            <th>S. No. </th>
            <th>Name</th>
            <th>Email</th>
            '.($related_to == "all" || $related_to == "closed" ? '<th>Related to</th>' : '').'
            <th>Subject</th>
            <th>Query</th>
            <th>Status</th>
            <th>Action</th>
            <th>Added on</th>
        </tr>';

        while ($queries_data = mysqli_fetch_assoc($get_queries_res)) {
            $query_id = $queries_data['id'];
            $name = $queries_data['name'];
            $email = $queries_data['email'];
            $phone = $queries_data['phone'];
            $db_related_to = $queries_data['related_to'];
            $subject = $queries_data['subject'];
            $message = $queries_data['message'];
            $status = $queries_data['status'];
            $added_on = $queries_data['added_on'];

            $modDate =  date ('h:i a <b>||</b> d M, Y', strtotime($added_on));

            $output .= '<tr>
                <td>'.$query_id.'.</td>
                <td>'.$name.'</td>
                <td>'.$email.'</td>';
                if ($related_to == "all" || $related_to == "closed") {
                    if ($db_related_to == "billing") {
                        $output .= '<td>Billing</td>';

                    } else if ($db_related_to == "technical") {
                        $output .= '<td>Technical</td>';

                    } else if ($db_related_to == "food") {
                        $output .= '<td>Food</td>';

                    } else if ($db_related_to == "other") {
                        $output .= '<td>Other</td>';
                    }            
                }
                $output .= '<td>'.$subject.'</td>
                <td class="query">'.$message.'</td>
                <td>';
                    if ($status == 'opened') {
                        $output .= '<span class="status opened-status">Opened</span>
                        <span class="status closed-status hide">Closed</span>';
                    } else if ($status == 'closed') {
                        $output .= '<span class="status closed-status">Closed</span>';
                    }
                $output .= '</td>
                <td>';
                    if ($status == 'opened') {
                        $output .= '<button data-query-id="'.$query_id.'" class="action close-action">Close</button>
                        <button data-query-id="'.$query_id.'" class="action remove-action hide">Remove</button>';
                    } else if ($status == 'closed') {
                        $output .= '<button data-query-id="'.$query_id.'" class="action remove-action">Remove</button>';
                    }
                $output .= '</td>
                <td>'.$modDate.'</td>
            </tr>';
        }

        $output .= '</table>';

        echo $output;
    } else {
        echo "There is no query like <b><q>".$search."</q></b>.";
    }
    
}

?>