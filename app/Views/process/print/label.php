<!DOCTYPE html>
<html>

<head>
    <title>Print Label</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }

        .label-box {
            border: 2px solid #000;
            padding: 20px;
            width: 350px;
            margin: auto;
        }

        .material {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .details {
            font-size: 18px;
            margin-bottom: 15px;
        }

        img {
            width: 200px;
            height: 200px;
        }

        @media print {
            button {
                display: none;
            }

            body {
                margin: 0;
            }
        }
    </style>
</head>

<body>

    <div class="label-box">
        <div class="material"><?= $material ?></div>

        <div class="details">
            Qty: <b><?= $qty ?></b> <br>
            UOM: <b><?= $uom ?></b>
        </div>

        <img src="data:image/png;base64,<?= $qrImage ?>" alt="QR Code">

        <br><br>
        <button onclick="window.print()">Print Label</button>
    </div>

</body>

</html>