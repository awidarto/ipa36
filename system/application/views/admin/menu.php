<!--
When creating a new menu item on the top-most level
Please ensure that you assign the LI a unique ID

Examples can be seen below for menu_bep_system
-->
<ul id="menu">
    <li id="menu_bep_home"><?php print anchor('admin',$this->lang->line('backendpro_dashboard'),array('class'=>'icon_house'))?></li>
    <?php if(check('Decoder',NULL,FALSE)):?><li><?php print anchor('decoder/admin/decoder','Scanner',array('class'=>'icon_cog'))?></li><?php endif;?>
    <?php if(check('Decoder',NULL,FALSE)):?><li><?php print anchor('decoder/admin/decoder/quick','Quick Scan',array('class'=>'icon_cog'))?></li><?php endif;?>
    <?php if(check('Decoder',NULL,FALSE)):?><li><?php print anchor('media/admin/attendance','Convention Attendance Log',array('class'=>'icon_cog'))?></li><?php endif;?>
    <?php if(check('Decoder',NULL,FALSE)):?><li><?php print anchor('media/admin/attendanceoff','Offcial Attendance Log',array('class'=>'icon_cog'))?></li><?php endif;?>
    <?php if(check('Decoder',NULL,FALSE)):?><li><?php print anchor('media/admin/attendancevis','Visitor Attendance Log',array('class'=>'icon_cog'))?></li><?php endif;?>
    <?php if(check('ConvexMember',NULL,FALSE)):?><li id="menu_bep_convex" ><?php print anchor('media/admin/convex','Master Data',array('class'=>'icon_group'))?></li><?php endif;?>
    <?php if(check('ConvexMember',NULL,FALSE)):?><li id="menu_bep_officials" ><?php print anchor('media/admin/officials','Officials',array('class'=>'icon_group'))?></li><?php endif;?>
    <?php if(check('ConvexMember',NULL,FALSE)):?><li id="menu_bep_visitors" ><?php print anchor('media/admin/visitors','Visitors',array('class'=>'icon_group'))?></li><?php endif;?>
    <?php if(check('ConvexMember',NULL,FALSE)):?><li id="menu_bep_convention" ><?php print anchor('media/admin/convention','Convention',array('class'=>'icon_group'))?>
        <ul>
            <?php if(check('ConvexMember',NULL,FALSE)):?><li id="menu_bep_conventionpd" ><?php print anchor('media/admin/conventionpd','Professional Domestic',array('class'=>'icon_group'))?></li><?php endif;?>
            <?php if(check('ConvexMember',NULL,FALSE)):?><li id="menu_bep_conventionpo" ><?php print anchor('media/admin/conventionpo','Professional Overseas',array('class'=>'icon_group'))?></li><?php endif;?>
            <?php if(check('ConvexMember',NULL,FALSE)):?><li id="menu_bep_conventionsd" ><?php print anchor('media/admin/conventionsd','Student Domestic',array('class'=>'icon_group'))?></li><?php endif;?>
            <?php if(check('ConvexMember',NULL,FALSE)):?><li id="menu_bep_conventionso" ><?php print anchor('media/admin/conventionso','Student Overseas',array('class'=>'icon_group'))?></li><?php endif;?>
        </ul>
    </li><?php endif;?>
    <?php if(check('ConvexMember',NULL,FALSE)):?><li id="menu_bep_shortcourses" ><?php print anchor('media/admin/shortcourses','Short Courses',array('class'=>'icon_group'))?></li><?php endif;?>
    <?php if(check('ConvexMember',NULL,FALSE)):?><li id="menu_bep_golf" ><?php print anchor('media/admin/golf','Golf',array('class'=>'icon_group'))?></li><?php endif;?>
    <?php if(check('ConvexMember',NULL,FALSE)):?><li id="menu_bep_judge" ><?php print anchor('media/admin/judge','Judge',array('class'=>'icon_group'))?></li><?php endif;?>
    <?php if(check('ConvexMember',NULL,FALSE)):?><li id="menu_bep_galadinner" ><?php print anchor('media/admin/galadinner','Gala Dinner',array('class'=>'icon_group'))?></li><?php endif;?>
    <?php if(check('ConvexMember',NULL,FALSE)):?><li id="menu_bep_foc" ><?php print anchor('media/admin/foc','Exhibitor Entitlement',array('class'=>'icon_group'))?></li><?php endif;?>
    <?php if(check('ConvexMember',NULL,FALSE)):?><li id="menu_bep_mp" ><?php print anchor('media/admin/mp','Media Person',array('class'=>'icon_group'))?></li><?php endif;?>
    <?php if(check('ConvexMember',NULL,FALSE)):?><li id="menu_bep_boothbuyer" ><?php print anchor('media/admin/boothbuyer','Booth Buyer',array('class'=>'icon_group'))?></li><?php endif;?>
    <?php if(check('BoothAdmin',NULL,FALSE)):?><li id="menu_bep_booth" ><?php print anchor('auth/admin/booth','Booth List',array('class'=>'icon_cog'))?></li><?php endif;?>

    <?php if(check('ConvexMember',NULL,FALSE)):?><li id="menu_bep_company" ><?php print anchor('company/admin/convention','By Company',array('class'=>'icon_group'))?>
