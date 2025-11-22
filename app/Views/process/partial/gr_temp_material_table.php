<?php foreach ($item as $i):

    $qtyOrder    = floatval($i['qty_order']);
    $qtyReceived = floatval($i['qty_received']);
    if ($qtyReceived == 0) {
        $rowClass = 'table-open';
    } elseif ($qtyReceived < $qtyOrder) {
        $rowClass = 'table-partial';
    } else {
        $rowClass = 'table-complete';
    }
?>
    <tr class="<?= $rowClass ?>">
        <td class="text-center">
            <button class="btn btn-sm btn-danger delete-btn"
                data-id="<?= $i['temp_detail_id']; ?>">
                <i class="fa fa-trash"></i>
            </button>
        </td>
        <td class="text-center"><?= $i['delivery_number']; ?></td>
        <td class="text-center"><?= $i['material_number']; ?></td>
        <td class="text-start"><?= $i['material_desc']; ?></td>
        <td class="text-end"><?= $i['qty_order']; ?></td>
        <td class="text-end"><?= $i['qty_received']; ?></td>
        <td class="text-center"><?= $i['uom']; ?></td>
    </tr>

<?php endforeach; ?>