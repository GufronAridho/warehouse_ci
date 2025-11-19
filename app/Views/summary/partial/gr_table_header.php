<?php foreach ($item as $i): ?>
    <tr>
        <td class="text-center">
            <span class="badge bg-secondary" style="font-size: 1rem;">
                <?= $i['delivery_number']; ?>
            </span>
        </td>
        <td><?= $i['vendor']; ?></td>
        <td class="text-center"><?= $i['gr_date']; ?></td>
        <td class="text-center">
            <?= $i['status']; ?>
        </td>
        <td class="text-center"><?= $i['received_by']; ?></td>
        <td class="text-center">
            <button class="btn btn-sm btn-info edit-btn" data-gr_id="<?= $i['gr_id']; ?>"
                data-delivery_number="<?= $i['delivery_number']; ?>">
                <i class="fa fa-eye"></i>
            </button>
        </td>
    </tr>
<?php endforeach; ?>