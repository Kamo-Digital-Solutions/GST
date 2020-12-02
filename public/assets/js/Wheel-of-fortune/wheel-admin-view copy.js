$(function() {
    init();
    init_boxes();
});

// Wheel of fortune
var width =  window.innerWidth/4;
var height = window.innerHeight/2;

var global_sentence;
var remaining_sentence;

Konva.angleDeg = false;
var angularVelocity = 6;
var angularVelocities = [];
var lastRotation = 0;
var controlled = false;
var numWedges = 25;
var angularFriction = 0.2;
var target, activeWedge, stage, layer, wheel, pointer;
var finished = false;


function getAverageAngularVelocity() {
  var total = 0;
  var len = angularVelocities.length;

  if (len === 0) {
    return 0;
  }

  for (var n = 0; n < len; n++) {
    total += angularVelocities[n];
  }

  return total / len;
}
function purifyColor(color) {
  var randIndex = Math.round(Math.random() * 3);
  color[randIndex] = 0;
  return color;
}
function getRandomColor() {
  var r = 100 + Math.round(Math.random() * 55);
  var g = 100 + Math.round(Math.random() * 55);
  var b = 100 + Math.round(Math.random() * 55);
  return purifyColor([r, g, b]);
}

function getRandomReward() {
  var mainDigit = Math.round(Math.random() * 9);
  return mainDigit + '\n0\n0';
}
function addWedge(n) {
  var s = getRandomColor();
  var reward = getRandomReward();
  var r = s[0];
  var g = s[1];
  var b = s[2];
  var angle = (2 * Math.PI) / numWedges;

  var endColor = 'rgb(' + r + ',' + g + ',' + b + ')';
  r += 100;
  g += 100;
  b += 100;

  var startColor = 'rgb(' + r + ',' + g + ',' + b + ')';

  var wedge = new Konva.Group({
    rotation: (2 * n * Math.PI) / numWedges,
  });

  var wedgeBackground = new Konva.Wedge({
    radius: 400,
    angle: angle,
    fillRadialGradientStartPoint: 0,
    fillRadialGradientStartRadius: 0,
    fillRadialGradientEndPoint: 0,
    fillRadialGradientEndRadius: 400,
    fillRadialGradientColorStops: [0, startColor, 1, endColor],
    fill: '#64e9f8',
    fillPriority: 'radial-gradient',
    stroke: '#ccc',
    strokeWidth: 2,
  });

  wedge.add(wedgeBackground);

  var text = new Konva.Text({
    text: reward,
    fontFamily: 'Calibri',
    fontSize: 50,
    fill: 'white',
    align: 'center',
    stroke: 'yellow',
    strokeWidth: 1,
    rotation: (Math.PI + angle) / 2,
    x: 380,
    y: 30,
    listening: false,
  });

  wedge.add(text);
  text.cache();

  wedge.startRotation = wedge.rotation();

  wheel.add(wedge);
}
function animate(frame) {
  // handle wheel spin
  var angularVelocityChange =
    (angularVelocity * frame.timeDiff * (1 - angularFriction)) / 1000;
  angularVelocity -= angularVelocityChange;

  // activate / deactivate wedges based on point intersection
  var shape = stage.getIntersection({
    x: stage.width() / 2,
    y: 100,
  });

  if (controlled) {
    if (angularVelocities.length > 10) {
      angularVelocities.shift();
    }

    angularVelocities.push(
      ((wheel.rotation() - lastRotation) * 1000) / frame.timeDiff
    );
  } else {
    var diff = (frame.timeDiff * angularVelocity) / 1000;
    if (diff > 0.0001) {
      wheel.rotate(diff);
    } else if (!finished && !controlled) {
      if (shape) {
        var text = shape.getParent().findOne('Text').text();
        var price = text.split('\n').join('');
        alert('You price is ' + price);
      }
      finished = true;
    }
  }
  lastRotation = wheel.rotation();

  if (shape) {
    if (shape && (!activeWedge || shape._id !== activeWedge._id)) {
      pointer.y(20);

      new Konva.Tween({
        node: pointer,
        duration: 0.3,
        y: 30,
        easing: Konva.Easings.ElasticEaseOut,
      }).play();

      if (activeWedge) {
        activeWedge.fillPriority('radial-gradient');
      }
      shape.fillPriority('fill');
      activeWedge = shape;
    }
  }
}
function init() {
  stage = new Konva.Stage({
    container: 'container',
    width: width,
    height: height,
  });
  layer = new Konva.Layer();
  wheel = new Konva.Group({
    x: stage.width() / 2,
    y: 410,
  });

  for (var n = 0; n < numWedges; n++) {
    addWedge(n);
  }
  pointer = new Konva.Wedge({
    fillRadialGradientStartPoint: 0,
    fillRadialGradientStartRadius: 0,
    fillRadialGradientEndPoint: 0,
    fillRadialGradientEndRadius: 30,
    fillRadialGradientColorStops: [0, 'white', 1, 'red'],
    stroke: 'white',
    strokeWidth: 2,
    lineJoin: 'round',
    angle: 1,
    radius: 30,
    x: stage.width() / 2,
    y: 33,
    rotation: -90,
    shadowColor: 'black',
    shadowOffsetX: 3,
    shadowOffsetY: 3,
    shadowBlur: 2,
    shadowOpacity: 0.5,
  });

  // add components to the stage
  layer.add(wheel);
  layer.add(pointer);
  stage.add(layer);

  // bind events
  wheel.on('mousedown touchstart', function (evt) {
    angularVelocity = 0;
    controlled = true;
    target = evt.target;
    finished = false;
  });
  // add listeners to container
  stage.addEventListener(
    'mouseup touchend',
    function () {
      controlled = false;
      angularVelocity = getAverageAngularVelocity() * 5;

      if (angularVelocity > 20) {
        angularVelocity = 20;
      } else if (angularVelocity < -20) {
        angularVelocity = -20;
      }

      angularVelocities = [];
    },
    false
  );

  stage.addEventListener(
    'mousemove touchmove',
    function (evt) {
      var mousePos = stage.getPointerPosition();
      if (controlled && mousePos && target) {
        var x = mousePos.x - wheel.getX();
        var y = mousePos.y - wheel.getY();
        var atan = Math.atan(y / x);
        var rotation = x >= 0 ? atan : atan + Math.PI;
        var targetGroup = target.getParent();

        wheel.rotation(
          rotation - targetGroup.startRotation - target.angle() / 2
        );
      }
    },
    false
  );

  var anim = new Konva.Animation(animate, layer);

  // wait one second and then spin the wheel
  setTimeout(function () {
    anim.start();
  }, 1000);
}

