<!-- Star Body Content -->
<div class="section_1 pt-5 mb-5">
   <div class="container">
      <div class="row">
         <!-- BEGIN LOGO -->
         <div class="col-md-12 logo text-center">
            <img class="img-fluid" src="images/logo-login.png" alt=""> 
         </div>
         <div class="col-md-12 bg_light_green pt-5 pb-5 mt-3">
            <div class="row">
               <div class="col-md-3"></div>
               <div class="col-md-6">
                  <form class="pt-5 pb-5" method="post" action="<?php echo base_url("auth/VerifyLogin/")?>">
                     <div class="input-group form-group">
                        <input type="email" value="" name="email" class="form-control rounded-0" placeholder="* Email Adress">
                     </div>
                     <div class="input-group form-group">
                        <input type="password" class="form-control rounded-0" name="password" value="" placeholder="*Password">
                     </div>
                     <div class="row">
                        <div class="col-md-4">
                           <div class="form-group">
                              <input type="submit" value="Login" class="btn w-100 bg-primary text-white text-uppercase login_btn">
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="row align-items-center remember">
                              <input class="text-white" type="checkbox">Remember Me <br>
                              <a class="text-white" href="#"> Forgot Password </a>
                           </div>
                        </div>
                     </div>
                  </form>
               </div>
               <div class="col-md-3"></div>
            </div>
         </div>
      </div>
   </div>
</div>
