<?php

$pageTitle = 'Добави разход';
include 'includes/header.php';

function saveData($data) {
    $newData = trim($data);
    $newData = str_replace('!', '', $data);
    return $newData;
}

if ($_POST) {
    $name = saveData($_POST['name']);
    $cost = saveData($_POST['cost']);
    $selectedType = (int)$_POST['type'];
    $date = date('d.m.Y');

    $error = false;

    if (mb_strlen($name) < 4) {
        echo '<p>Името е прекалено късо.</p>';
        $error = true;
    }

    if (!is_numeric($cost)) {
        echo '<p>Невалидна сума.</p>';
        $error = true;
    }

    if (!array_key_exists($selectedType, $types)) {
        echo '<p>Невалидна група</p>';
        $error = true;
    }

    if (!$error) {
        $result = $date . '!' . $name . '!' . $cost . '!' . $selectedType . "\n";
        if (file_put_contents('data.txt', $result, FILE_APPEND)) {
            echo 'Записа е успешен <br>';
        }
    }

}

?>
    <a href="index.php">Списък</a>
    <form method="POST">
        <div>Име:<input type="text" name="name" /></div>
        <div>Сума:<input type="text" name="cost" /></div>
        <div>
            <select name="type">
                <?php
                foreach ($types as $key => $value) {
                    echo '<option value="' . $key . '">' . $value .
                        '</option>';
                }
                ?>
            </select>
        </div>
        <div><input type="submit" value="Добави" /></div>
    </form>
<?php
include 'includes/footer.php';
?>