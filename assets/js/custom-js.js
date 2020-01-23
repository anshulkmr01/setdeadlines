//Navbar Active ..

$( '.navbar-nav li' ).on( 'click', function () {
	$( '.navbar-nav' ).find( 'li.active' ).removeClass( 'active' );
	$( this ).parent( 'li' ).addClass( 'active' );
});

//Confirm Delete //

				$(document).ready(function(){
				    $(".delete").click(function(e){
				        if(!confirm('This will Delete Permanently!')){
				            e.preventDefault();
				            return false;
				        }
				        return true;
				    });
				});

// Toggle Listing //
var acc = document.getElementsByClassName("collapsable-list");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active-list");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight){
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    } 
  });
}

// Search using Name (Filter)
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}

//Table Sorting
// Select all Check Box
$('.selectall').click(function() {
    if ($(this).is(':checked')) {
        $('input:checkbox').attr('checked', true);
    } else {
        $('input:checkbox').attr('checked', false);
    }
});