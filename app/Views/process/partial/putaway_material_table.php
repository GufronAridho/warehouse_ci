<?php foreach ($item as $i):
    $status = $i['status'];

    if ($status == 'OPEN') {
        $rowClass = 'table-open';
    } elseif ($status == 'TRANSFER') {
        $rowClass = 'table-partial';
    } else {
        $rowClass = 'table-complete';
    }
?>
    <tr class="<?= $rowClass ?>">
        <td class="text-start">
            <div class="fw-bold"><?= $i['material_number']; ?></div>
            <div class="text-muted small"><?= $i['material_desc']; ?></div>
        </td>
        <td class="text-center align-middle">
            <?= $i['from_location'] ?: '-' ?>
        </td>
        <td class="text-center align-middle">
            <?= $i['to_rack'] ?: '-' ?>
        </td>
        <td class="text-center align-middle">
            <?= $i['to_bin'] ?: '-' ?>
        </td>
        <td class="text-center align-middle">
            <?= $i['qty'] . ' ' . $i['uom']; ?>
        </td>
    </tr>
<?php endforeach; ?>