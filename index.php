<?php
session_start();

if (!isset($_SESSION['timestamp']) || time() - $_SESSION['timestamp'] > 300) {
    $_SESSION['history'] = [];
    $_SESSION['timestamp'] = time();
}

$result = '';

if (isset($_POST['submit'])) {
    $num1 = $_POST['num1'];
    $num2 = $_POST['num2'];
    $operator = $_POST['operator'];

    switch ($operator) {
        case '+':
            $result = $num1 + $num2;
            break;
        case '-':
            $result = $num1 - $num2;
            break;
        case '*':
            $result = $num1 * $num2;
            break;
        case '/':
            if ($num2 != 0) {
                $result = $num1 / $num2;
            } else {
                $result = 'Nie można dzielić przez zero.';
            }
            break;
        default:
            $result = 'Nieprawidłowy operator.';
    }

    array_unshift($_SESSION['history'], "$num1 $operator $num2 = $result");
    $_SESSION['history'] = array_slice($_SESSION['history'], 0, 4);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prosty Kalkulator</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            text-align: center;
            background-color: #f0f0f0;
            color: #333;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h1 {
            margin-bottom: 20px;
            font-size: 2em;
            animation: rainbow 5s infinite linear;
        }

        @keyframes rainbow {
            0% {
                color: red;
            }
            16.67% {
                color: orange;
            }
            33.33% {
                color: yellow;
            }
            50% {
                color: green;
            }
            66.67% {
                color: blue;
            }
            83.33% {
                color: indigo;
            }
            100% {
                color: violet;
            }
        }

        .calculator-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin-right: 20px;
            display: flex;
            flex-direction: column;
        }

        input, select, button {
            width: calc(100% - 12px);
            padding: 10px;
            font-size: 16px;
            margin: 5px 0;
            box-sizing: border-box;
        }

        select {
            width: 100%;
        }

        button {
            background-color: #0066cc;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0052a3;
        }

        p {
            font-size: 20px;
            margin: 10px 0 0 0;
        }

        h2 {
            margin-top: 20px;
            color: #0066cc;
        }

        .history {
            text-align: left;
            max-width: 300px;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        li {
            border-bottom: 1px solid #ddd;
            padding: 8px;
        }
    </style>
</head>
<body>

<h1>Prosty Kalkulator PHP</h1>

<div class="calculator-container">
    <form method="post" action="">
        <input type="text" name="num1" placeholder="Podaj liczbę" required>
        <select name="operator" required>
            <option value="+" selected>+</option>
            <option value="-">-</option>
            <option value="*">*</option>
            <option value="/">/</option>
        </select>
        <input type="text" name="num2" placeholder="Podaj liczbę" required>
        <button type="submit" name="submit">Oblicz</button>
        <?php
        if (isset($_POST['submit'])) {
            echo '<h2>Wynik:</h2>';
            echo '<p>' . $result . '</p>';
        }
        ?>
    </form>

    <div class="history">
        <h2>Historia</h2>
        <ul>
            <?php
            foreach ($_SESSION['history'] as $entry) {
                echo '<li>' . $entry . '</li>';
            }
            ?>
        </ul>
    </div>
</div>

</body>
</html>