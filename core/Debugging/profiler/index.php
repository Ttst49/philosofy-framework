!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Viewer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .line {
            margin-bottom: 10px;
        }

        .error {
            color: red;
        }
        .tabs {
            display: flex;
            flex-wrap: wrap;
        }

        input[type="radio"] {
            display: none;
        }

        label {
            padding: 10px;
            background-color: #f0f0f0;
            cursor: pointer;
            border: 1px solid #ccc;
        }

        label:hover {
            background-color: #e0e0e0;
        }

        input[type="radio"]:checked + label {
            background-color: #ccc;
        }

        .tab-content {
            padding: 20px;
            display: none;
            border: 1px solid #ccc;
        }

        #tab1:checked ~ #content1,
        #tab2:checked ~ #content2,
        #tab3:checked ~ #content3 {
            display: block;
        }
    </style>
</head>
<body>
<div class="container">

    <div class="tabs">
        <input type="radio" name="tab" id="tab1" checked>
        <label for="tab1">Dev.log</label>

        <input type="radio" name="tab" id="tab2">
        <label for="tab2">Prod.log</label>

        <input type="radio" name="tab" id="tab3">
        <label for="tab3">ULM</label>

        <div class="tab-content" id="content1">
            <?php
            $fh_dev = fopen('../../../logs/dev/dev.log', 'r');
            while (!feof($fh_dev)) {
                $ligne = fgets($fh_dev);

                $escapedLigne = htmlspecialchars($ligne);

                if (str_contains($escapedLigne, "ERROR") || str_contains($escapedLigne, "EXCEPTION")) {
                    echo "<hr>";

                    echo "<br>";
                    echo '<div class="line error">' . $escapedLigne . "</div>";
                } else {
                    echo '<div class="line">' . $escapedLigne . "</div>";
                }
            }
            fclose($fh_dev);
            ?>
        </div>

        <div class="tab-content" id="content2">
            <?php
            $fh_prod = fopen('../../../logs/prod/prod.log', 'r');
            if (!feof($fh_prod)) {
                echo "<br>";
                echo "<hr>";
                echo "No data for the moment";
                echo "<hr>";
            }
            while (!feof($fh_prod)) {
                $ligne = fgets($fh_prod);

                $escapedLigne = htmlspecialchars($ligne);

                if (str_contains($escapedLigne, "ERROR") || str_contains($escapedLigne, "EXCEPTION")) {
                    echo "<hr>";

                    echo "<br>";
                    echo '<div class="line error">' . $escapedLigne . "</div>";
                } else {
                    echo '<div class="line">' . $escapedLigne . "</div>";
                }
            }
            fclose($fh_prod);
            ?>
        </div>

        <div class="tab-content" id="content3">
            Contenu de l'onglet 3
        </div>
    </div>
</div>
</body>
</html>