$( "#sortable" ).sortable({
      update: function( event, ui ) {
        Dropped();
      }
    });
$( "#sortable" ).disableSelection();

function Dropped() {
  var trElements = document.getElementsByClassName("sortableItem");
  var elementsPosition = [];
  for (var i = 0; i < trElements.length; i++) {
    var positionAndTrTitle = [i, trElements[i].children[1].innerHTML];
    elementsPosition.push(positionAndTrTitle);
  }
  alert(elementsPosition);
}
