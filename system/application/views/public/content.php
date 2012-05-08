    <div class="i_body inline-block clear">
        <?php if(!isset($depan)):?>
            <div id="breadcrumb">
                    <?php print $this->bep_site->get_breadcrumb();?>
            </div>
        <?php endif;?>
        <a name="top"></a>
        <?php print displayStatus();?>
        <?php print (isset($content)) ? $content : NULL; ?>
        <?php
        if( isset($page)){
        if( isset($module)){
                $this->load->module_view($module,$page);
            } else {
                $this->load->view($page);
            }}
        ?>
    </div>