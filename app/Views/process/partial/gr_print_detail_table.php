<?php
foreach ($item as $i):
?>
    <tr>
        <td class="text-center"><?= $i['material_number']; ?></td>
        <td class="text-start"><?= $i['material_desc']; ?></td>
        <td class="text-end"><?= $i['qty_order']; ?></td>
        <td class="text-end"><?= $i['qty_received']; ?></td>
        <td class="text-center"><?= $i['uom']; ?></td>
        <td class="text-center">
            <button class="btn btn-primary btn-sm print-label-btn"
                data-material="<?= $i['material_number']; ?>"
                data-qty="<?= $i['qty_received']; ?>"
                data-uom="<?= $i['uom']; ?>">
                <i class="fas fa-print me-1"></i> Print Label
            </button>
        </td>
    </tr>
<?php endforeach; ?>