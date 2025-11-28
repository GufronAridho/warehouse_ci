<?php foreach ($item as $i): ?>
    <tr>
        <td class="text-center"><?= $i['plant_code']; ?></td>
        <td class="text-center"><?= $i['plant_name']; ?></td>
        <td class="text-center"><?= $i['line_code']; ?></td>
        <td class="text-center"><?= $i['line_name']; ?></td>
        <td class="text-center"><?= $i['cell_name']; ?></td>
        <td class="text-center"><?= $i['process_type']; ?></td>
        <td class="text-center">
            <div class="d-flex justify-content-center gap-1">
                <button class="btn btn-sm btn-info edit-btn"
                    data-id="<?= $i['id']; ?>"
                    data-plant_code="<?= $i['plant_code']; ?>"
                    data-plant_name="<?= $i['plant_name']; ?>"
                    data-line_code="<?= $i['line_code']; ?>"
                    data-line_name="<?= $i['line_name']; ?>"
                    data-cell_name="<?= $i['cell_name']; ?>"
                    data-process_type="<?= $i['process_type']; ?>">
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