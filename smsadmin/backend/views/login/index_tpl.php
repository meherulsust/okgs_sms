<form id="login" method="post" action="<?php echo site_url('login/dologin') ?>"> 
    <h1> Administrator Login.</h1>
    <?php $mt_tpl->load_element('login_flash_message')?>
    <div>
    	<label for="login_username">Username</label> 
    	<input type="text" name="username" id="login_username" class="field required" title="Please provide your username" required />
    </div>			

    <div>
    	<label for="login_password">Password</label>
    	<input type="password" name="password" id="login_password" class="field required" title="Password is required" required />
    </div>	
	<div>
    	<label for="Year">Year</label>
		<select name="ac_year" id="year" class="field" title="year" style="width:290px;">
			  <option value="">--Select Year--</option>
			  <option value="2016">2016</option>
		</select>
    </div>			
    
    <!-- <p class="forgot"><a href="#">Forgot your password?</a></p> -->
    			
    <div class="submit">
        <button type="submit">Log in</button>   
        
        <label>
        	<input type="checkbox" name="remember" id="login_remember" value="yes" />
            Remember my login on this computer
        </label>   
    </div>
     <p class="info">Please provide valid login information to login successfully.</p>
  
</form>	

