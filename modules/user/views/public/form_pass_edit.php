<div id="user_box" class="grid_9">
<h3><?php print $header?></h3>
<?php print form_open('user/changepass',array('class'=>'horizontal'))?>
    <fieldset>
        <ol>
            <li>
                <label for="password">New password :</label>
                <input type="password" name="password" id="password" size="32" class="text" />
            </li>
            <li>
                <label for="confirm_password"><?php print $this->lang->line('userlib_confirm_password')?>:</label>
                <input type="password" name="confirm_password" id="confirm_password" size="32" class="text" />
            </li>
            <?php
            // Only display captcha if needed
            if($this->preference->item('use_registration_captcha')){
            ?>
            <li class="captcha">
                <label for="recaptcha_response_field"><?php print $this->lang->line('userlib_captcha')?>:</label>
                <?php print $captcha?>
            </li>
            <?php } ?>
            <li class="submit">
            	<div class="buttons">
            		<a href="<?php print site_url('auth/login') ?>" class="negative">
            			<?php print $this->bep_assets->icon('cross') ?>
            			<?php print $this->lang->line('general_cancel')?>
            		</a>
            		<button type="submit" class="positive" name="submit" value="submit">
            			<?php print $this->bep_assets->icon('user') ?>
            			Change Password
            		</button>
            	</div>
            </li>
        </ol>
    </fieldset>
<?php print form_close()?>
</div>