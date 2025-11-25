<?php foreach ($item as $i):

    $qtyReceived = $i['qty_received'];
    $qtyRemaining = $i['qty_remaining'];

    if ($qtyRemaining == $qtyReceived) {
        $rowClass = 'table-open';
    } elseif ($qtyRemaining > 0) {
        $rowClass = 'table-partial';
    } else {
        $rowClass = 'table-complete';
    }
?>
    <tr class="<?= $rowClass ?>">
        <td class="text-center"><?= $i['delivery_number']; ?></td>
        <td class="text-center"><?= $i['material_number']; ?></td>
        <td class="text-start"><?= $i['material_desc']; ?></td>
        <td class="text-center">
            <?= $qtyRemaining . ' / ' . $qtyReceived . ' ' . $i['uom']; ?>
        </td>
    </tr>

<?php endforeach; ?>