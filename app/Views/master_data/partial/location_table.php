<?php
foreach ($item as $i): ?>
    <tr>
        <td class="text-center"><?= $i['location_code']; ?></td>
        <td class="text-center"><?= $i['storage_type']; ?></td>
        <td class="text-center"><?= $i['rack']; ?></td>
        <td class="text-center"><?= $i['bin']; ?></td>
        <td class="text-center"><?= $i['capacity']; ?></td>
        <td class="text-center"><?= $i['material_type_allowed']; ?></td>
        <td class="text-center"><?= $i['priority']; ?></td>
        <td class="text-center">
            <?= $i['is_active'] ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>'; ?>
        </td>
        <td class="text-center">
            <div class="d-flex justify-content-center gap-1">
                <button class="btn btn-sm btn-info edit-btn"
                    data-id="<?= $i['location_id']; ?>"
                    data-storage_type="<?= $i['storage_type']; ?>"
                    data-rack="<?= $i['rack']; ?>"
                    data-bin="<?= $i['bin']; ?>"
                    data-capacity="<?= $i['capacity']; ?>"
                    data-material_type_allowed="<?= $i['material_type_allowed']; ?>"
                    data-priority="<?= $i['priority']; ?>"
                    data-is_active="<?= $i['is_active']; ?>">
                    <i class="fa fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger delete-btn"
                    data-id="<?= $i['location_id']; ?>">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </td>
    </tr>
<?php endforeach; ?>