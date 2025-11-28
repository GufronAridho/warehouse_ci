<?php foreach ($item as $row): ?>
    <tr>
        <td><?= $row['safg_number']; ?></td>
        <td><?= $row['safg_desc']; ?></td>
        <td><?= $row['plant_code']; ?></td>
        <td><?= $row['line_code']; ?></td>
        <td><?= $row['cell_name']; ?></td>
        <td class="text-center">
            <div class="d-flex justify-content-center gap-1">

                <button class="btn btn-sm btn-success add-material"
                    data-safg_number="<?= $row['safg_number']; ?>"
                    data-safg_desc="<?= $row['safg_desc']; ?>"
                    data-plant_code="<?= $row['plant_code']; ?>"
                    data-line_code="<?= $row['line_code']; ?>"
                    data-cell_name="<?= $row['cell_name']; ?>">
                    <i class="fas fa-plus-circle"></i>
                </button>

                <button class="btn btn-info btn-sm view-material"
                    data-safg_number="<?= $row['safg_number']; ?>"
                    data-plant_code="<?= $row['plant_code']; ?>"
                    data-line_code="<?= $row['line_code']; ?>"
                    data-cell_name="<?= $row['cell_name']; ?>"
                    data-safg_desc="<?= $row['safg_desc']; ?>">
                    <i class="fas fa-list-alt me-1"></i>
                </button>

                <button class="btn btn-sm btn-danger delete-safg"
                    data-safg_number="<?= $row['safg_number']; ?>">
                    <i class="fa fa-trash"></i>
                </button>

            </div>

        </td>
    </tr>
<?php endforeach; ?>