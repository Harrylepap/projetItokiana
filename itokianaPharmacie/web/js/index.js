function Mover(loc,c) {
  this.loc = createVector(width/2, height/2);
  this.vel = createVector();
  this.acc = createVector();
  this.r = random(3,7);
  this.c = c;
  this.alpha = 1;
  
  if (typeof loc !== "undefined") {
    this.loc = createVector(loc.x,loc.y);
  }
  
  this.applyForce = function(a) {
    this.acc.add(a);
  }
  this.update = function() {
    this.vel.add(this.acc);
    this.acc.mult(0);
    
    this.alpha *= .98;
    
    if (this.loc.x < 0 || this.loc.x > width) {
      this.vel.x *= -.8;
      if (this.loc.x < 0) this.loc.x = 0;
      if (this.loc.x > width) this.loc.x = width;
    }
    if (this.loc.y < 0 || this.loc.y > height) {
      this.vel.y *= -.8;
      if (this.loc.y < 0) this.loc.y = 0;
      if (this.loc.y > height) this.loc.y = height;
      
    }
    
    this.loc.add(this.vel);
    
    
    
  }
  this.display = function() {
    fill(this.c, 255,255 , this.alpha);
    noStroke();
    ellipse(this.loc.x,this.loc.y, this.r + (1/this.alpha),this.r + (1/this.alpha));
  }
}

var movers = [];

function setup() {
  colorMode(HSB);
  createCanvas(window.innerWidth,window.innerHeight);       background(50);
  
}

function draw() {
  background(20);
  
  if (mouseDown || frameCount%3==0 ) {    
    for (var x = 0; x < (mouseDown?2:1); x++) {
      
      
      var m = new Mover(createVector(mouseX, mouseY), ((frameCount+128)/ 1 % 360));
      m.applyForce(createVector(random(-1,1), random(-1,1)).mult(.5));
      movers.push(m);
    }
  }
    
  for(var x = movers.length -1; x >= 0; x--) {
    var mov = movers[x];
    
    if (mov.alpha < .001) {
      movers.shift(x);
    } else {
    
      
     // randomize movement a bit:
     mov.applyForce(createVector(random(-1,1), random(-1,1)).mult(.1));

      // enables gravity:
      //mov.applyForce(createVector(0,.25));
      
      mov.update();
      mov.display(); 
    }
  }
  
}

var mouseDown = false;

function mousePressed() {
  mouseDown = true;
}

function mouseReleased() {
  mouseDown = false;
}