<ol>
<?php

$idx = 0;
foreach($emails as $email){
    print '<li>'.$ids[$idx].' - '.$email.' : <br /> Upload : '.$results[$idx]['status'].' '.$results[$idx]['msg'];
    if($results[$idx]['status'] == 'success'){
        printf('<br /><img src="%s" alt="%s">',base_url().'public/avatar/'.$results[$idx]['result_file'],$results[$idx]['id']);
    }
    print '</li>';
    $idx++;
}
?>
</ol>

<ul style="list-style-type:none;">
    <li>
        <div class="buttons">
    		<a href="<?php print base_url() ?>auth/admin/import" class="negative" >
    			<?php print $this->bep_assets->icon('arrow_left') ?>
    			Back to Import
    		</a>
    	</div>
    	<div class="clear"></div>
    </li>
</ul>