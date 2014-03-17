$( document ).ready(function() {
  
  /**
   *  Toggle some content depending on date attribute: toggle-el
   */
  $('.toogle-btn').on('click', function(e) {
    e.preventDefault();

    var btn = $(e.currentTarget);
    var toggleEl = $(btn.data('toggle-el'));
    var icon = btn.find('span.glyphicon').first();
    var actionLabel = btn.find('span.action-label').first();
    var tableConatiner = $('.full-list .orders');

    if (toggleEl.css('display') == 'none') {
      toggleEl.show();
      icon.removeClass('glyphicon-chevron-right').addClass('glyphicon-chevron-left');
      actionLabel.text('Hide');
      tableConatiner.removeClass('col-md-12').addClass('col-md-10');
    }
    else {
      toggleEl.hide();
      icon.removeClass('glyphicon-chevron-left').addClass('glyphicon-chevron-right');
      actionLabel.text('Show');
      tableConatiner.removeClass('col-md-10').addClass('col-md-12');
    }

    btn.blur();
  });


  /**
   * Add filter options to "Orders full list" table
   */
  $('#orders-full-list').DataTable();
});