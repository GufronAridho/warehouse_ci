<?php
foreach ($item as $i): ?>
    <tr>
        <td class="text-center"><?= $i['material_number']; ?></td>
        <td class="text-center"><?= $i['location_id']; ?></td>
        <td class="text-center"><?= $i['rack']; ?></td>
        <td class="text-center"><?= $i['bin']; ?></td>
        <td class="text-center"><?= $i['qty']; ?></td>
        <td class="text-center"><?= $i['last_updated']; ?></td>
    </tr>
<?php endforeach; ?>