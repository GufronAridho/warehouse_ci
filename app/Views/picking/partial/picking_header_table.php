<?php foreach ($item as $row): ?>
    <tr>
        <td class="text-center"><?= esc($row['order_number']); ?></td>
        <td class="text-center"><?= esc($row['sa_fg']); ?></td>
        <td class="text-center"><?= esc($row['order_quantity']); ?></td>
        <td class="text-center"><?= esc($row['plant_code']); ?></td>
        <td class="text-center"><?= esc($row['line_code']); ?></td>
        <td class="text-center"><?= esc($row['cell_name']); ?></td>
        <?php
        $status = $row['status'];

        $bgClass = match ($status) {
            'Draft'       => 'bg-secondary text-white',
            'In Progress' => 'bg-warning text-dark',
            'Completed'   => 'bg-success text-white',
            'Canceled'    => 'bg-danger text-white',
            default       => 'bg-dark text-white',
        };
        ?>

        <td class="text-center <?= $bgClass ?>" style="font-size:16px; font-weight:600;">
            <?= $status ?>
        </td>
        <td class="text-center"><?= esc($row['picking_date']); ?></td>

        <td class="text-center">
            <?php
            $status = $row['status'];
            $btnClass = "";
            $btnText  = "";
            $btnAction = "";

            if ($status === "Draft") {
                $btnClass = "btn-secondary";
                $btnText  = "Start";
                $btnAction = "updateStatus('{$row['picking_id']}', 'In Progress')";
            } elseif ($status === "In Progress") {
                $btnClass = "btn-warning text-dark";
                $btnText  = "Kitting";
                $btnAction = "updateStatus('{$row['picking_id']}', 'Complete')";
            } elseif ($status === "Complete") {
                $btnClass = "btn-success";
                $btnText  = "Completed";
                $btnAction = "";
            } elseif ($status === "Canceled") {
                $btnClass = "btn-danger";
                $btnText  = "Canceled";
                $btnAction = "";
            }
            ?>

            <button
                class="btn <?= $btnClass ?>"
                style="
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 20;font-weight:600;
        "
                <?php if ($btnAction): ?> onclick="<?= $btnAction ?>" <?php else: ?> disabled <?php endif; ?>>
                <?= $btnText ?>
            </button>
        </td>
    </tr>
<?php endforeach; ?>