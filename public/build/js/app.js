document.addEventListener("DOMContentLoaded",(function(){var e=["1.jpg","2.jpg","3.jpg","4.jpg","5.jpg","6.jpg","7.jpg"],t=Math.floor(7*Math.random());n();setInterval(n,1e4);function n(){t=(t+1)%e.length;var n=document.querySelector('.imagen img:not([style*="opacity: 0"])'),o=new Image;o.src="/build/img/"+e[t],o.classList.add("fade-in"),document.querySelector(".imagen").appendChild(o),setTimeout((function(){n.style.opacity=0,o.style.opacity=1}),50),setTimeout((function(){n.parentNode.removeChild(n)}),1e3)}}));