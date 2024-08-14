<?php

require "../../_config.php";

if (isset($_POST['search']) && isset($_POST['type'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search']);
    $type = $_POST['type'];

    if ($type == 'all') {
        $get_sql = "SELECT * FROM `table_booking` WHERE `name` LIKE '%$search%' OR `email` LIKE '%$search%' OR `phone` LIKE '%$search%' ORDER BY `id` DESC";
    } elseif ($type == 'confirmed') {
        $get_sql = "SELECT * FROM `table_booking` WHERE (`status`='confirmed') AND (`name` LIKE '%$search%' OR `email` LIKE '%$search%' OR `phone` LIKE '%$search%') ORDER BY `id` DESC";
    } elseif ($type == 'removed') {
        $get_sql = "SELECT * FROM `table_booking` WHERE (`status`='removed') AND (`name` LIKE '%$search%' OR `email` LIKE '%$search%' OR `phone` LIKE '%$search%') ORDER BY `id` DESC";
    }

    $get_res = mysqli_query($conn, $get_sql);
    $get_rows = mysqli_num_rows($get_res);

    if ($get_rows > 0) {
        $output = '<table>
                <tr>
                    <th>S. No. </th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Person</th>
                    <th>Reserved for</th>
                    <th>Status</th>
                    <th>Action</th>
                    <th>Reserved at</th>
                </tr>';
        while ($data = mysqli_fetch_assoc($get_res)) {
            $id = $data['id'];
            $name = $data['name'];
            $email = $data['email'];
            $phone = $data['phone'];
            $person = $data['person'];
            $reserved_for = $data['reserved_for'];
            $status = $data['status'];
            $added_on = $data['added_on'];

            $mod_reserved_for_datetime =  date ('h:i a <b>||</b> d M, Y', strtotime($reserved_for));
            $mod_real_datetime =  date ('h:i a <b>||</b> d M, Y', strtotime($added_on));

            $output .= '<tr>
                <td>'.$id.'.</td>
                <td>'.$name.'</td>
                <td>'.$email.'</td>
                <td>'.$phone.'</td>
                <td>'.$person.'</td>
                <td>'.$mod_reserved_for_datetime.'</td>
                <td>';
                    if ($status == 'pending') {
                        $output .= '
                        <span class="status pending-status">Pending</span>
                        <span class="status confirmed-status hide">Confirmed</span>
                        <span class="status removed-status hide">Removed</span>';
                    } elseif ($status == 'confirmed') {
                        $output .= '
                        <span class="status pending-status hide">Pending</span>
                        <span class="status confirmed-status">Confirmed</span>
                        <span class="status removed-status hide">Removed</span>';
                    } elseif ($status == 'removed') {
                        $output .= '
                        <span class="status pending-status hide">Pending</span>
                        <span class="status confirmed-status hide">Confirmed</span>
                        <span class="status removed-status">Removed</span>';
                    }
                    
                $output .= '</td>
                <td>';
                    if ($status == 'pending') {
                        $output .= '
                        <button data-reservation-id="'.$id.'" class="action confirm-action">Confirm</button>
                        <button data-reservation-id="'.$id.'" class="action remove-action">Remove</button>
                        <button data-reservation-id="'.$id.'" class="action delete-action hide">Delete</button>';
                    } elseif ($status == 'confirmed') {
                        $output .= '
                        <button data-reservation-id="'.$id.'" class="action delete-action">Delete</button>';
                    } elseif ($status == 'removed') {
                        $output .= '
                        <button data-reservation-id="'.$id.'" class="action delete-action">Delete</button>';
                    }
                    
                $output .= '</td>
                <td>'.$mod_real_datetime.'</td>
            </tr>';
        }
        $output .= '</table>';

        echo $output;
    } else {
        echo 'There is no reservation like <b><q>'.$search.'</q></b>';
    }


}

?>