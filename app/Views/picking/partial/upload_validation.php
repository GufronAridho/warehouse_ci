<table>
    <thead>
        <tr>
            <th style="width:10%;">Row</th>
            <th style="width:25%;">Value</th>
            <th style="width:30%;">Error</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($errors as $err): ?>
            <?php foreach ($err['errors'] as $msg): ?>
                <tr>
                    <td style="text-align: center;"><?= $err['row']; ?></td>
                    <td><?= htmlspecialchars(implode(' | ', $err['data'])); ?></td>
                    <td><?= $msg; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </tbody>
</table>

<style>
    table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    th,
    td {
        border: 1px solid black;
        padding: 6px 8px;
        word-break: break-word;
        overflow-wrap: break-word;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
        text-align: center;
    }
</style>