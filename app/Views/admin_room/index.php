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
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-3">
                <div class="text-center logo">
                    <img src="assets/images/logo.png" alt="">
                </div>

                <!-- Mute Block -->
                <div>
                    <p>
                        Mute/lock all players
                    </p>
                    <button class="btn bg_dark_blue game_btn">ON</button>
                    <button class="btn bg_dark_blue game_btn">OFF</button>
                    <button class="btn bg_dark_blue game_btn">Buzzer</button>
                    <div class="col-md-12 mt-4 width-all">
                        <button id="showVideo" class="btn bg_dark_blue game_btn">Open camera</button>
                    </div>

                    <form action="#" method="post">
                        <div class="form-group">
                            <label for="players">Choose a player:</label>

                            <select name="players" id="players">
                              <option value="p1t1">Player-1 Team 1</option>
                              <option value="p2t1">Player-2 Team 1</option>
                              <option value="p3t1">Player-3 Team 1</option>
                              <option value="p4t1">Player-4 Team 1</option>
                              <option value="p1t2">Player-1 Team 2</option>
                              <option value="p2t2">Player-2 Team 2</option>
                              <option value="p3t2">Player-3 Team 2</option>
                              <option value="p4t2">Player-4 Team 2</option>
                            </select>     
                        </div>

                        <div class="form-group">
                            <label for="scores">Choose a score:</label>

                            <select name="scores" id="scores">
                              <option value="200">200</option>
                              <option value="400">400</option>
                              <option value="600">600</option>
                              <option value="800">800</option>
                              <option value="1000">1000</option>
                            </select> 
                        </div>

                        <button class="btn bg_dark_blue game_btn">Add</button>
                        <button class="btn bg_dark_blue game_btn">Subtract</button>
    
                    </form>
					<button class="btn btn-primary" onclick="send_score()">Send Msg</button>
					<!-- For OpenVidu -->
					<div id="session">
						<div id="video-container" class="col-md-6 width-all" style="max-width: 100%;"></div>
					</div>

					<!-- OpenVidu Main Video -->
					<div id="main-video" class="col-md-6 text-center">
						<p class="nickName"></p>
						<p class="userName"></p>
						<video autoplay playsinline="true"></video>
					</div>

                </div>
            </div>

            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-12">
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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
	<script src="<?php echo base_url("assets/js/openvidu-browser-2.15.0.js");?>"></script>
	<script src="<?php echo base_url('assets/js/admin-jeopardy-view.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/room-admin.js'); ?>"></script>

</body>
</html>
