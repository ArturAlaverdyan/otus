<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class = "headAppealCreation">
	<a class="linkDocs" href="<?php echo $arResult['TABLE_LINK']; ?>" target="_self">Открыть список</a> 
	<?php if(!empty($arResult["ERROR"])){ ?> <span class = "errorLine"><?php echo $arResult["ERROR"]; ?></span> <?php } ?>
	<?php if(!empty($arResult["VALUES"]["NAME"])){ ?> <H1 class = "titleAppeal"><?php echo $arResult["VALUES"]["NAME"]; ?></H1> <?php } ?>

	<?php 
		if (!empty($arResult["VALUES"]["STATUS"])) // ЕСЛИ ЕСТЬ СТАТУС ИЛИ КОММЕНТАРИЙ - ВЫВОДИМ
		{
			echo '<div class = "dataAppeal">';
			echo '<p><b>Статус:</b></p>';
			echo '<span><i>'.$arResult["VALUES"]["STATUS"].'</i></span>';
		}
		if (!empty($arResult["VALUES"]["COMMENTS"]))
		{
			echo '<p><b>История документа: </b></p>';
			echo '<span><i>'.$arResult["VALUES"]["COMMENTS"].'</i></span><br><br>';
			echo '</div>';
		}
	?>
</div>


<div class="textForPrint" style="display:none;">
	<?php
		if (!empty($arResult["VALUES"]["FOR_PRINT"])) // ВСТАВИТЬ ТЕКСТ ДЛЯ ПЕЧАТИ ЕСЛИ ЕСТЬ
		{
			echo $arResult["VALUES"]["FOR_PRINT"];
		}
	?>
</div>

<div class="bodyAppealCreation">
	<form action = "" method = "POST"  enctype="multipart/form-data">
		<table class="tableCreateAppeal">
			<thead>
				<tr>
					<td colspan="2">
						<?php
							if (!empty($arResult["TOP_TEXT"])) // ВСТАВИТЬ ВЕРХНИЙ ТЕКСТ
							{
								foreach ($arResult["TOP_TEXT"] as $text)
								{
									echo '<p>'.$text.'</p>';
								}
							}
						?>
					</td>
				</tr>
			</thead>
			<tbody>
					<?php
						foreach ($arResult['FIELDS'] as $tag)
						{
							echo (!empty($tag[2]))? '<tr style = "display:none;">' : '<tr>';
								echo '<td><span>'.$tag[0].'</span></td>';
								echo '<td>'.$tag[1].'</td>';
							echo '</tr>';
						}
					?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="2">
						<?php
							if (!empty($arResult["BOTTOM_TEXT"])) // ВСТАВИТЬ НИЖНИЙ ТЕКСТ
							{
								foreach ($arResult["BOTTOM_TEXT"] as $text)
								{
									echo '<p>'.$text.'</p>';
								}
							}
						?>
					</td>
				</tr>
			</tfoot>
		</table>
		<div class="buttsForm">
			<?php if (!empty($arResult["BUTTON_SEND"])) { ?> <input type="submit" name="buttSend" value="Отправить" /> <?php } ?>
            <?php if (!empty($arResult["BUTTON_CHANGE"])) { ?> <input type="submit" name="buttChange" value="Изменить" /> <?php } ?>
            <?php if (!empty($arResult["BUTTON_RESTART"])) { ?> <input type="submit" name="buttRestart" value="Возобновить" /> <?php } ?>
            <?php if (!empty($arResult["BUTTON_DELETE"])) { ?> <input type="submit" name="buttAnnul" value="Аннулировать" /> <?php } ?>
            <?php if (!empty($arResult["BUTTON_PRINT"])) { ?> <input type="button" name="buttPrint" value="Печать" /> <?php } ?>
            <input type="button" name="buttCancel" value="Назад" />
		</div>
	</form>
</div>