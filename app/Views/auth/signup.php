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
               <div class="col-md-12">
               </div>
            </div>
            <div class="row">
               <div class="col-md-3"></div>
               <div class="col-md-6">
                  <form action="<?php echo base_url("auth/registration")?>" method="post" enctype="multipart/form-data" class="pt-5 pb-5">
                     <div class="row">
                        <div class="col-md-6">
                           <div class="input-group form-group">
                              <input type="text" class="form-control rounded-0" name="firstname" value="" placeholder="*First Name" required="" pattern="[A-Za-z ]+">
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="input-group form-group">
                              <input type="text" class="form-control rounded-0" name="lastname" value="" placeholder="*Last Name" required="" pattern="[A-Za-z ]+" >
                           </div>
                        </div>
                     </div>
                     <div class="input-group form-group">
                        <input type="email" class="form-control rounded-0" name="email" value="" placeholder="*Email Adress" required="">
                     </div>
                     <div class="form-row">
                        <div class="col-md-4 mb-4">
                           <select class="form-control" id="" name="country" required="">
                              <option value="">Choose Country</option>
                              <option value="usa" selected>USA</option>
                           </select>
                        </div>
                        <div class="col-md-4 mb-4">
                           <select class="form-control" id="" name="state" required="">
                              <option value="">Choose State</option>
                              <option value="state01">State 01</option>
                              <option value="state02">State 02</option>
                           </select>
                        </div>
                        <div class="col-md-4 mb-4">
                           <select class="form-control" id="" name="city" required="">
                              <option value="">Choose City</option>
                              <option value="City0">City 01</option>
                              <option value="City1">City 02</option>
                           </select>
                        </div>
                     </div>
                     <div class="input-group form-group">
                        <select class="form-control" id="" name="chooseteam" required="">
                           <option value="">Choose Team</option>
                           <option value="0">Team A</option>
                           <option value="1">Team B</option>
                        </select>
                     </div>
                     <div class="input-group form-group">
                        <input type="password" class="form-control rounded-0" name="password" value="" placeholder="*Password">
                     </div>
                     <div class="input-group form-group">
                        <input type="password" class="form-control rounded-0" name="confirmpassword" value=""  placeholder="*Confirm Password">
                     </div>
                     <div class="input-group form-group">
                        <div class="custom-file">
                           <input type="file" name="picture" class="custom-file-input" id="" required>
                           <label class="custom-file-label" for="validatedCustomFile">Choose Picture...</label>
                        </div>
                     </div>
                     <div class="form-group">
                        <input type="submit" value="Register" class="btn bg-primary text-white login_btn text-uppercase pl-5 pr-5">
                     </div>
                  </form>
               </div>
               <div class="col-md-3"></div>
            </div>
         </div>
      </div>
   </div>
</div>

