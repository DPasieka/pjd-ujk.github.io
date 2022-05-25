$(document).ready(function () {
  $(".my-slider").unslider();
  window.scrollTo({top:0})//Scrollowanie strony po odswiezeniu na poczatek
});
//Scrollowanie scrony przez klikniecie przyciskow u gory
function scroolHome(){
  window.scrollTo({
      top:60,
      behavior:'smooth'
  })}
function scroolWydarzenia(){
  window.scrollTo({
      top:1000,
      behavior:'smooth'
  })}
  function scroolCeny(){
    window.scrollTo({
        top:1850,
        behavior:'smooth'
    })}
    function scroolKontakt(){
      window.scrollTo({
          top:2300,
          behavior:'smooth'
      })}
    //Guzik od scrollowania strony do gory

//Wywolanie funkcji pokazanai guzika po scrollowaniu strony o 20 px
window.onscroll = function() {
  scrollFunction();
};

function scrollFunction() {
  if (document.documentElement.scrollTop > 20) {
    document.getElementById("myBtn").style.display = "block";
  } else {
    document.getElementById("myBtn").style.display = "none";
  }
}
function topFunction() {
  window.scrollTo({
    top:0,
    behavior:'smooth'
})
  
}