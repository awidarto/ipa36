<div class="i_menu">
    <div class="i_menu_wrapper">
    	<ul>
        <!--    <li><?=site_url('www.ipa.or.id/convex',$this->bep_assets->icon('home1'))?></li> -->
            <li><a href="http://www.ipa.or.id/convex"><?=$this->bep_assets->icon('home1')?></a></li>
            <?php if(is_user()): ?>
                <li><?=anchor('user/profile','My Profile',(preg_match( '/user\/profile/',current_url()))?'class="active"':'');?></li>
                <li><?=anchor('register/convention','Convention',(preg_match( '/register\/convention/',current_url()))?'class="active"':'')?></li>
                <li><?=anchor('register/shortcourses','Short Courses',(preg_match( '/register\/shortcourses/',current_url()))?'class="active"':'')?></li>
                <li><?=anchor('register/exhibitor','Exhibition',(preg_match( '/register\/exhibitor/',current_url()))?'class="active"':'')?></li>
                <li><?=anchor('statics/sponsorship','Sponsorship',(preg_match( '/statics\/sponsorship/',current_url()))?'class="active"':'')?></li>
                <?php if(check('Decoder',NULL,FALSE)):?>
                    <li><?=anchor('decoder','Scanner',(preg_match( '/decoder$/',current_url()))?'class="active"':'')?></li>
                    <li><?=anchor('decoder/quick','Quick Scan',(preg_match( '/decoder\/quick/',current_url()))?'class="active"':'')?></li>
                <?php endif;?>
                <?php if(check('ConvexMember',NULL,FALSE)):?>
                    <li><?=anchor('register/visitor','Visitor',(preg_match( '/visitor/',current_url()))?'class="active"':'')?></li>
                <?php endif;?>
                <li><?=anchor('auth/logout','Logout');?></li>
            <?php else:?>
                <li><?=anchor('statics/howto','General Information');?></li>
                <li><?=anchor('register/visitor','Visitor Registration');?></li>
                <li><?=anchor('auth/login','Login');?></li>
            <?php endif;?>
    	</ul>
    </div>
</div>
<?php
//print_r($this->session->userdata);

?>

<div class="clear"></div>
<?php if(is_user()):?>
<div style="text-align:right;padding:2px 5px;"><?php print 'You are logged in as '.$this->session->userdata('salutation').' '.$this->session->userdata('firstname').' '.$this->session->userdata('lastname');?></div>
<div class="clear"></div>
<?php endif;?>
<?php
/*
<li><?=anchor('statics/terms','Terms & Conditions');?></li>

<li><?=anchor('statics/howto','General Information');?></li>
<li><?=anchor('statics/terms','Terms & Conditions');?></li>
*/
?>