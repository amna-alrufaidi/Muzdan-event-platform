let images = ["event.jpg", "catring.jpg", "designing.jpg", "fotographer.jpg", "place.jpg", "food.jpg", "flo.jpg"];
let index = 0;

setInterval(() => {
  index = (index + 1) % images.length;
  document.getElementById("slider").src = images[index];
}, 3500);
