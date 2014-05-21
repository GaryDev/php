<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="<?php echo $this->baseUrl;?>/files/admin/css/public.css" rel="stylesheet"/>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/admin/scripts/load.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl;?>/files/editor/ckeditor.js"></script>
<title><?php echo $this->title;?></title>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="navigation">
    <tr>
        <td class="content"><span class="description">当前位置：</span>修改配置参数</td>
    </tr>
</table>
<form action="" method="post" enctype="multipart/form-data" name="editorForm" id="editorForm">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
<?php
foreach($this->dataModels as $name => $model) {
    $value = isset($this->data[$name]) ? $this->data[$name] : '';
?>
        <tr>
            <td><?php echo $model['title'];?>：<?php echo !empty($model['description']) ? "<br/><span style=\"color:#cccccc;\">{$model['description']}</span>" : '';?></td>
            <td>
<?php
    if ($model['inputType'] == 'text') {
?>
                <input name="<?php echo $name;?>" type="text" class="input inputCommonSize" id="<?php echo $name;?>" value="<?php echo $value;?>" size="<?php echo $model['maxlength'];?>" maxlength="<?php echo $model['maxlength'];?>" />
<?php
    } else if ($model['inputType'] == 'textarea') {
?>
                <textarea name="<?php echo $name;?>" id="<?php echo $name;?>" cols="50" rows="5" class="input inputCommonSize"><?php echo $value;?></textarea>
<?php
    } else if ($model['inputType'] == 'editor') {
?>
                <textarea id="<?php echo $name;?>" name="<?php echo $name;?>" ><?php echo $value;?></textarea>
<script language="javascript">
CKEDITOR.replace('<?php echo $name;?>');
</script>
<?php
    } else if ($model['inputType'] == 'radio'){
?>
<?php
        foreach($model['options'] as $option) {
?>
                <input type="radio" name="<?php echo $name;?>" value="<?php echo $option['value'];?>" <?php if ($value == $option['value']){echo 'checked';}?> /><?php echo $option['key'];?>
<?php
        }
?>
<?php
    } else if ($model['inputType'] == 'checkbox'){
?>
<?php
        $valueOptions = explode(',', $value);
        foreach($model['options'] as $option) {
?>
                <input type="checkbox" name="<?php echo $name;?>[]" value="<?php echo $option['value'];?>" <?php if (in_array($option['value'], $valueOptions)){echo 'checked';}?> /><?php echo $option['key'];?>
<?php
        }
?>
<?php
    }
?>
            </td>
        </tr>
<?php
}
?>

        <tr>
            <td>&nbsp;</td>
            <td><input name="submit" type="submit" id="submit" value="提交" class="button" /></td>
        </tr>
    </table>
</form>
</body>
</html>