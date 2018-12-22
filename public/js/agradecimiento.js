/*
 * Star Wars opening crawl from 1977
 * 
 * I freaking love Star Wars, but could not find
 * a web version of the original opening crawl from 1977.
 * So I created this one.
 *
 * I wrote an article where I explain how this works:
 * http://timpietrusky.com/star-wars-opening-crawl-from-1977
 * 
 * Watch the Start Wars opening crawl on YouTube.
 * https://www.youtube.com/watch?v=7jK-jZo6xjY
 * 
 * Stuff I used:
 * - CSS (animation, transform)
 * - HTML audio (the opening theme)
 * - SVG (the Star Wars logo from wikimedia.org)
 *   http://commons.wikimedia.org/wiki/File:Star_Wars_Logo.svg
 * - JavaScript (to sync the animation/audio)
 *
 * Thanks to Craig Buckler for his amazing article 
 * which helped me to create this remake of the Star Wars opening crawl. 
 * http://www.sitepoint.com/css3-starwars-scrolling-text/ 
 *
 * Sound copyright by The Walt Disney Company.
 * 
 *
 * 2013 by Tim Pietrusky
 * timpietrusky.com
 * 
 */

// Sets the number of stars we wish to display
const numStars = 1000;

// For every star we want to display
for (let i = 0; i < numStars; i++) {
    let star = document.createElement("div");  
    star.className = "star";
    var xy = getRandomPosition();
    star.style.top = xy[0] + 'px';
    star.style.left = xy[1] + 'px';
    document.body.append(star);
}

// Gets random x, y values based on the size of the container
function getRandomPosition() {  
    var y = window.innerWidth;
    var x = window.innerHeight;
    var randomX = Math.floor(Math.random()*x);
    var randomY = Math.floor(Math.random()*y);
    return [randomX,randomY];
}

StarWars = (function() {
  
    /* 
     * Constructor
     */
    function StarWars(args) {
      // Context wrapper
      this.el = $(args.el);
      
      // Audio to play the opening crawl
      this.audio = this.el.find('audio').get(0);
      
      // Start the animation
      this.start = this.el.find('.start');
      
      // The animation wrapper
      this.animation = this.el.find('.animation');
      
      // Remove animation and shows the start screen
      this.reset();
  
      // Start the animation on click
      this.start.bind('click', $.proxy(function() {
        this.start.hide();
        this.audio.play();
        this.el.append(this.animation);
      }, this));
      
      // Reset the animation and shows the start screen
      $(this.audio).bind('ended', $.proxy(function() {
        this.audio.currentTime = 0;
        this.reset();
      }, this));
    }
    
    /*
     * Resets the animation and shows the start screen.
     */
    StarWars.prototype.reset = function() {
      this.start.show();
      this.cloned = this.animation.clone(true);
      this.animation.remove();
      this.animation = this.cloned;
    };
  
    return StarWars;
  })();
  
  new StarWars({
    el : '.starwars'
  });