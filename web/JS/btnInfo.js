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
    cache: false
  });
  parentElement.removeChild(elementToDelete);
}
