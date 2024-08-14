<?php

require "../../_config.php";

if (isset($_POST['search'])) {

    $search = mysqli_real_escape_string($conn, $_POST['search']);

    $get_sql = "SELECT * FROM `promo_code` WHERE `promo_code` LIKE '%$search%' ORDER BY `id` DESC";
    $get_res = mysqli_query($conn, $get_sql);
    $get_rows = mysqli_num_rows($get_res);

    if ($get_rows > 0) {
        $output = '<table>
                <tr>
                    <th>S. No. </th>
                    <th>Promo Code</th>
                    <th>Discount</th>
                    <th>Discount Mode</th>
                    <th>Status</th>
                    <th>Actions</th>
                    <th>Added on</th>
                </tr>';
        while ($promo_code_data = mysqli_fetch_assoc($get_res)) {
            $id = $promo_code_data['id'];
            $promo_code = $promo_code_data['promo_code'];
            $discount = $promo_code_data['discount'];
            $discount_mode = $promo_code_data['discount_mode'];
            $status = $promo_code_data['status'];
            $added_on = $promo_code_data['added_on'];

            $modDate =  date ('h:i a <b>||</b> d M, Y', strtotime($added_on));

            $output .= '<tr>
                    <td>'.$id.'.</td>
                    <td>'.$promo_code.'</td>
                    <td>'.$discount.'</td>
                    <td>'.$discount_mode.'</td>
                    <td>';
                        if ($status == 'active') {
                            $output .= '<span class="status active-status">Active</span>
                                <span class="status disabled-status hide">Disabled</span>';
                        } elseif ($status == 'disabled') {
                            $output .= '<span class="status active-status hide">Active</span>
                                <span class="status disabled-status">Disabled</span>';
                        }
                        
                        
                    $output .= '</td>
                    <td>';
                        if ($status == 'active') {
                            $output .= '<button data-promo-code-id="'.$id.'" class="action active-action hide">Active</button>
                            <button data-promo-code-id="'.$id.'" class="action disable-action">Disable</button>
                            <button data-promo-code-id="'.$id.'" class="action delete-action">Delete</button>';
                        } elseif ($status == 'disabled') {
                            $output .= '<button data-promo-code-id="'.$id.'" class="action active-action">Active</button>
                            <button data-promo-code-id="'.$id.'" class="action disable-action hide">Disable</button>
                            <button data-promo-code-id="'.$id.'" class="action delete-action">Delete</button>';
                        }
                    $output .= '</td>
                    <td>'.$modDate.'</td>
                </tr>';
        }
        $output .= '</table>';

        echo $output;
    } else {
        echo 'There is no promo code like <b><q>'.$search.'</q></b>';
    }
    

}

?>