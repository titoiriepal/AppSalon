document.addEventListener("DOMContentLoaded", function() {
    var images = ["1.jpg", "2.jpg", "3.jpg", "4.jpg", "5.jpg", "6.jpg", "7.jpg"]; // Cambia los nombres de las imágenes según tus necesidades
    var currentIndex = Math.floor(Math.random() * 7);
    nextSlide();
    var slideInterval = setInterval(nextSlide, 10000); // Cambia el intervalo de cambio de imagen según tus necesidades (en milisegundos)
  
    function nextSlide() {
      currentIndex = (currentIndex + 1) % images.length;
      var currentImage = document.querySelector('.imagen img:not([style*="opacity: 0"])');
      var nextImage = new Image();
      nextImage.src = '/build/img/' + images[currentIndex];
      nextImage.classList.add('fade-in');
      document.querySelector('.imagen').appendChild(nextImage);
  
      setTimeout(function() {
        currentImage.style.opacity = 0;
        nextImage.style.opacity = 1;
      }, 50);
  
      setTimeout(function() {
        currentImage.parentNode.removeChild(currentImage);
      }, 1000);
    }
  });