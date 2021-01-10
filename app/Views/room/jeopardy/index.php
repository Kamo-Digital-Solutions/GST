<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeopardy</title>

    <!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    
    <!-- Custom Style CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css');?>">

    <!-- User View CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/game-view.css'); ?>">

    <!-- Roboto Font -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet"> 
</head>
<body>
    <div class="container-fluid">
        <div class="text-center logo">
			<img src="<?php echo base_url('assets/images/logo.png'); ?>" alt="The GameShowTime">
			<img src="<?php echo base_url('assets/images/jeopardy.jpeg'); ?>" alt="Jeopardy">
        </div>
        <div id="successMsg">
        </div>
        <div id="errorMsg"></div>
        <div class="gameScreen">
            <div class="row">
                <!-- Team 1-->
                <div class="col-md-2">
                    <div class="row">

                        <!-- Team Title -->
                        <div class="col-md-12 width-all">
                            <div class="text-center teamName text-uppercase">
                                Team 1
                            </div>
                        </div>

                        <!-- Screens -->
                        <div class="screens">
                            <div class="col-md-12 width-all">

								<!-- For OpenVidu -->
								<div id="session">
									<div id="video-container" class="col-md-6 width-all" style="max-width: 100%;"></div>
								</div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Host Screen-->
                <div class="col-md-8">
                    <div class="row">
                            
                            <!-- Screen Header -->
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="text-center title_game_screen text-uppercase">
                                            Survey Says
                                        </div>
                                    </div>
            
                                    <div class="col-md-6">
                                        <div class="text-center title_game_screen text-uppercase">
                                            Round 1 Of 4
                                        </div>
                                    </div> 
                                </div>
                            </div>

                            <!-- Main Screen -->
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12" style="display: flex; justify-content: center;">
                                        <button class="btn bg_dark_blue game_btn" onclick="start_videos()">Start videos</button>
                                    </div>
                                
                                    <div class="col-md-12" style="display: flex; justify-content: center;">
										<div id="main-video">
											<!-- <video autoplay playsinline="true"></video> -->
										</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Game Dashboard -->
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12" style="display: flex; justify-content: center;">
                                            <div class="answer_timer">
                                                5.00
                                            </div>
                                        </div>

                                    <div class="col-md-12" style="display: flex; justify-content: center;">
										<div id="game-dashboard">
                                            <div class="jeopardy">
                                                <div class="jeopardy_boxes">

                                                </div>

                                                <div class="jeopardy_question">

                                                </div>

                                                <div class="jeopardy_answer">
                                                    
                                                </div>
                                            </div>

										</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Box -->
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12 text-center">
										<p>Reply Timer: <span id="timer">5.0</span></p>

                                        <button class="btn bg_dark_blue game_btn text-uppercase">Game Rules</button>
            
                                        <button class="btn btn-danger buzzer_btn text-uppercase" id="buzzer">Buzzer</button>
            
										<button class="btn bg_dark_blue game_btn text-uppercase">About GST</button>
                                    </div> 
                                </div>
                            </div>

                    </div>
                </div>

                <!-- Team 2-->
                <div class="col-md-2">
                    <div class="row">

                        <!-- Team Title -->
                        <div class="col-md-12 width-all">
                            <div class="text-center teamName text-uppercase">
                                Team 2
                            </div>
                        </div>

                        <!-- Screens -->
                        <div class="screens">
							<div id="video-container2" class="col-md-6 width-all" style="max-width: 100%;"></div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
	<!-- Openvidu Integration -->
	<script src="<?php echo base_url("assets/js/openvidu-browser-2.15.0.js");?>"></script>
	<script src="<?php echo base_url("assets/js/room-client.js");?>"></script>
	<script src="<?php echo base_url('assets/js/Jeopardy/jeopardy-game-view.js'); ?>"></script>
	

</body>
</html>
