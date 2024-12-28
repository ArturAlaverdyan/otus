<?php
require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php";
$APPLICATION->setTitle("Докторы и их процедуры");
$APPLICATION->SetAdditionalCSS("/otus/style.css");
require $_SERVER["DOCUMENT_ROOT"] . '/otus/doctors_comp.php';

if (!empty($_POST))
{
    DoctorsComp::createElement($_POST);
    header('Location: https://'.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']);
}
$result['DOCTORS'] = DoctorsComp::getDataDoctors();
$result['PROCEDURES'] = DoctorsComp::getDataProcedures();
?>

    <div class = "addCard">
        <?php if (empty($_GET["add"]) && empty($_GET["ID"])) { ?><a href = "<?php echo $_SERVER['SCRIPT_NAME'];?>?add=doc">Добавить доктора</a> <?php } ?>
        <?php if (empty($_GET["add"]) && empty($_GET["ID"])) { ?><a href = "<?php echo $_SERVER['SCRIPT_NAME'];?>?add=proc">Добавить процедуру</a> <?php } ?>
        <?php if (!empty($_GET["add"]) || !empty($_GET["ID"])) { ?> <a href = "<?php echo $_SERVER['SCRIPT_NAME'];?>">Вернуться</a> <?php } ?>
    </div>

<?php if (!empty($_GET["add"]) && $_GET["add"] == 'proc') { ?>
    <h2>Добавить новую процедуру</h2>
    <form class = "myForm" action = "<?php echo $_SERVER['SCRIPT_NAME']; ?>" method = "POST">
        <input name = "newProcedur" placeholder = "Введите новую процедуру" /><br>
        <input type="submit" name="buttSend" value="Добавить" />
    </form>
<?php } ?>

<?php if (!empty($_GET["add"]) && $_GET["add"] == 'doc') { ?>
    <h2>Добавить нового доктора</h2>
    <form class = "myForm" action = "<?php echo $_SERVER['SCRIPT_NAME']; ?>" method = "POST">
        <input name = "FAMILIYA" placeholder = "Фамилия" /> <br>
        <input name = "IMYA" placeholder = "Имя" /> <br>
        <input name = "OTCHESTVO" placeholder = "Отчество" /> <br>
        <select name="PROCEDURES_ID[]" multiple >
            <?php foreach ($result['PROCEDURES'] as $k => $el) { ?>
                <option value="<?php echo $k; ?>"><?php echo $el; ?></option>
            <?php } ?>
        </select><br>
        <input type="submit" name="buttSend" value="Добавить" />
    </form>
<?php } ?>

<?php if (!empty($_GET["ID"])) { ?>
    <h1><?php echo $result['DOCTORS'][$_GET["ID"]]['FAMILIYA'].' '.$result['DOCTORS'][$_GET["ID"]]['IMYA'].' '.$result['DOCTORS'][$_GET["ID"]]['OTCHESTVO']; ?></h1>
    <h2>Подразделения:</h2>
    <?php foreach ($result['DOCTORS'][$_GET['ID']]['PROCEDURES_ID'] as $proc) { ?>
    <p><?php echo $result['PROCEDURES'][$proc] ?> </p>
<?php }
    } ?>

<?php if (empty($_GET["add"]) && empty($_GET["ID"])) { ?>
    <div class = "doctors">
    <?php foreach ($result['DOCTORS'] as $doc) { ?>
        <div class = "cardDocs">
            <a href = "<?php echo $_SERVER['SCRIPT_NAME'];?>?ID=<?php echo $doc['ID']?>" target="_self">
                <span><?php echo $doc['FAMILIYA'].' '.$doc['IMYA'].'<br>'.$doc['OTCHESTVO'] ?></span>
            </a>
        </div>
    <?php }?>
    </div>
<?php } ?>







<?php
require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php";
?>