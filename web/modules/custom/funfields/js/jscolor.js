/**
 * Color pick is from codepen https://codepen.io/naruthk/pen/LzMwWJ
 */
Drupal.behaviors.colorPicker = {
	attach: function (context, settings) {
		once('color-picker', '#grid-wrapper', context).forEach(el => {
      let numberColRow = 5;
      createGrid(numberColRow);
      function createGrid(amount) {
        let divGridWrapper = document.getElementById('grid-wrapper');
        var i = 0;
        for (i; i < (amount * amount); i++) {
          var divTile = document.createElement('div');
          divTile.classList.add("tiles");
          divTile.innerText = i;
          divTile.id = i
          divTile.onmouseover = paintBox;
          divGridWrapper.appendChild(divTile);
        }
      }
      function paintBox() {
        var r = Math.floor(Math.random() * 256);
        var g = Math.floor(Math.random() * 256);
        var b = Math.floor(Math.random() * 256);
        var randomRGB = 'rgb(' + r + ',' + g + ',' + b + ')';
        this.innerText = "";
        this.innerHTML = '<span>rgb(</span>' + r + ', ' + g + ', ' + b + '<span>)</span>';
        this.style.background = randomRGB;
        this.onclick = function() {
          document.execCommand("copy");
        }
        this.addEventListener("copy", function(event) {
          event.preventDefault();
          if (event.clipboardData) {
            event.clipboardData.setData("text/plain", this.textContent);
            alert(randomRGB + " copied to clipboard!")
          }
        });
        this.onmouseout = removeSettings;
      }
      function removeSettings() {
        this.innerText = this.id;
        if (this.id % 2 == 0) {
          this.style.background = '#F8F5EC';
        } else {
          this.style.background = '#fcf9f2';
        }
      }
    });
  }
};
