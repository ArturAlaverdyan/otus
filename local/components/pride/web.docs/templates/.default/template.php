<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?php 
\Bitrix\UI\Toolbar\Facade\Toolbar::addButton([
    "classList" => ["ui-btn ui-btn-primary"],
	"link" => "/services/web_docs/list_of_appeals.php?APPEAL=36",
	"text" => "Избранное"
]);

	foreach($arResult["LISTS"] as $title => $list)
	{
?>
	<H1 class = "miniTitle"><?php echo $title; ?></H1>
	<div class="buttonsNotes">
			<?php 
				foreach ($list as $value)
				{
			?>
                    <div>
                        <a  href="/services/web_docs/list_of_appeals.php?APPEAL=<?php echo $value['IBLOCK']; ?>" class = "toolsButton" target="_self">Открыть список</a>
                        <div class = "addButton">
                            <a href = "/services/web_docs/appeal.php?APPEAL=<?php echo $value['IBLOCK']; ?>" target="_self">
                                <span><?php echo $value['TITLE']; ?></span>
                            </a>
                        </div>
                    </div>
				<?php
				}
				?>
	</div>
<?php
	}
?>