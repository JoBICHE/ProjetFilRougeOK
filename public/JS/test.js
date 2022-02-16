"use strict";
window.addEventListener("DOMContentLoaded", (event) => {


    var forScroll = document.getElementById("logo");
  
    window.addEventListener("scroll", function() {
        forScroll.style.transform = "rotate("+window.pageYOffset+"deg)";

    });
   

});