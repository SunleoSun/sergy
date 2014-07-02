class AddItemForm
  @initCallbacks:->
    $('#addColor, #addMaterial').click ->
      dropDown = $(this).prev()
      dropDown.after dropDown.clone()

    $('#deleteColor, #deleteMaterial').click ->
      $(this).prev().prev().remove()

    $('#addItem').click ->
      getManyValues = (parent) ->
        children = parent.children '.descr'
        child.value for child in children
      data =
        AddItemForm :
          name: $('#name').val()
          width: $('#width').val()
          length: $('#length').val()
          diameter: $('#diameter').val()
          price: $('#price').val()
          description: $('#description').val()
          category: $('#category').val()
          colors: getManyValues $('.color')
          materials: getManyValues $('.material')
      $.post '/?r=site/additem', data, (resData) ->
        if resData["error"]?
          child = '<div class="error-form">Введите имя</div>'
          $('.description-data-left').prepend(child)
        else
          document.body.innerHTML = resData
$(
  ->
    AddItemForm.initCallbacks()
)