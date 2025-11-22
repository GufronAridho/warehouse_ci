<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 1px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 0;
        }

        .qr img {
            width: 45px;
            /* Fits 50mm width */
        }

        .text {
            font-size: 10px;
            /* very small text */
            line-height: 1.0;
            padding-left: 2px;
        }

        .text div {
            margin-bottom: 1px;
        }

        @page {
            margin: 0;
        }

        body {
            margin: 0;
        }

        html {
            margin: 0;
        }
    </style>
</head>

<body>

    <table>
        <tr>
            <td class="qr" width="40%" style="vertical-align: middle;">
                <img src="data:image/png;base64,<?= $qrImage ?>" />
            </td>

            <td class="text" width="60%" style="vertical-align: middle;">
                <div><strong>Material:</strong> <?= $material ?></div>
                <div><strong>Qty:</strong> <?= $qty ?></div>
                <div><strong>UOM:</strong> <?= $uom ?></div>
            </td>
        </tr>
    </table>

</body>

</html>