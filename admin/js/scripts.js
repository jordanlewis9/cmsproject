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

const handleAllBoxClick = (e) => {
  if(e.target.checked){
    console.log('hi')
    checkBoxes.forEach(box => box.checked = true)
  } else {
    checkBoxes.forEach(box => box.checked = false)
  }
}

allBoxes.addEventListener('click', handleAllBoxClick);