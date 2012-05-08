<style>
	.userdetail { border: 0px; padding: 0px;}
	.overlay ol { padding-left: 10px; padding-top:10px;}
	.overlay li { padding-top: 10px; font-size: 14px}
	td { border: 0px; }
	td.topheader { text-align:center; background-color:#492121; color:#FFF; vertical-align:middle; font-size:16px;}
	td.header { text-align:left;  font-size:12px; background-color:#eee; color:#311; vertical-align:middle; padding-left: 2px; padding-bottom: 2px; padding-top: 2px;}
</style>

<div style="width:600px; height:500px; padding:8px; margin:8px; overflow:auto;">

<table width="595px" class="userdetail">
    <tr>
        <td width="100%%" class="topheader">
			<?php print $company?>
         </td>
    </tr>
    <tr>
    	<td class="header">
             
    <ol class="overlay">
    <?php foreach($user as $u):?>
        <li>
<!--            <img style="width:35px;height:50px;" src="<?php print base_url().'public/avatar/'.$u['picture'];?>">-->
            <?php print 'Name:'.' '.$u['salutation'].' '.$u['firstname'].' '.$u['lastname'].' | '.'Position:'.' '.$u['position'];?>
        </li>
    <?php endforeach;?>
    </ol>
    <?php
    //print_r($user);
    ?>    
    
  </td>
  </tr>
  </table>  
    
</div>