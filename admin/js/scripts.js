// $(document).ready(function() {

//   $('#selectAllBoxes').click(function(event){
//     if(this.checked) {
//       $('.checkBoxes').each(function(){
//         this.checked = true;
//       })
//     } else {
//       $('.checkBoxes').each(function(){
//         this.checked = false;
//       })
//     }
//   })
// })
const allBoxes = document.querySelector('#selectAllBoxes');
const checkBoxes = document.querySelectorAll('.checkBoxes');

if (allBoxes){
  const handleAllBoxClick = (e) => {
    if(e.target.checked){
      checkBoxes.forEach(box => box.checked = true)
    } else {
      checkBoxes.forEach(box => box.checked = false)
    }
  }
  
  allBoxes.addEventListener('click', handleAllBoxClick);
}

var div_box = "<div id='load-screen'><div id='loading'></div></div>";

$("body").prepend(div_box);

$("#load-screen").delay(300).fadeOut(600, function(){
  $(this).remove();
});

function loadUsersOnline() {
  $.get("functions.php?onlineusers=result", function(data){
    $(".usersonline").text(data);
  });
}

setInterval(function() {
  loadUsersOnline();
}, 3000);