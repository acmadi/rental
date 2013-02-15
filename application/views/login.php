<?php
	$LinkLogin = $this->config->item('login_url');
?>
<?php $this->load->view( 'common/meta' ); ?>

<body>
	<?php $this->load->view( 'common/header' ); ?>
    
    <div class="container-fluid login_page" id="maincontent">
        <br/>
        <div class="login_box">
			<form method="post" id="login_form">
				<div class="top_b">Sign in to Rental Software</div>
				<div id="alert" class="alert alert-info alert-login">Enter Username and Password.</div>
    				
				<div class="cnt_b">
					<div class="formRow">
						<div class="input-prepend">
							<span class="add-on"><i class="icon-user"></i></span><input type="text" id="username" name="username" placeholder="Username" value="" />
						</div>
					</div>
					<div class="formRow">
						<div class="input-prepend">
							<span class="add-on"><i class="icon-lock"></i></span><input type="password" id="password" name="password" placeholder="Password" value="" />
						</div>
					</div>
					<div class="hide formRow clearfix">
						<label class="checkbox"><input type="checkbox" /> Remember me</label>
					</div>
				</div>
				<div class="btm_b clearfix">
					<button id="button_submit" class="btn btn-inverse pull-right" type="submit">Login</button>
					<span class="hide link_reg"><a href="#reg_form">Not registered? Sign up here</a></span>
				</div>  
			</form>
			
			<form method="post" id="pass_form" style="display:none">
				<div class="top_b">Can't sign in?</div>    
					<div class="alert alert-info alert-login">
					Please enter your email address. You will receive a link to create a new password via email.
				</div>
				<div class="cnt_b">
					<div class="formRow clearfix">
						<div class="input-prepend">
							<span class="add-on">@</span><input type="text" placeholder="Your email address" />
						</div>
					</div>
				</div>
				<div class="btm_b tac">
					<button class="btn btn-inverse" type="submit">Request New Password</button>
				</div>  
			</form>
			
			<form method="post" id="reg_form" style="display:none">
				<div class="top_b">Sign up to Gebo Admin</div>
				<div class="alert alert-login">
					By filling in the form bellow and clicking the "Sign Up" button, you accept and agree to <a data-toggle="modal" href="#terms">Terms of Service</a>.
				</div>
				<div id="terms" class="modal hide fade" style="display:none">
					<div class="modal-header">
						<a class="close" data-dismiss="modal">Ãƒâ€”</a>
						<h3>Terms and Conditions</h3>
					</div>
					<div class="modal-body">
						<p>
						<!-- no terms -->
						</p>
					</div>
					<div class="modal-footer">
						<a data-dismiss="modal" class="btn" href="#">Close</a>
					</div>
				</div>
				<div class="cnt_b">
					
					<div class="formRow">
						<div class="input-prepend">
							<span class="add-on"><i class="icon-user"></i></span><input type="text" placeholder="Username" />
						</div>
					</div>
					<div class="formRow">
						<div class="input-prepend">
							<span class="add-on"><i class="icon-lock"></i></span><input type="text" placeholder="Password" />
						</div>
					</div>
					<div class="formRow">
						<div class="input-prepend">
							<span class="add-on">@</span><input type="text" placeholder="Your email address" />
						</div>
						<small>The e-mail address is not made public and will only be used if you wish to receive a new password.</small>
					</div>
					 
				</div>
				<div class="btm_b tac">
					<button class="btn btn-inverse" type="submit">Sign Up</button>
				</div>  
			</form>
			
		</div>
		
		<div class="links_b links_btm clearfix">
			<span class="linkform"><a href="#pass_form">Forgot password?</a></span>
			<span class="linkform" style="display:none">Never mind, <a href="#login_form">send me back to the sign-in screen</a></span>
		</div> 
		
        <footer class="footer">
            <p>
                &copy;2013 <a href="http://www.simetri.web.id/" title="PT Sinar Media Tiga">PT Sinar Media Tiga</a>
                <a href="http://www.lintasgps.com/index.php?desktop=1">Desktop View</a>
            </p>
        </footer>

    </div> <!-- /container -->
    
    <?php $this->load->view( 'common/js' ); ?>
	
    <script type="text/javascript">
        $(document).ready(function() {
			setTimeout('$("html").removeClass("js")', 100);
			
            function L() {
                return arguments[0];
            }

            //* boxes animation
			form_wrapper = $('.login_box');
            $('.linkform a,.link_reg a').on('click',function(e){
				var target	= $(this).attr('href'),
					target_height = $(target).actual('height');
				$(form_wrapper).css({
					'height'		: form_wrapper.height()
				});	
				$(form_wrapper.find('form:visible')).fadeOut(400,function(){
					form_wrapper.stop().animate({
                        height	: target_height
                    },500,function(){
                        $(target).fadeIn(400);
                        $('.links_btm .linkform').toggle();
						$(form_wrapper).css({
							'height'		: ''
						});	
                    });
				});
				e.preventDefault();
			});
			
			alert_wrapper = $('#alert');
			$('#button_submit').click( function( e ) {
			    e.preventDefault();
			    
			    $('#alert').removeClass( 'alert-error' ).addClass('alert-info').html( L('Loading ...') );
			    
			    var act = 'login',
                    uname = $('#username').val(),
                    passwd = $('#password').val(),
                    url = '<?php echo $LinkLogin; ?>',
                    params = { act: act, uname: uname, passwd: passwd };
                
                $.ajax({
                    type: 'GET',
                    dataType: 'json',
                    data: (params),
                    url: url,
                    success: function(data) {
                        if ( data && data.ok == '1') {
                            window.location.href = "./";
                        } else {
                            $('#alert').removeClass( 'alert-info' ).addClass('alert-error').html( L('Login failed, please try again') );
                        }
                    }
                });
			    
                return false;
            })
        });
    </script>
    
  </body>
</html>