<?php foreach ($item as $i): ?>
    <tr>
        <td><?= $i['material_number']; ?></td>
        <td class="text-center"><?= $i['qty_received']; ?></td>
        <td class="text-center"><?= $i['qty_order']; ?></td>
        <td class="text-center"><?= $i['qty_remaining']; ?></td>
        <td class="text-center"><?= $i['uom']; ?></td>
        <td class="text-center"><?= $i['staging_location']; ?></td>
        <td class="text-center"><?= $i['status']; ?></td>
        <td class="text-center">
            <button class="btn btn-sm btn-primary print-label-btn"
                data-material="<?= $i['material_number']; ?>"
                data-qty="<?= $i['qty_received']; ?>"
                data-uom="<?= $i['uom']; ?>">
                <i class="fa fa-print"></i>
            </button>
        </td>
    </tr>
<?php endforeach; ?>