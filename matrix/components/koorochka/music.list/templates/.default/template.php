<?
/**
 * @var array $arResult
 * @var array $arParams
 */

use Matrix\Main\Localization\Loc;
Loc::loadLanguageFile(__FILE__);

if(empty($arResult["ITEMS"])):
?>
    <div class="alert alert-info"><?=Loc::getMessage("MUSIC_LIST_EMPTY")?></div>
<?else:?>

    <?
    $class = "default";
    foreach ($arResult["ITEMS"] as $key=>$arItem):
        if($key){
            if($key%2){
                $class = "warning";
            }else{
                $class = "default";
            }
        }
        else{
            $class = "primary";
        }
    ?>
        <div class="panel panel-<?=$class?>">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <?=$arItem["NAME"]?>

                    <i class="glyphicon glyphicon-edit pointer"></i>
                    <i class="glyphicon glyphicon glyphicon-trash pointer"></i>

                </h3>
            </div>
            <div class="panel-body">

                <audio id="player-<?=$arItem["ID"]?>"
                       src="<?=$arItem["FILE"]["SRC"]?>"></audio>

                <button type="button"
                        onclick="musicList.playback(this, 0.5)"
                        data-toggle="tooltip"
                        data-placement="bottom"
                        title="<?=Loc::getMessage("MUSIC_LIST_PLAY_SLOV_VERY")?>"
                        class="btn btn-default">
                    <i class="glyphicon glyphicon-fast-backward"></i>
                </button>
                <button type="button"
                        onclick="musicList.playback(this, 0.7)"
                        data-toggle="tooltip"
                        data-placement="bottom"
                        title="<?=Loc::getMessage("MUSIC_LIST_PLAY_SLOV")?>"
                        class="btn btn-default">
                    <i class="glyphicon glyphicon-step-backward pointer"></i>
                </button>
                <button type="button"
                        onclick="musicList.play(this)"
                        data-id="<?=$arItem["ID"]?>"
                        data-toggle="tooltip"
                        data-placement="bottom"
                        title="<?=Loc::getMessage("MUSIC_LIST_PLAY")?>"
                        class="btn btn-default">
                    <i class="glyphicon glyphicon-play pointer"></i>
                </button>
                <button type="button"
                        onclick="musicList.pause(this)"
                        data-id="<?=$arItem["ID"]?>"
                        data-toggle="tooltip"
                        data-placement="bottom"
                        title="<?=Loc::getMessage("MUSIC_LIST_PAUSE")?>"
                        class="btn btn-default">
                    <i class="glyphicon glyphicon-pause pointer"></i>
                </button>
                <button type="button"
                        onclick="musicList.stop(this)"
                        data-id="<?=$arItem["ID"]?>"
                        data-toggle="tooltip"
                        data-placement="bottom"
                        title="Tooltip on bottom"
                        class="btn btn-default">
                    <i class="glyphicon glyphicon-stop pointer"></i>
                </button>
                <button type="button"
                        onclick="musicList.playback(this, 2)"
                        data-toggle="tooltip"
                        data-placement="bottom"
                        title="<?=Loc::getMessage("MUSIC_LIST_PLAY_FAST")?>"
                        class="btn btn-default">
                    <i class="glyphicon glyphicon-step-forward pointer"></i>
                </button>
                <button type="button"
                        onclick="musicList.playback(this, 4)"
                        data-toggle="tooltip"
                        data-placement="bottom"
                        title="<?=Loc::getMessage("MUSIC_LIST_PLAY_FAST_VERY")?>"
                        class="btn btn-default">
                    <i class="glyphicon glyphicon glyphicon-fast-forward pointer"></i>
                </button>
            </div>
            <?if(!$key):?>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-9">
                            <div class="progress">
                                <div class="progress-bar progress-track"></div>
                            </div>
                            <div class="text-16">
                                <i class="glyphicon glyphicon-time"></i>
                                <i class="player-duration"></i>
                                <i class="glyphicon glyphicon-music"></i>
                                <i class="player-timer"></i>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-3 text-right">
                            <div class="progress">
                                <div class="progress-bar"
                                     role="progressbar"
                                     aria-valuenow="60"
                                     aria-valuemin="0"
                                     aria-valuemax="100"
                                     style="width: 90%;">
                                    <i class="glyphicon glyphicon-signal"></i> 60%
                                </div>
                            </div>
                            <div>
                                <button type="button"
                                        data-toggle="tooltip"
                                        data-placement="bottom"
                                        title="Tooltip on bottom"
                                        class="btn btn-default">
                                    <i class="glyphicon glyphicon-volume-off pointer"></i>
                                </button>
                                <button type="button"
                                        data-toggle="tooltip"
                                        data-placement="bottom"
                                        title="Tooltip on bottom"
                                        class="btn btn-default">
                                    <i class="glyphicon glyphicon-volume-off pointer"></i>
                                </button>
                                <button type="button"
                                        data-toggle="tooltip"
                                        data-placement="bottom"
                                        title="Tooltip on bottom"
                                        class="btn btn-default">
                                    <i class="glyphicon glyphicon-volume-up pointer"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?endif;?>
        </div>

    <?endforeach;?>

<?endif;?>