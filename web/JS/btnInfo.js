function deleteItem(button) {
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
}
