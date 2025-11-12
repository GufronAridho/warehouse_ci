<?= $no = 1; ?>
<?php foreach ($item as $i): ?>
    <tr>
        <td class="text-center"><?= $no++; ?></td>
        <td><?= $i->username; ?></td>
        <td><?= $i->email; ?></td>
        <td><?= implode(', ', $i->groups); ?></td>
        <td class="text-center">
            <button class="btn btn-sm btn-info edit-btn me-1"
                data-id="<?= $i->id; ?>"
                data-username="<?= $i->username; ?>"
                data-email="<?= $i->email; ?>"
                data-level="<?= implode(', ', $i->groups); ?>">
                <i class="fa fa-edit"></i>
            </button>
            <button class="btn btn-sm btn-danger delete-btn"
                data-id="<?= $i->id; ?>">
                <i class="fa fa-trash"></i>
            </button>
        </td>
    </tr>
<?php endforeach ?>