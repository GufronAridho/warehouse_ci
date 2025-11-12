<?php $no = 1;
foreach ($item as $i): ?> <tr>
        <td class="text-center"><?= $no++; ?></td>
        <td class="text-center"><?= $i['material_number']; ?></td>
        <td><?= $i['material_desc']; ?></td>
        <td class="text-center"><?= $i['ms']; ?></td>
        <td class="text-center"><?= $i['uom']; ?></td>
        <td class="text-center"><?= $i['type']; ?></td>
        <td class="text-center"><?= $i['pgr']; ?></td>
        <td class="text-center"><?= $i['mrpc']; ?></td>
        <td class="text-end"><?= number_format($i['price'], 2); ?></td>
        <td class="text-center"><?= $i['currency']; ?></td>
        <td class="text-center">
            <div class="d-flex justify-content-center gap-1">
                <button class="btn btn-sm btn-info edit-btn"
                    data-id="<?= $i['id_material']; ?>"
                    data-material_number="<?= $i['material_number']; ?>"
                    data-material_desc="<?= $i['material_desc']; ?>"
                    data-ms="<?= $i['ms']; ?>"
                    data-uom="<?= $i['uom']; ?>"
                    data-type="<?= $i['type']; ?>"
                    data-pgr="<?= $i['pgr']; ?>"
                    data-mrpc="<?= $i['mrpc']; ?>"
                    data-price="<?= $i['price']; ?>"
                    data-currency="<?= $i['currency']; ?>"
                    data-additional="<?= $i['additional']; ?>"
                    data-is_active="<?= $i['is_active']; ?>">
                    <i class="fa fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger delete-btn"
                    data-id="<?= $i['id_material']; ?>">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </td>
    </tr>
<?php endforeach; ?>