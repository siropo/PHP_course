<?php
$pageTitle = 'Списък';
include 'includes/header.php';

?>
<a href="add_expense.php">Добави нов разход</a>
<form method="POST" action="index.php">
    <select name="type">
        <option value="all">Всички</option>
        <?php

        $filter = isset($_POST['type'])? (int)$_POST['type'] : 'all';

        foreach ($types as $key => $value) {
            $selected = $filter == $key? 'selected': '';
            echo '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
        }
        ?>
    </select>
    <input type="submit" value=" фиртър " />
</form>

<table border="1">
    <tr>
        <td>Дата</td>
        <td>Име</td>
        <td>Сума</td>
        <td>Тип</td>
    </tr>
    <?php

    (float)$costSum = 0;

    if (file_exists('data.txt')) {
        $result = file('data.txt');
        foreach ($result as $value) {

            $columns = explode('!', $value);

            if ($columns[3] == $filter || $filter == 'all') {
                echo '<tr>
                        <td>' . $columns[0] . '</td>
                        <td>' . $columns[1] . '</td>
                        <td>' . number_format($columns[2], 2) . '</td>
                        <td>' . $types[trim($columns[3])] . '</td>
                     </tr>';
                $costSum += (float)$columns[2];
            }

        }
    }
    ?>
    <tr>
        <td>---</td>
        <td>---</td>
        <td><?= number_format($costSum, 2) ?></td>
        <td>---</td>
    </tr>

</table>
<?php
include 'includes/footer.php';
?>
