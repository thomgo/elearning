var $collectionHolder;

// setup an "add a tag" link
var $addTagLink = $('<a href="#" class="add_tag_link">Add a tag</a>');
var $newLinkLi = $('<div></div>').append($addTagLink);

jQuery(document).ready(function() {
    // Get the ul that holds the collection of tags
    $collectionHolder = $('#corebundle_test_testBlocs');

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addTagLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form (see next code block)
        addTagForm($collectionHolder, $newLinkLi);
    });
});

function addTagForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    var newForm = prototype;
    // You need this only if you didn't set 'label' => false in your tags field in TaskType
    // Replace '__name__label__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__label__/g, "<h3 class='questionTitle my-3'>Question : " + (index + 1) + "</h3>");

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index + 1);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<div></div>').append(newForm);

    // also add a remove button, just for this example
    $newFormLi.append('<button type="button" class="deleteButton"><i class="fa fa-trash"></i></button> ');

    // handle the removal and reorder the index
    $('.deleteButton').click(function() {
        $(this).parent().remove();
        $('.questionTitle').each(function(loopIndex) {
          $(this).text("Question : " + (loopIndex + 1));
          $collectionHolder.data('index', loopIndex + 1);
        });
        return false;
    });

    $newLinkLi.before($newFormLi);
}
