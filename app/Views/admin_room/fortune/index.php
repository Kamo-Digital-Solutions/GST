<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wheel of fortune</title>

    <!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    
    <!-- Custom Style CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css');?>">

    <!-- User View CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/game-view.css'); ?>">

    <!-- User Wheel of fortune view CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/games/wheel-of-fortune.css'); ?>">

    <!-- Roboto Font -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
    <style>
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-3">
                <div class="text-center logo">
                    <img src="<?php echo base_url('assets/images/logo.png'); ?>" alt="">
                </div>

                <!-- Mute Block -->
                <div>
					<textarea id="events_log" readonly></textarea>
                    <p>
                        Mute/lock all players
                    </p>
                    <button class="btn bg_dark_blue game_btn" onclick="mute_user()">Mute all</button>
                    <button class="btn bg_dark_blue game_btn" onclick="unmute_user()">Unmute all</button>
                    <button class="btn bg_dark_blue game_btn" onclick="unlock_buzzers()">Unlock Buzzer</button>
					<button class="btn bg_dark_blue game_btn" onclick="lock_buzzers()">Lock Buzzer</button>
					<!-- <button class="btn bg_dark_blue game_btn" onclick="update_game_users()">Update</button> -->

					<div class="form-group">
						<label for="players">Choose a player:</label>
						
						<select name="players" id="players">
						</select>     
					</div>

					<div class="form-group">
						<label for="players">Score:</label>
                        <input type="text" name="score" id="score">
					</div>

					<button class="btn bg_dark_blue game_btn" onclick="set_score('add')">Add</button>
					<button class="btn bg_dark_blue game_btn" onclick="set_score('sub')">Subtract</button>
                    <button class="btn bg_dark_blue game_btn" onclick="set_spin_access()">Spin Access</button>
                    <button class="btn bg_dark_blue game_btn" onclick="remove_spin_access()">Remove Spin Access</button>
                    <div class="form-group">
						<label for="scores" class="mt-4">Choose teams:</label>

                        <div class="mb-4">
                            <select name="teams-1" id="team-1">

                            </select>

                            <select name="teams-2" id="team-2">

                            </select>

                        </div>

                        <button class="btn bg_dark_blue game_btn" onclick="playing_teams()">Change</button>

					</div>


                    <p id="spin_access">
                        Spin Access: 
                    </p>
					<!-- For OpenVidu -->
					<div id="session">
						<div id="video-container" class="col-md-6 width-all" style="max-width: 100%;"></div>
					</div>


                </div>
            </div>

            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-12">
						<!-- OpenVidu Main Video -->
						<div id="main-video" class="col-md-6 text-center">
						</div>
                        <div id="playArea" style="margin-bottom: 4%;">
                            <button id="spin">spin wheel</button>
                            <button id="vowel">buy vowel</button>
                            <button id="solve">solve puzzle</button>
                            <button id="newpuzzle">new puzzle</button>
                            <div id="moneyArea">Score: $<span id="money">0</span>

                            </div>
                        </div>

                        <div id="main_game">
                            <div id="game">
                                <div id="display"></div>
                                <div class="clear"></div>
                                <div id="tick">⇩</div>
                                <img id="wheel" src="http://i.imgur.com/R7JYazp.png" data-rotation="0" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
    <script src="https://unpkg.com/konva@7.2.0/konva.min.js"></script>

	<script src="<?php echo base_url("assets/js/openvidu-browser-2.15.0.js");?>"></script>
	<script src="<?php echo base_url('assets/js/room-admin.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/Wheel-of-fortune/wheel-admin-view.js'); ?>"></script>

</body>
</html>