function move_the_wheel() {
  
  //anim = new Konva.Animation(animate, layer);
  //anim.start();
}

///////////////////////
//// NOT READY YET ////
///////////////////////

function show_random_letter(sentence) {
  sentence = "Hichem Razgallah".toUpperCase();

  found_one = false;
  while(!found_one) {
    letter = Math.floor(Math.random() * (max - 0 + 1)) + 0;

    for(var i = 0; i<global_sentence.length && !found_one; i++) {
      if(global_sentence[i] == c) {
        found_one = true;
        $("#card-n-" + i).text(c);
        nbr++;
      }
    }  
  }
}
//////////////////////////////
//// END OF NOT READY YET ////
//////////////////////////////


function remaining_spaces(sentence, goal) {
  nbr = goal-sentence.length
  to_add = "";
  for(var cm = 0; cm<nbr; cm++) {
    to_add += " ";
  }
  console.log(to_add.length);
  return to_add;
}

function word_to_boxes(sentence) {
  new_sentence = "";
  empty_row = "            ";
  if(sentence.length<12) {
    new_sentence = empty_row + sentence + empty_row + empty_row + remaining_spaces(sentence, 12);
  } else if(sentence.length<24) {
    new_sentence = empty_row + sentence + empty_row + remaining_spaces(sentence, 24);
  } else {
    new_sentence = sentence + remaining_spaces(sentence, 48);
  }

  return new_sentence;
}

function init_boxes(sentence) {
  global_sentence = word_to_boxes("Hichem Razgallah".toUpperCase());
  for(var i = 0; i<global_sentence.length; i++) {
    if(global_sentence[i] == " ")
      $("#words_section .row").append("<div class='col-md-1 free_card' id='card-n-"+i+"'></div>");
    else
      $("#words_section .row").append("<div class='col-md-1 letter_card' id='card-n-"+i+"'></div>");
  }
}

function search_letter_in_boxes(c) {
  var nbr = 0;
  c = c.toUpperCase();

  for(var i = 0; i<global_sentence.length; i++) {
    if(global_sentence[i] == c) {
      $("#card-n-" + i).text(c);
      nbr++;
    }
  }

  alert(nbr);
}

function switch_screens() {
  old_content = $("#main_game").html();
  new_content = $("#game_area").html();
  $("#main_game").html(new_content);
  $("#game_area").html(old_content);
  init();
  update_game_users(); // from room-admin.js
  console.log("Switched");
}