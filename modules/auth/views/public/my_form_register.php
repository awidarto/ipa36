<h2>Welcome to Quepasa Registration Center</h2>

<p>
    Please <?=anchor('auth/register','Register')?> or <?=anchor('auth/login','Sign In');?> to participate.
</p>

<h3><?php print $header?></h3>
<?php print form_open('auth/register',array('class'=>'horizontal'))?>
    <fieldset>
        <ol>
            <li>
                <label for="username"><?php print $this->lang->line('userlib_username')?> :*</label>
                <input type="text" name="username" id="username" size="32" class="text" value="<?php print $this->validation->username?>" />
            </li>
            <li>
                <label for="email"><?php print $this->lang->line('userlib_email')?> :*</label>
                <input type="text" name="email" id="email" class="text"  value="<?php print $this->validation->email?>" />
            </li>
            <li>
                <label for="password"><?php print $this->lang->line('userlib_password')?> :*</label>
                <input type="password" name="password" id="password" size="32" class="text" />
            </li>
            <li>
                <label for="confirm_password"><?php print $this->lang->line('userlib_confirm_password')?> *:</label>
                <input type="password" name="confirm_password" id="confirm_password" size="32" class="text" />
            </li>
            <li>
                <?php print form_label('Full Name :*','fullname')?>
                <?php print form_input('fullname',$this->validation->fullname,'id="fullname" class="text"')?>
            </li>
            <li>
                <?=form_label('Gender :','gender')?>
                Male <?=form_radio('gender','male',$this->validation->set_radio('gender','male'))?>
                Female <?=form_radio('gender','female',$this->validation->set_radio('gender','female'))?>
            </li>
            <li>
                <?php print form_label('Date of Birth :','dob')?>
                <?php //print form_input('dob',$this->validation->dob,'id="dob" class="text"')?>
                <?php print form_dropdown('dob_d', $this->config->item('days_of_month'),$this->validation->dob_d,'id="dob_d" style="width:4em;" onChange="javascript:validateage();"');?>
                <?php print form_dropdown('dob_m', $this->config->item('months_of_year'),$this->validation->dob_m,'id="dob_m" style="width:4em;" onChange="javascript:validateage();"');?>
                <?php print form_dropdown('dob_y', $this->config->item('valid_years'),$this->validation->dob_y,'id="dob_y" style="width:7em;" onChange="javascript:validateage();"');?>
                
            </li>
            <li>
                <?php print form_label('Company :*','company')?>
                <?php print form_input('company',$this->validation->company,'id="company" class="text"')?>
            </li>
            <li>
                <?php print form_label('Street :','street')?>
                <?php print form_input('street',$this->validation->street,'id="street" class="text"')?>
            </li>
            <li>
                <?php print form_label('City :','city')?>
                <?php print form_input('city',$this->validation->city,'id="city" class="text"')?>
            </li>
            <li>
                <?php print form_label('ZIP :','zip')?>
                <?php print form_input('zip',$this->validation->zip,'id="zip" class="text"')?>
            </li>
            <li>
                <?php print form_label('Country :','country')?>
                <?php print form_input('country',$this->validation->country,'id="country" class="text"')?>
                <?php print form_hidden('domain',base_url())?>
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
            		<button type="submit" class="positive" name="submit" value="submit">
            			<?php print $this->bep_assets->icon('user') ?>
            			<?php print $this->lang->line('userlib_register')?>
            		</button>
            		
            		<a href="<?php print site_url('auth/login') ?>" class="negative">
            			<?php print $this->bep_assets->icon('cross') ?>
            			<?php print $this->lang->line('general_cancel')?>
            		</a>
            	</div>
            </li>
        </ol>
    </fieldset>
<?php print form_close()?>