<?php

/** 
 * @var yii\web\View $this 
 * @var DriveFile[] $files 
 * 
*/
$this->title = 'My Files';
?>
<div class="body-content mt-5">
    <table class="table">
        <thead>
            <tr>
                <th>
                    Title
                </th>
                <th>
                    Thumbnail Link
                </th>
                <th>
                    EmbedLink (Download) Link
                </th>
                <th>
                    Modified Date
                </th>
                <th>
                    FileSize (MB)
                </th>
                <th>
                    Owner Names
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($files as $file):?>
                <tr>
                    <td>
                        <?= $file->getName();?>
                    </td>
                    <td>
                        <img src="<?= $file->getThumbnailLink() ?>">
                    </td>
                    <td>
                        <?php if($file->getWebContentLink()):?>
                            <a target="_blank" href="<?= $file->getWebContentLink();?>">(Download) Link</a>
                        <?php endif;?>
                    </td>
                    <td>
                        <?=date('Y-m-d',strtotime($file->getModifiedTime()))?>
                    </td>
                    <td>
                        <?=number_format($file->getSize()/1048576,2);?> MB
                    </td>
                    <td>
                        <?php $owners = []?>
                        <?php foreach($file->getOwners()??[] as  $owner):?>
                            <?php $owners[] = $owner->displayName ?>
                        <?php endforeach?>
                        <?= implode(', ',$owners);?>
                    </td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>