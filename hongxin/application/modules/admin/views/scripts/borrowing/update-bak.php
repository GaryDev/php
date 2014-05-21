<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="<?php echo $this->baseUrl;?>/files/admin/css/public.css" rel="stylesheet"/>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/admin/scripts/load.js"></script>
<title><?php echo $this->title;?></title>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="navigation">
    <tr>
        <td class="content"><span class="description">当前位置：</span><a href="<?php echo $this->projectUrl(array('action'=>'index')) ;?>">借款列表</a> &gt; 修改借款信息</td>
    </tr>
</table>
<form id="editorForm" name="editorForm" method="post" action="">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
        <tr>
        	<td>借款用户：</td>
        	<td><?php echo $this->row['userName']?></td>
       	</tr>
        <tr>
        	<td>借款编号：</td>
        	<td><?php echo $this->row['code']?></td>
       	</tr>
        <tr>
        	<td>状态：</td>
        	<td>
				<label><input type="radio" name="status" id="status" value="1" <?php echo $this->row['status'] == '1' ? ' checked' : '';?>/> 未审核</label>
				<label><input type="radio" name="status" id="status" value="2" <?php echo $this->row['status'] == '2' ? ' checked' : '';?>/> 已审核发布</label>
				<label><input type="radio" name="status" id="status" value="3" <?php echo $this->row['status'] == '3' ? ' checked' : '';?> disabled="disabled"/> <span title="系统根据最后一次借款自动修改">借款完成</span></label>
				<label><input type="radio" name="status" id="status" value="4" <?php echo $this->row['status'] == '4' ? ' checked' : '';?>/> 作废</label>
				<?php echo $this->row['status'] == 1 ? '' : '&nbsp;&nbsp;最后修改于' . date('Y-m-d H:i:s', $this->row['statusUpdateTime']);?>
			</td>
       	</tr>
        <tr>
            <td width="12%">借款标题：</td>
            <td width="88%"><input name="title" type="text" class="input" id="title" size="50" maxlength="50" value="<?php echo $this->row['title']?>" />            </td>
        </tr>
        <tr>
			<td>借款金额：</td>
        	<td><input name="amount" type="text" class="input" id="amount" value="<?php echo $this->row['amount']?>"  /> 元</td>
       	</tr>
        <tr>
			<td>期限：</td>
        	<td><input name="deadline" type="text" class="input" id="deadline" value="<?php echo $this->row['deadline']?>"  /> 
        		个月</td>
       	</tr>
        <tr>
			<td>月利率：</td>
        	<td><input name="monthInterestRate" type="text" class="input" id="monthInterestRate" value="<?php echo $this->row['monthInterestRate']?>"/> 
        		%</td>
       	</tr>
        <tr>
			<td>最小标金额：</td>
        	<td><input name="amountMinUnit" type="text" class="input" id="amountMinUnit" value="<?php echo $this->row['amountMinUnit']?>"/>
        		元</td>
       	</tr>
        <tr>
			<td>最大标金额：</td>
        	<td><input name="amountMaxUnit" type="text" class="input" id="amountMaxUnit" value="<?php echo $this->row['amountMaxUnit']?>" />
元</td>
       	</tr>
        <tr>
			<td>开始时间：</td>
        	<td><?php echo $this->row['startTime'] > 0 ? date('Y-m-d H:i:s', $this->row['startTime']) : '未开始';?></td>
       	</tr>
        <tr>
        	<td>发布时间：</td>
        	<td><?php echo date('Y-m-d H:i:s', $this->row['addTime']);?></td>
       	</tr>
        <tr>
            <td>借款说明：</td>
            <td><textarea name="notes" id="notes" cols="50" rows="5" class="input" ><?php echo $this->row['notes']?></textarea></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input name="submit" type="submit" id="submit" value="提交" class="button" /></td>
        </tr>
    </table>
</form>
</body>
</html>