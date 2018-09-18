function deleteItem(button) {
  var parentElement = document.getElementById("parentElement");
  var elementToDelete = button.parentElement;
  $.ajax({
    url: "",
    method: "POST",
    dataType: "json",
    data: {
      itemToDelete: button.value
    },
    async: true,
    success: function(response){
      if(response.success) {
          parentElement.removeChild(elementToDelete);
      }
      else {
        alert("Désolé, nous n'avons pas pu vous retirer de se parcours à cause d'un problème technique, merci d'essayer plus tard")
      }
    },
    cache: false
  });
}
