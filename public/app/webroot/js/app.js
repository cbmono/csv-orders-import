$( document ).ready(function() {
  
  /**
   *  Toggle some content depending on date attribute: toggle-el
   */
  $('.toogle-btn').on('click', function(e) {
    e.preventDefault();

    var btn = $(e.currentTarget);
    var toggleEl = $(btn.data('toggle-el'));
    var icon = btn.find('span.glyphicon').first();

    if (toggleEl.css('display') == 'none') {
      toggleEl.show();
      icon.removeClass('glyphicon-chevron-right').addClass('glyphicon-chevron-left');
    }
    else {
      toggleEl.hide();
      icon.removeClass('glyphicon-chevron-left').addClass('glyphicon-chevron-right');
    }

    btn.blur();
  });


  /**
   * Add filter options to "Orders full list" table
   */
  $('#orders-full-list').DataTable();
});