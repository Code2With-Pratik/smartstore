<?php
    function client_order_status($status)
    {
        $result = [
            'class_bage'    => 'badge bg-light',
            'title'         => __l("N_a"),
        ];
        switch ($status) {
            case 'completed':
                $result = [
                    'class_bage'    => 'badge bg-dark',
                    'title'         => __l("Completed"),
                ];
                break;
            case 'processing':
                $result = [
                    'class_bage'    => 'badge bg-info',
                    'title'         => __l("Processing"),
                ];
                break;
            case 'inprogress':
                $result = [
                    'class_bage'    => 'badge bg-success',
                    'title'         => __l("In_progress"),
                ];
                break;
            case 'pending':
                $result = [
                    'class_bage'    => 'badge bg-success',
                    'title'         => __l("Pending"),
                ];
                break;
            case 'partial':
                $result = [
                    'class_bage'    => 'badge bg-danger',
                    'title'         => __l("Partial"),
                ];
                break;
            case 'canceled':
                $result = [
                    'class_bage'    => 'badge bg-light',
                    'title'         => __l("Canceled"),
                ];
                break;
            case 'refunded':
                $result = [
                    'class_bage'    => 'badge bg-light ',
                    'title'         => __l("Refunded"),
                ];
                break;
            
        }
        return $result;
    }

    if (isset($item_order['transaction_status'])) {  
        if ($item_order['transaction_status'] == 1) {
            $payment_status_class = 'badge bg-dark';
            $payment_status = __l("Completed");
        } else if ($item_order['transaction_status'] == 0) {
            $payment_status_class = 'badge bg-warning';
            $payment_status = __l("Awaiting");
        } else {
            $payment_status_class = 'badge bg-danger';
            $payment_status = __l("Canceled");
        }
        $xhtml_payment_status = sprintf('<span class="%s">%s</span>', $payment_status_class, $payment_status);
    } else {
        $xhtml_payment_status = '<span class="badge bg-secondary">'. __l("Unknown") .'</span>';
    }

    $item_order_status = '<span class="badge bg-secondary">' . __l("N_a"). '</span>';
    if (isset($item_order['transaction_status']) && $item_order['transaction_status'] == 1 && !in_array($item_order['order_status'], ['awaiting', 'error'])) {
        $client_order_status = client_order_status($item_order['order_status']);
        $item_order_status = sprintf('<span class="%s">%s</span>', $client_order_status['class_bage'], $client_order_status['title']);
    } 

?>

<section class="mb-5" id="track-order-details">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="card border-none shadow-sm my-4" id="orderDetailsCard">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h3 class="fw-bold text-primary"><?= __l("Order_Tracking_Result"); ?></h3>
                            <p class="text-muted"><?= __l("Below_are_the_details_of_your_tracked_order"); ?></p>
                            
                        </div>
                        <div class="mb-4">
                            <h5 class="card-title bg-light text-dark mb-2 p-2"><?= __l("Payment_Information"); ?></h5>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td><?= __l("Transaction_ID"); ?></td>
                                        <td><strong><?=sanitize_output($item_order['transaction_reference']);?></strong></td>
                                    </tr>
                                    <tr>
                                        <td><?= __l("Payment_status"); ?></td>
                                        <td><?=$xhtml_payment_status; ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= __l("Total_Charge"); ?></td>
                                        <td><?=format_price_with_currency($item_order['transaction_amount']);?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="mb-4">
                            <h5 class="card-title bg-light text-dark mb-2 p-2"><?= __l("Package_Details"); ?></h5>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td><strong><?= __l("Order_ID"); ?></strong></td>
                                        <td><strong><?=sanitize_output($item_order['client_order_id']);?></strong></td>
                                    </tr>
                                    <tr>
                                        <td><?= __l("Package_Name"); ?></td>
                                        <td><?=sanitize_output($item_order['service_name']);?></td>
                                    </tr>
                                    <tr>
                                        <td><?= __l("Order_Status"); ?></td>
                                        <td><?=$item_order_status;?></td>
                                    </tr>
                                    <tr>
                                        <td><?= __l("Placed_Order_Date"); ?></td>
                                        <td>
                                            <?= client_placed_order_date($item_order['order_created'])?>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= __l("Link"); ?></td>
                                        <td><a href="<?=$item_order['order_link'];?>" target="_blank"><?=sanitize_output($item_order['order_link']);?></a></td>
                                    </tr>
                                    <tr>
                                        <td><?= __l("Quantity"); ?></td>
                                        <td><?=$item_order['order_quantity'];?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="">
                            <button id="exportPdfBtn" class="btn btn-outline-primary btn-sm export-pdf-btn"><?= __l("Export_PDF"); ?></button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

