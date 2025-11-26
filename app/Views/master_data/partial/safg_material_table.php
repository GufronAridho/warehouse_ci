<?php foreach ($item as $row): ?>
    <tr>
        <td><?= $row['material_number']; ?></td>
        <td><?= $row['material_desc']; ?></td>
        <td><?= $row['qty']; ?></td>
        <td><?= $row['uom']; ?></td>
        <td><?= $row['price']; ?></td>
        <td><?= $row['is_active'] == 1 ? 'Yes' : 'No'; ?></td>
        <td class="text-center">
            <div class="d-flex justify-content-center gap-1">

                <button class="btn btn-sm btn-info edit-btn"
                    data-id="<?= $row['id_bom']; ?>"
                    data-material_number="<?= $row['material_number']; ?>"
                    data-material_desc="<?= $row['material_desc']; ?>"
                    data-qty="<?= $row['qty']; ?>"
                    data-is_active="<?= $row['is_active']; ?>">
                    <i class="fa fa-edit"></i>
                </button>

                <button class="btn btn-sm btn-danger delete-btn"
                    data-id="<?= $row['id_bom']; ?>">
                    <i class="fa fa-trash"></i>
                </button>

            </div>
        </td>

    </tr>
<?php endforeach; ?>