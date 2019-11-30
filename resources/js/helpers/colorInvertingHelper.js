const colorInvertingHelper = (function() {

  return {
    invert: function(color) {
      if (!color) return '#000000';

      color = color.substring(1); // remove #
      if (color.length === 3) {
        color = color[0] + color[0] + color[1] + color[1] + color[2] + color[2];
      }
      color = parseInt(color, 16); // convert to integer
      color = 0xFFFFFF ^ color; // invert three bytes
      color = color.toString(16); // convert to hex
      color = ("000000" + color).slice(-6); // pad with leading zeros
      color = "#" + color; // prepend #

      return color;
    },
  }
})();

export default colorInvertingHelper;