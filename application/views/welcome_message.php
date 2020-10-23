<?php 

//    print_r($output);

?> 
<!-- Star Body Content -->
<div class="section_1 pt-5">
	<div class="container">
		<div class="row">
			
    		<!-- Side Bar -->
			<div class="col-md-3 mb-3">
				<div class="my-2 my-md-0 mr-md-3 pr-3 border_dotted">
					<p class="text-uppercase text-right">
						Game Schedule
					</p>
					<p class="text-right">
						<button class="btn btn_green rounded-0 text-black text-uppercase my-2 my-sm-0" type="submit">
							Registered Teams
						</button>
					</p>
				</div>
			</div>
			
    		<!-- Content Area -->
			<div class="col-md-9 mb-3 heading_blue">
				<div class="row">
					
    				<!-- Box 1 -->
					<div class="col-md-6">

                        <?php 
                             
                        
                        ?>

						<button class="btn btn_light_blue text-uppercase my-2 my-sm-0" type="submit">
                            <?php 
                                if($_SESSION['team_id'] == 0):
                                    echo "Team A";
                                else:
                                    echo "Team B";
                                endif;
                            ?>
						</button>
                        <div class="box_outer mt-1 mb-2 p-3">
                            <div class="row">
                                <?php 
                                  
                                $numOfCols = 3;
                                $rowCount = 0;
                                $bootstrapColWidth = 12 / $numOfCols;
                                                                
                                
                                foreach($output as $result):
                                    ?>
                                        <div class="col-md-<?php echo $bootstrapColWidth; ?>">


                                        <img class="img-fluid" src="<?php echo base_url("assets/upload/").$result['picture']; ?>" alt="">
									<h4><?php echo $result['firstname']; ?></h4>

                                </div>

                                

                                    <?php

$rowCount++;
if($rowCount % $numOfCols == 0): echo '</div><div class="row">'; endif;

                                endforeach;  


                                ?>
                            </div>
                            </div>
                        

					</div>
					
				</div>
				
				
				
			</div>
		</div>
	</div>
</div>	  
	  
	  