<!--
        <ul>
            <?php if(check('ConvexMember',NULL,FALSE)):?><li id="menu_bep_conventionpd" ><?php print anchor('company/admin/conventionpd','Professional Domestic',array('class'=>'icon_group'))?></li><?php endif;?>
            <?php if(check('ConvexMember',NULL,FALSE)):?><li id="menu_bep_conventionpo" ><?php print anchor('company/admin/conventionpo','Professional Overseas',array('class'=>'icon_group'))?></li><?php endif;?>
            <?php if(check('ConvexMember',NULL,FALSE)):?><li id="menu_bep_conventionsd" ><?php print anchor('company/admin/conventionsd','Student Domestic',array('class'=>'icon_group'))?></li><?php endif;?>
            <?php if(check('ConvexMember',NULL,FALSE)):?><li id="menu_bep_conventionso" ><?php print anchor('company/admin/conventionso','Student Overseas',array('class'=>'icon_group'))?></li><?php endif;?>
            <?php if(check('ConvexMember',NULL,FALSE)):?><li id="menu_bep_shortcourses" ><?php print anchor('company/admin/shortcourses','Short Courses',array('class'=>'icon_group'))?></li><?php endif;?>
            <?php if(check('ConvexMember',NULL,FALSE)):?><li id="menu_bep_golf" ><?php print anchor('company/admin/golf','Golf',array('class'=>'icon_group'))?></li><?php endif;?>
            <?php if(check('ConvexMember',NULL,FALSE)):?><li id="menu_bep_galadinner" ><?php print anchor('company/admin/galadinner','Gala Dinner',array('class'=>'icon_group'))?></li><?php endif;?>
            <?php if(check('ConvexMember',NULL,FALSE)):?><li id="menu_bep_foc" ><?php print anchor('company/admin/foc','Exhibitor & FoC',array('class'=>'icon_group'))?></li><?php endif;?>
            <?php if(check('ConvexMember',NULL,FALSE)):?><li id="menu_bep_mp" ><?php print anchor('company/admin/mp','Media Person',array('class'=>'icon_group'))?></li><?php endif;?>
            <?php if(check('ConvexMember',NULL,FALSE)):?><li id="menu_bep_boothbuyer" ><?php print anchor('company/admin/boothbuyer','Booth Buyer',array('class'=>'icon_group'))?></li><?php endif;?>
        </ul>
-->
    </li><?php endif;?>


    <?php if(check('System',NULL,FALSE)):?>
    <li id="menu_bep_system"><span class="icon_computer"><?php print $this->lang->line('backendpro_system')?></span>
        <ul>
            <?php if(check('BoothAdmin',NULL,FALSE)):?><li><?php print anchor('media/admin/outbox','Outbox',array('class'=>'icon_cog'))?></li><?php endif;?>
            <?php if(check('BoothAdmin',NULL,FALSE)):?><li><?php print anchor('auth/admin/import','Import',array('class'=>'icon_cog'))?></li><?php endif;?>
            <?php if(check('Members',NULL,FALSE)):?><li><?php print anchor('auth/admin/members',$this->lang->line('backendpro_members'),array('class'=>'icon_group'))?></li><?php endif;?>
            <?php if(check('Access Control',NULL,FALSE)):?><li><?php print anchor('auth/admin/access_control',$this->lang->line('backendpro_access_control'),array('class'=>'icon_shield'))?></li><?php endif;?>
            <?php if(check('Settings',NULL,FALSE)):?><li><?php print anchor('admin/settings',$this->lang->line('backendpro_settings'),array('class'=>'icon_cog'))?></li><?php endif;?>
        </ul>
    </li>
    <?php endif;?>
</ul>