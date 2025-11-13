<?php $no = 1;
foreach ($item as $i):
    $status = ($i['qty_received'] >= $i['qty_order']) ?>
    <tr>
        <td class="text-center"><?= $no++; ?></td>
        <td class="text-center"><?= $i['material_number']; ?></td>
        <td class="text-start"><?= $i['material_desc']; ?></td>
        <td class="text-end"><?= $i['qty_order']; ?></td>
        <td class="text-end"><?= $i['qty_received']; ?></td>
        <td class="text-center"><?= $i['uom']; ?></td>
        <td class="text-center">
            <?= $status ? '<span class="badge bg-success">Complete</span>'
                : '<span class="badge bg-warning text-black">Pending</span>'; ?>
        </td>
        <td class="text-center">
            <div class="d-flex justify-content-center gap-1">
                <button class="btn btn-sm btn-info edit-btn"
                    data-id="<?= $i['id']; ?>"
                    data-material_number="<?= $i['material_number']; ?>"
                    data-material_desc="<?= $i['material_desc']; ?>"
                    data-qty_order="<?= $i['qty_order']; ?>"
                    data-qty_received="<?= $i['qty_received']; ?>"
                    data-uom="<?= $i['uom']; ?>">
                    <i class="fa fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger delete-btn"
                    data-id="<?= $i['id']; ?>">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </td>
    </tr>
<?php endforeach; ?>