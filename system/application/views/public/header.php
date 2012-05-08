<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php print $this->bep_site->get_metatags(); ?>
	<title><?php print $header.' :: '.$this->preference->item('site_name')?></title>
	<?php print $this->bep_site->get_variables()?>
	<?php print $this->bep_assets->get_header_assets();?>
	<?php print $this->bep_site->get_js_blocks()?>
</head>

<body>
<div class="i_container" >
    <div class="i_wrapper" >
        <div id="header">
            <img src="<?=base_url()?>assets/images/header.png" alt="<?php print $this->preference->item('site_name')?>" />
        </div>