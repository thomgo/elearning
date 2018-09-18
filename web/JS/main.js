$( "#sortable" ).sortable({
      update: function( event, ui ) {
        Dropped();
      }
    });
$( "#sortable" ).disableSelection();

function Dropped() {
  //Get the order of the elements
  var trElements = document.getElementsByClassName("sortableItem");
  var elementsPosition = {};
  for (var i = 0; i < trElements.length; i++) {
    elementsPosition[i] = trElements[i].children[1].innerHTML;
  }
  //elementsPosition = elementsPosition.toString();

  //Start an ajax request to send the order to the controller
  $.ajax({
    url: "",
    method: "POST",
    dataType: "json",
    data: {
      order: elementsPosition
    },
    async: true,
    cache: false
  });
}
