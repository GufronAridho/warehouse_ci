<?php foreach ($item as $i): ?>
    <tr>
        <td class="text-center"><?= $i['delivery_number']; ?></td>
        <td class="text-center"><?= $i['material_number']; ?></td>
        <td class="text-end"><?= $i['qty_order']; ?></td>
        <td class="text-end"><?= $i['qty_received']; ?></td>
        <td class="text-end"><?= $i['qty_remaining']; ?></td>
        <td class="text-center"><?= $i['uom']; ?></td>
        <td class="text-center"><?= $i['shipment_id']; ?></td>
        <td class="text-center"><?= $i['customer_po']; ?></td>
        <td class="text-center"><?= $i['customer_po_line']; ?></td>
        <td class="text-center"><?= $i['staging_location']; ?></td>
        <td class="text-center"><?= $i['status']; ?></td>
        <td class="text-center"><?= $i['scanned_by']; ?></td>
        <td class="text-center"><?= $i['scanned_at']; ?></td>
        <td class="text-center"><?= $i['validated_at']; ?></td>
        <td class="text-center">
            <button class="btn btn-sm btn-primary print-label-btn"
                data-delivery="<?= $i['delivery_number']; ?>"
                data-material="<?= $i['material_number']; ?>"
                data-qty="<?= $i['qty_received']; ?>"
                data-uom="<?= $i['uom']; ?>">
                <i class="fa fa-print"></i>
            </button>
        </td>
    </tr>
<?php endforeach; ?>