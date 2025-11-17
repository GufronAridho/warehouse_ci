<?php
foreach ($item as $i):
    $status = strtoupper($i['status']);
    switch ($status) {
        case 'OPEN':
            $badge = 'badge bg-danger px-3 py-2';
            break;
        case 'PARTIAL':
            $badge = 'badge bg-warning text-black px-3 py-2';
            break;
        case 'COMPLETE':
            $badge = 'badge bg-success px-3 py-2';
            break;
        default:
            $badge = 'badge bg-secondary px-3 py-2';
            break;
    }
?>
    <tr>
        <td class="text-center">
            <span class="<?= $badge ?>" style="font-size: 0.9rem;">
                <?= ucfirst(strtolower($status)) ?>
            </span>
        </td>
        <td class="text-center"><?= $i['material_number']; ?></td>
        <td class="text-start"><?= $i['material_desc']; ?></td>
        <td class="text-end"><?= $i['qty_order']; ?></td>
        <td class="text-end"><?= $i['qty_received']; ?></td>
        <td class="text-center"><?= $i['uom']; ?></td>
    </tr>
<?php endforeach; ?>