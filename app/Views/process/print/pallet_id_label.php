<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .label-container {
            width: 100%;
            border: 3px solid black;
            /* black border */
            padding-top: 35px;
            box-sizing: border-box;
        }

        table {
            width: 100%;
            height: 100%;
            border-collapse: collapse;
        }

        .qr img {
            width: 180px;
            height: 180px;
        }

        .text {
            font-size: 18px;
            line-height: 1.5;
            padding-left: 16px;
        }

        .text div {
            margin-bottom: 8px;
        }

        strong {
            font-size: 18px;
        }

        @page {
            margin: 0;
        }

        body,
        html {
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="label-container">
        <table>
            <tr>
                <!-- QR CODE -->
                <td class="qr" width="50%" style="vertical-align: middle; text-align: center;">
                    <img src="data:image/png;base64,<?= $qrImage ?>" />
                </td>

                <!-- TEXT INFO -->
                <td class="text" width="50%" style="vertical-align: middle;">
                    <div><strong>Invoice No:</strong> <?= $invoice_no ?></div>
                    <div><strong>Vendor:</strong> <?= $vendor ?></div>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>